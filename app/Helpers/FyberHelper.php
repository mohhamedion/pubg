<?php

namespace App\Helpers;

use UnexpectedValueException;

class FyberHelper
{
    /**
     * Fyber server-side callback after User did offerwall.
     * Validate request signature, which should verify to ensure the request's authenticity.
     *
     * @param array $dataSet
     * @throws UnexpectedValueException
     */
    public static function validateDigitalSign(array $dataSet)
    {
        $sid = $dataSet['sid'];

        $security_token = env('FYBER_SECURITY_TOKEN');

        $hash = sha1($security_token . $dataSet['uid'] . $dataSet['amount'] . $dataSet['_trans_id_']);

        if ($sid !== $hash) {
            throw new UnexpectedValueException('Invalid digital sign', 400);
        }
    }
}
