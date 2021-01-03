<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 10.12.18
 * Time: 11:07
 */

namespace App\Helpers\Api\V1;

use App\Models\LevelLimit;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class LoginHelper
 *
 * @package App\Helpers\Api\V1
 */
class LoginHelper
{
    /**
     * @var \App\Models\User|null
     */
    private $user = null;

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $country_id = 219;

    /**
     * LoginHelper constructor.
     *
     * @param string $email
     * @param string $username
     * @param int    $country_id
     */
    public function __construct(string $email, string $username = '', int $country_id = 219)
    {
        $this->email = $email;

        $this->country_id = $country_id;

        $this->name = $username;

        $this->user = User::whereEmail($email)
            ->first();
    }

    /**
     * @param string $username
     *
     * @return LoginHelper
     */
    public function setUsername(string $username): LoginHelper
    {
        $this->name = $username;

        return $this;
    }

    /**
     * @param int $country_id
     *
     * @return LoginHelper
     */
    public function setCountryId(int $country_id): LoginHelper
    {
        $this->country_id = $country_id;

        return $this;
    }


    /**
     * Return access token for user.
     *
     * @return array
     */
    public function login(): array
    {
        if (! is_null($this->user)) {
            return $this->getToken();
        }

        return $this->register();
    }

    /**
     * If user was found in db return existence token.
     *
     * @return string
     */
    private function getToken(): array
    {
        return [
            'token' => $this->user->token,
            'first_promo_code' => $this->user->promo_code_first,
            'second_promo_code' => $this->user->promo_code_second,
        ];
    }

    /**
     * If user not found in db create new user.
     *
     *
     * @return array
     */
    private function register(): array
    {
        $this->user = new User();

		 $this->user->fill([
            'name'              => $this->name,
            'email'             => $this->email,
            'token'             => str_random(),
            'promo_code_first'  => str_random(),
            'promo_code_second' => str_random(),
        ]);
$this->user->save();
        $this->user->marathons()
            ->attach(1);

        $this->user->roles()
            ->attach(Role::USER_ROLE_ID);

        $limit = LevelLimit::whereLevel(1)
            ->first();

        $this->user->level()
            ->create([
                'task'     => serialize([0, $limit->task, 1, 3]),
                'video'    => serialize([0, $limit->video, 1, 3]),
                'partner'  => serialize([0, $limit->partner, 1, 3]),
                'referral' => serialize([0, $limit->referral, 1, 3]),
            ]);

        $this->user->videoLimit()
            ->create([
                'limit'     => 100,
                'last_open' => Carbon::now()
                    ->toDateString(),
            ]);

        for ($i = 1; $i < 6; $i++) {
            $this->user->quizzes()
                ->attach($i);
        }

        $this->user->country_id = $this->country_id;

        $this->user->save();

        return $this->getToken();
    }
}