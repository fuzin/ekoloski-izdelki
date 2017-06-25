<?php namespace Modules\Billing\Utilities;


class Curl
{
    public function post($url, $payload) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $respone = curl_exec($ch);

        curl_close($ch);

        return $respone;
    }
}