<?php

class Ucl
{

    private $_url = "localhost:8081/api";

    function curl($payloadBody, $endPoint)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_url . $endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }
}
