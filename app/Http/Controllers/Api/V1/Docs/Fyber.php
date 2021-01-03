<?php
/**
 * @SWG\Get(
 *     path="/api/v1/fyber/reward",
 *     summary="Server callback for fiber to add reward for user.",
 *     tags={"fyber"},
 *     operationId="fiberReward",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *          name="uid",
 *          in="query",
 *          description="The ID of the user to be credited.",
 *          required=true,
 *          type="integer",
 *      ),
 *     @SWG\Parameter(
 *          name="sid",
 *          in="query",
 *          description="The request signature, which you should verify to ensure the request's authenticity.The sid is computed as a SHA1 hash of the request parameters: id = sha1(security_token + user_id + amount + _trans_id_ + pub0 + pub1 + pub2 + …)",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="amount",
 *          in="query",
 *          description="The amount of virtual currency the user should be credited.",
 *          required=true,
 *          type="number",
 *          format="float",
 *     ),
 *     @SWG\Parameter(
 *          name="currency_name",
 *          in="query",
 *          description="The name of the virtual currency being rewarded as it appears in the Fyber dashboard.",
 *          required=true,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="currency_id",
 *          in="query",
 *          description="The id of the virtual currency being rewarded as it appears in the Fyber dashboard.",
 *          required=true,
 *          type="integer",
 *     ),
 *     @SWG\Parameter(
 *          name="_trans_id_",
 *          in="query",
 *          description="The unique transaction ID in the form of a UUID (“Universally Unique Identifier”). Use this to check whether the transaction has already been processed in your system.",
 *          required=false,
 *          type="string",
 *     ),
 *     @SWG\Parameter(
 *          name="pub0",
 *          in="query",
 *          description="Its custom parameter that contain user email. This email need for callback logic.",
 *          required=true,
 *          type="string",
 *     ),
 *      @SWG\Response(
 *         response=200,
 *         description="Server calback was successfull. Responce data containe mesage about status for transaction.",
 *         @SWG\Schema(
 *               type="string",
 *               example="Callback Successful.",
 *         ),
 *      ),
 *      @SWG\Response(
 *         response=500,
 *         description="Server error.",
 *     ),
 * );
 */
