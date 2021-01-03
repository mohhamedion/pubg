<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Game;
use App\Models\User;
use App\Models\Settings;
use App\Traits\UserGameTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameController extends Controller
{
    use UserGameTrait;

    protected $user;

    private static $hidden_game_attributes = [
        'created_at',
        'updated_at',
    ];

    private static $hidden_game_pivot_attributes = [
        'game_id',
        'today_times',
        'limit',
        'times',
        'earned',
        'best_score',
        'user_id',
        'last_open',
        'today_earned',
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
        if ($this->user) {
            $this->initGames($this->user);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/games/get",
     *     summary="Get games",
     *     tags={"games"},
     *     operationId="Get games",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Game")
     *         )
     *  ),
     * ),
     */
    public function getGames()
    {
        $games = Game::all();
        $user_games = $this->user->games()->get();
        $gameIds = $user_games->pluck('id');

        foreach ($games as $game) {
            $first = array_first($gameIds, function ($value) use ($game) {
                return $value == $game->id;
            });
            if ($first) {
                continue;
            } else {
                $this->user->games()->attach($game->id);
                $game = $this->user->games($game->id)->get()->map(function ($game) {
                    $game->pivot->last_open = Carbon::now()->toDateString();
                    $game->pivot->save();

                    return $game;
                });
            }
        }

        $this->initGames($this->user);

        $games = $this->user->games()
            ->get()
            ->map(function ($game) {
                $game->makeHidden(self::$hidden_game_attributes);
                $game->pivot->makeHidden(self::$hidden_game_pivot_attributes);

                $game->pivot->is_available = (bool)$game->pivot->is_available;
                $game->pivot->earned = (float)number_format($game->pivot->earned, 2, '.', '');

                return $game;
            });

        return response()->json($games, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/games/update",
     *     summary="Update the game",
     *     tags={"games"},
     *     operationId="Update the game",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of game",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="score",
     *         in="query",
     *         description="score",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *  ),
     *     @SWG\Response(
     *         response=437,
     *         description="This game isn't available now",
     *  ),
     * ),
     */
    public function updateGame(Request $request)
    {
        $game = $this->user->games()->find($request->get('id'));

        if ($game->pivot->is_available == 0) {
            return response()->json(null, 437);
        }

        $rate = Settings::first()->rate;

        $game->pivot->times += 1;
        $game->pivot->earned = (float) number_format($game->pivot->earned, 2, '.', '');
        $user_get = $request->get('score') * $rate;
        $game->pivot->today_earned += $user_get;
        if ($game->pivot->today_earned > 10) {
            $surplus = $game->pivot->today_earned - 10;
            $user_get -= $surplus;
            $game->pivot->today_earned = 10;
            $game->pivot->is_available = false;
        }
        $game->pivot->earned += $user_get;

        $this->user->balance += $user_get;

        if ($request->get('score') != 0) {
            $this->user->logAward($user_get, Award::AWARD_GAME, null);
        }

        $this->user->save();
        if ($request->get('score') > $game->pivot->best_score) {
            $game->pivot->best_score = $request->get('score');
            if (($request->get('score') % 5) == 0) {
                $user_level = $this->user->level()->first();
                $user_level->stars += 1;
                $user_level->save();
                $user_level->check();
            }
        }

        $game->pivot->save();

        return response()->json(['balance' => $this->user->balance], 200);
    }
}
