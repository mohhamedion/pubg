<?php
/**
 * @SWG\Definition(
 *     definition="UserResponse",
 *     required={"token","first_promo_code","second_promo_code"},
 *     @SWG\Property(
 *          property="token",
 *          type="string",
 *          example="REOUQXkNLcwo2zgB",
 *     ),
 *     @SWG\Property(
 *          property="first_promo_code",
 *          type="string",
 *          example="REOUQXkNLcwo2zgB",
 *     ),
 *     @SWG\Property(
 *          property="second_promo_code",
 *          type="string",
 *          example="REOUQXkNLcwo2zgB",
 *     ),
 * );
 * @SWG\Get(
 *     path="/api/v1/user/countries",
 *     summary="Return country list",
 *     tags={"user"},
 *     operationId="getCountires",
 *     consumes={"application/json"},
 *     @SWG\Parameter(
 *         name="email",
 *         in="query",
 *         description="Email",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Successful operation, api status provided",
 *         @SWG\Schema(
 *             type="object",
 *             required={"token", "promo_code_first", "promo_code_second","countries"},
 *             @SWG\Property(
 *                  property="token",
 *                  type="string",
 *             ),
 *             @SWG\Property(
 *                  property="first_promo_code",
 *                  type="string",
 *              ),
 *             @SWG\Property(
 *                  property="second_promo_code",
 *                  type="string",
 *             ),
 *             @SWG\Property(
 *                  property="countries",
 *                  type="array",
 *                  @SWG\Items(ref="#/definitions/Country")
 *             ),
 *         )
 *
 *     ),
 * ),
 * * @SWG\Get(
 *     path="/api/v1/user/code-activate",
 *     summary="activate promo code",
 *     tags={"user"},
 *     operationId="activateCode",
 *     consumes={"application/json"},
 *     @SWG\Parameter(
 *          name="promo_code",
 *          in="body",
 *          description="promo code that was given another user.",
 *          required=true,
 *          @SWG\Schema(
 *              type="string",
 *              example="REOUQXkNLcwo2zgB",
 *          ),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Successful operation, api status provided",
 *     ),
 *     @SWG\Response(
 *         response=404,
 *         description="promo code not found.",
 *     ),
 * ),
 * @SWG\Post(
 *     path="/api/v1/user/login",
 *     summary="Authenticate user.",
 *     tags={"user"},
 *     operationId="login",
 *     consumes={"application/json"},
 *     @SWG\Parameter(
 *          name="email",
 *          in="body",
 *          description="email",
 *          required=true,
 *          @SWG\Schema(
 *              type="string",
 *              example="newtestemail@gmail.com",
 *          ),
 *     ),
 *     @SWG\Parameter(
 *          name="username",
 *          in="body",
 *          description="username",
 *          @SWG\Schema(
 *              type="string",
 *              example="Jon",
 *          ),
 *     ),
 *     @SWG\Parameter(
 *          name="country_id",
 *          in="body",
 *          description="Country id",
 *          required=true,
 *          @SWG\Schema(
 *              type="integer",
 *              example=220,
 *          ),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Successful operation, profile data provided.",
 *         @SWG\Schema(
 *             type="object",
 *             ref="#/definitions/UserResponse"
 *         ),
 *      ),
 *     @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *      ),
 *     @SWG\Response(
 *         response=422,
 *         description="Wrong data format.",
 *      ),
 *     );
 */
