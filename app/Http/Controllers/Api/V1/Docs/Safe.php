<?php
/**
 * @SWG\Definition(
 *     definition="SafeProgress",
 *     required={"token","first_promo_code","second_promo_code"},
 *     @SWG\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *     ),
 *     @SWG\Property(
 *          property="title",
 *          type="string",
 *          example="some title",
 *     ),
 *     @SWG\Property(
 *          property="current",
 *          type="integer",
 *          example=2,
 *     ),
 *     @SWG\Property(
 *          property="max",
 *          type="integer",
 *          example=5,
 *     ),
 *     @SWG\Property(
 *          property="status",
 *          type="integer",
 *          example=1,
 *          description="can be 0,1 or 2. 1 means you can get award about current day, 0 means you cant get award about current day and 2 means what this marathon done, and new marathon no find.",
 *     ),
 *     @SWG\Property(
 *          property="award",
 *          type="array",
 *          description="the number of elements is the same as the value of the max property, first item award for first day second for second dey etc.",
 *          @SWG\Items(
 *              type="number",
 *              format="float",
 *              example=1234.56,
 *          ),
 *     ),
 * );
 * @SWG\Get(
 *     path="/api/v1/safe/progress",
 *     summary="Get safe progress",
 *     tags={"safe"},
 *     operationId="safeProgress",
 *     @SWG\Parameter(
 *          name="token",
 *          in="header",
 *          description="token",
 *          required=true,
 *          type="string",
 *      ),
 *     @SWG\Response(
 *         response=200,
 *         description="Successful operation, balance value provided.",
 *         @SWG\Schema(
 *             type="object",
 *             ref="#/definitions/SafeProgress"
 *         )
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 * ),
 * @SWG\Get(
 *     path="/api/v1/safe/checkpoint",
 *     summary="Get safe checkpoint",
 *     tags={"safe"},
 *     operationId="safeCheckpoint",
 *     @SWG\Parameter(
 *          name="token",
 *          in="header",
 *          description="token",
 *          required=true,
 *          type="string",
 *      ),
 *     @SWG\Parameter(
 *          name="id",
 *          in="query",
 *          description="id",
 *          required=true,
 *          type="integer",
 *      ),
 *     @SWG\Response(
 *         response=200,
 *         description="Successful operation, balance value provided.",
 *         @SWG\Schema(
 *             type="integer",
 *              example=1234.99,
 *         )
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 *     @SWG\Response(
 *         response=467,
 *         description="Safe already has been passed",
 *     ),
 * );
 */
