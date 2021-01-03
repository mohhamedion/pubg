<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetIPController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/api/ip/get",
     *     summary="Get the ip",
     *     tags={"users"},
     *     operationId="Get the ip",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *          @SWG\Schema(
     *             type="string",
     *         )
     *     ),
     * ),
     */
    public function get(Request $request)
    {
        $ip = $request->ip();

        return response()->json($ip, 200);
    }
}
