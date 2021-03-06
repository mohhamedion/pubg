<?php
/**
 * @SWG\Definition(
 *     definition="UseRequest",
 *     @SWG\Property(
 *          property="ud",
 *          type="int",
 *          example=1,
 *     ),
 *     @SWG\Property(
 *          property="data",
 *          type="string",
 *          example="+380966666666",
 *     ),
 * ),
 * @SWG\Definition(
 *     definition="BayRequest",
 *     @SWG\Property(
 *          property="amount",
 *          type="number",
 *          format="float",
 *          example=1000.00,
 *     ),
 *     @SWG\Property(
 *          property="method_id",
 *          type="integer",
 *          example=1,
 *     ),
 * ),
 * @SWG\Definition(
 *     definition="PaymentSystems",
 *     @SWG\Property(
 *          property="methods",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/PaymentSystem"),
 *     ),
 *     @SWG\Property(
 *          property="nominals",
 *          type="array",
 *          @SWG\Items(
 *              type="number",
 *              format="float",
 *              example=1000.00,
 *          )
 *     ),
 *     @SWG\Property(
 *          property="rate",
 *          type="float",
 *          example=1.00,
 *     ),
 * ),
 * @SWG\Definition(
 *     definition="PaymentSystem",
 *     @SWG\Property(
 *          property="id",
 *          type="int",
 *          example=1,
 *     ),
 *     @SWG\Property(
 *          property="title",
 *          type="string",
 *          example="WebMoney",
 *     ),
 *     ),
 * @SWG\Definition(
 *     definition="InventoryItem",
 *     @SWG\Property(
 *          property="ud",
 *          type="int",
 *          example=1,
 *     ),
 *     @SWG\Property(
 *          property="amount",
 *          type="number",
 *          format="float",
 *          example=1000.00,
 *     ),
 *     @SWG\Property(
 *          property="method_name",
 *          type="string",
 *          example="WebMoney",
 *     ),
 *     @SWG\Property(
 *          property="method_id",
 *          type="integer",
 *          example=12,
 *     ),
 * );
 *
 * @SWG\Definition(
 *     definition="BalanceResponse",
 *     required={"balance"},
 *     @SWG\Property(
 *          property="balance",
 *          type="number"
 *      )
 * ),
 * @SWG\Definition(
 *     definition="BalanceDetails",
 *     @SWG\Property(
 *          property="balance",
 *          type="number",
 *          format="float",
 *          example=1234.56,
 *     ),
 *     @SWG\Property(
 *          property="paid",
 *          type="number",
 *          format="float",
 *          example=1234.56,
 *     ),
 *  ),
 * @SWG\Definition(
 *     definition="ReferralBalance",
 *     @SWG\Property(
 *          property="referrals",
 *          type="object",
 *          ref="#/definitions/Referrals",
 *     ),
 *     @SWG\Property(
 *          property="balance",
 *          type="number",
 *          format="float",
 *          example=1234.56,
 *     ),
 *     @SWG\Property(
 *          property="award",
 *          type="number",
 *          format="float",
 *          example=20.00,
 *     ),
 *     @SWG\Property(
 *          property="paid",
 *          type="number",
 *          format="float",
 *          example=1234.56,
 *     ),
 *  ),
 * @SWG\Definition(
 *     definition="Referrals",
 *     required={"current","max","percent"},
 *     @SWG\Property(
 *          property="level",
 *          type="integer",
 *          example=2,
 *     ),
 *     @SWG\Property(
 *          property="current",
 *          type="integer",
 *          example=2,
 *     ),
 *     @SWG\Property(
 *          property="max",
 *          type="integer",
 *          example=3,
 *     ),
 *     @SWG\Property(
 *          property="percent",
 *          type="integer",
 *          example=60,
 *     ),
 * );
 * @SWG\Get(
 *     path="/api/v1/balance/",
 *     summary="Get profile balance",
 *     tags={"balance"},
 *     operationId="balance",
 *     produces={"application/json"},
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
 *             type="intefer",
 *              example=1234.99,
 *         )
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 *);
 * @SWG\Get(
 *     path="/api/v1/balance/details",
 *     summary="Get details profile balance.",
 *     tags={"balance"},
 *     operationId="balance",
 *     produces={"application/json"},
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
 *             ref="#/definitions/BalanceDetails",
 *         )
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 *);
 * @SWG\Get(
 *     path="/api/v1/balance/referral",
 *     summary="Get referal profile balance.",
 *     tags={"balance"},
 *     operationId="balance",
 *     produces={"application/json"},
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
 *             ref="#/definitions/ReferralBalance",
 *         )
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 *);
 * @SWG\Get(
 *     path="/api/v1/balance/methods",
 *     summary="get information about paymant methods",
 *     tags={"balance"},
 *     operationId="paymantSystems",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *          name="token",
 *          in="header",
 *          description="token",
 *          required=true,
 *          type="string",
 *      ),
 *      @SWG\Response(
 *         response=200,
 *         description="Successful operation, balance value provided.",
 *          @SWG\Schema(
 *               type="object",
 *               ref="#/definitions/PaymentSystems",
 *         )
 * ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 * );
 * @SWG\Get(
 *     path="/api/v1/balance/inventory",
 *     summary="get information about paymant cards in user inventoy.",
 *     tags={"balance"},
 *     operationId="userPaymentInventory",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *          name="token",
 *          in="header",
 *          description="token",
 *          required=true,
 *          type="string",
 *      ),
 *      @SWG\Response(
 *         response=200,
 *         description="Successful operation, balance value provided.",
 *         @SWG\Schema(
 *               type="array",
 *               @SWG\Items(ref="#/definitions/InventoryItem")
 *         )
 *
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 * );
 * @SWG\Post(
 *     path="/api/v1/balance/buy",
 *     summary="Endpoint for buy payment card.",
 *     tags={"balance"},
 *     operationId="buyPaymentCard",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Parameter(
 *          name="token",
 *          in="header",
 *          description="token",
 *          required=true,
 *          type="string",
 *      ),
 *     @SWG\Parameter(
 *          name="",
 *          in="body",
 *          description="data",
 *          required=true,
 *          @SWG\Schema(
 *               type="object",
 *               ref="#/definitions/BayRequest"
 *         )
 *     ),
 *      @SWG\Response(
 *         response=200,
 *         description="Successful operation, balance value provided.",
 *
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 *     @SWG\Response(
 *         response=412,
 *         description="Balance less of nominal.",
 *     ),
 * );
 * @SWG\Post(
 *     path="/api/v1/balance/use",
 *     summary="Endpoint for use payment card.",
 *     tags={"balance"},
 *     operationId="usePaymentCard",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Parameter(
 *          name="token",
 *          in="header",
 *          description="token",
 *          required=true,
 *          type="string",
 *      ),
 *     @SWG\Parameter(
 *          name="",
 *          in="body",
 *          description="data",
 *          required=true,
 *          @SWG\Schema(
 *               type="object",
 *               ref="#/definitions/UseRequest"
 *         )
 *     ),
 *      @SWG\Response(
 *         response=200,
 *         description="Successful operation, balance value provided.",
 *
 *      ),
 *      @SWG\Response(
 *         response=401,
 *         description="Wrong token.",
 *     ),
 *     @SWG\Response(
 *         response=415,
 *         description="Card was used.",
 *     ),
 *     @SWG\Response(
 *         response=417,
 *         description="Data format is wrong.",
 *     ),
 * );
 */
