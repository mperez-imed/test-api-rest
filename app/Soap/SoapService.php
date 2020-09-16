<?php

namespace App\Soap;

use Illuminate\Support\Facades\Config;
use SoapClient;
use SoapFault;

class SoapService
{
    private static function execute($operation, $request)
    {
        ini_set("soap.wsdl_cache_enabled", "0");

        $result = new \stdClass;
        $result->status = 500;
        $result->message = "No se pudo ejecutar esta acción";

        try
        {
            $wsdl = Config::get('app.service_wsdl');

            $client = new SoapClient($wsdl, [
                'encoding' => 'UTF-8',
                'trace' => true,
                'location' => 'http://localhost:8000/users',
            ]);

            $response = $client->$operation($request);
            $result->status = $response['status'];
            $result->message = $response['message'];

        } catch (SoapFault $fault) {
            $result->message = "Error al consumir el servicio SOAP";
        }

        return $result;
    }

    public static function validate($rut, $email)
    {
        $request = array(
            'rut' => $rut,
            'email' => $email,
        );

        return self::execute('validate', $request);
    }

    public static function confirm($email)
    {
        $request = array(
            'email' => $email,
        );

        return self::execute('confirm', $request);
    }
}
