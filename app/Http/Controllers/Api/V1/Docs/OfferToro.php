<?php
/**
 * @SWG\Get(
 *     path="/api/v1/offertoro/reward",
 *     summary="Server callback for fiber to add reward for user.",
 *     tags={"OfferToro"},
 *     operationId="offertoroReward",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *          name="id",
 *          in="query",
 *          description="The ID of the conversion in OfferToro system.",
 *          required=true,
 *          type="integer",
 *      ),
 *     @SWG\Parameter(
 *          name="oid",
 *          in="query",
 *          description="The ID of the offer converted in our system",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="amount",
 *          in="query",
 *          description="The amount that your user should receive for this conversion nominated in your currency.",
 *          required=true,
 *          type="number",
 *          format="float",
 *     ),
 *     @SWG\Parameter(
 *          name="currency_name",
 *          in="query",
 *          description="The currency name in OfferToro App's Placement page.",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="user_id",
 *          in="query",
 *          description="The id of your user, the one you have placed in the iframe integration.",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="payout",
 *          in="query",
 *          description="The publisher's revenue for this conversion.",
 *          required=false,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="o_name",
 *          in="query",
 *          description="The name of the offer converted.",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="sig",
 *          in="query",
 *          description="A signature to be sure the postback is legit.",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="package_id",
 *          in="query",
 *          description="The package id for the android / iTunes app.",
 *          required=false,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="ip_address",
 *          in="query",
 *          description="IP Address of the user when the click happened.",
 *          required=false,
 *          type="string",
 *     ),
 *      @SWG\Response(
 *         response=200,
 *         description="Server calback was successfull. Responce data containe mesage about status for transaction.",
 *         @SWG\Schema(
 *               type="string",
 *               example=1,
 *         ),
 *      ),
 *      @SWG\Response(
 *         response=500,
 *         description="Server error.",
 *     ),
 * );
 */
