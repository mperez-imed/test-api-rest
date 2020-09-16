<?php

namespace App\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;

class ApiRest
{
    public static function request($method, $url, $params)
    {
        $return = new \stdClass();
        $return->message = "";
        $return->status = 500;

        $client = new Client([
            'base_uri' => Config::get('app.api_url'),
            'timeout' => 30.0,
        ]);
        try {
            try {
                try {
                    if ($method == 'GET') {
                        $request = $client->request($method, $url, ['query' => $params]);
                    } else if ($method == 'POST') {
                        $request = $client->request($method, $url, ['json' => $params]);
                    } else {
                        $request = $client->request('PUT', $url, ['json' => $params]);
                    }
                    $response = json_decode($request->getBody()->getContents());
                } catch (RequestException $e) {
                    $response = json_decode($e->getResponse()->getBody()->getContents());
                }
            } catch (ClientException $e) {
                if ($e->getCode() > 0) {
                    $return->status = $e->getCode();
                }
                $return->message = "Error en el cliente REST";
                $response = $return;
            }
        } catch (ConnectException $e) {
            if ($e->getCode() > 0) {
                $return->status = $e->getCode();
            }
            $return->message = "Error de conexión al servicio REST";
            $response = $return;
        }

        return $response;
    }
}
