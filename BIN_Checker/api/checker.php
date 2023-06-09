<?php

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':

        $body = json_decode(file_get_contents('php://input'), true);
        $BIN = $body['BIN'];

        //APILayer

        // URL de la API o el servicio que deseas consumir
        $url1 = "https://api.apilayer.com/bincheck/" . $BIN;
        // Inicializar cURL
        $curl1 = curl_init($url1);


        // Establecer opciones de cURL

        // Devuelve la respuesta como una cadena en lugar de imprimirla directamente.
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);

        // Establecer el encabezado personalizado
        $headers1 = array(
            "Content-Type: text/plain",
            "apikey: 9fMTf1NBp7rXx9ux3nRQAPdTjGlaoudd"
        );
        curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers1);

        // Habilitar la compresión de respuesta
        curl_setopt($curl1, CURLOPT_ENCODING, "");

        // Establecer el número máximo de redireccionamientos a seguir
        curl_setopt($curl1, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl1, CURLOPT_FOLLOWLOCATION, true);

        // Establecer el tiempo máximo de espera en segundos
        // Esperará indefinidamente hasta que se establezca la conexión con el servidor
        curl_setopt($curl1, CURLOPT_TIMEOUT, 0);

        // Establecer la versión del protocolo HTTP a utilizar
        curl_setopt($curl1, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        // Establecer el método de solicitud GET
        curl_setopt($curl1, CURLOPT_CUSTOMREQUEST, "GET");


        //BINTable

        // URL de la API o el servicio que deseas consumir
        $url2 = "https://api.bintable.com/v1/" . $BIN . "?api_key=c4f73dba47404d4487a4f34345271c589f8e13c8";
        // Inicializar cURL
        $curl2 = curl_init($url2);


        // Establecer opciones de cURL

        // Devuelve la respuesta como una cadena en lugar de imprimirla directamente.
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);

        // Establecer el encabezado personalizado
        $headers2 = array(
            "Content-Type: text/plain"
        );
        curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers2);

        // Habilitar la compresión de respuesta
        curl_setopt($curl2, CURLOPT_ENCODING, "");

        // Establecer el número máximo de redireccionamientos a seguir
        curl_setopt($curl2, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true);

        // Establecer el tiempo máximo de espera en segundos
        // Esperará indefinidamente hasta que se establezca la conexión con el servidor
        curl_setopt($curl2, CURLOPT_TIMEOUT, 0);

        // Establecer el método de solicitud GET
        curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "GET");


        // 
        // URL de la API o el servicio que deseas consumir
        $url3 = "https://lookup.binlist.net/" . $BIN;
        // Inicializar cURL
        $curl3 = curl_init($url3);


        // Establecer opciones de cURL

        // Devuelve la respuesta como una cadena en lugar de imprimirla directamente.
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER, true);

        // Establecer el encabezado personalizado
        $headers3 = array(
            "Content-Type: text/plain"
        );
        curl_setopt($curl3, CURLOPT_HTTPHEADER, $headers3);

        // Habilitar la compresión de respuesta
        curl_setopt($curl3, CURLOPT_ENCODING, "");

        // Establecer el número máximo de redireccionamientos a seguir
        curl_setopt($curl3, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl3, CURLOPT_FOLLOWLOCATION, true);

        // Establecer el tiempo máximo de espera en segundos
        // Esperará indefinidamente hasta que se establezca la conexión con el servidor
        curl_setopt($curl3, CURLOPT_TIMEOUT, 0);

        // Establecer el método de solicitud GET
        curl_setopt($curl3, CURLOPT_CUSTOMREQUEST, "GET");



        // Crear el multi-cURL handle
        $multiHandle = curl_multi_init();

        // Agregar las dos instancias de cURL al multi-handle
        curl_multi_add_handle($multiHandle, $curl1);
        curl_multi_add_handle($multiHandle, $curl2);
        curl_multi_add_handle($multiHandle, $curl3);

        // Ejecutar las llamadas simultáneamente
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running > 0);

        // Obtener las respuestas de las llamadas
        $response1 = curl_multi_getcontent($curl1);
        $response2 = curl_multi_getcontent($curl2);
        $response3 = curl_multi_getcontent($curl3);


        // Cerrar los handles de cURL
        curl_multi_remove_handle($multiHandle, $curl1);
        curl_multi_remove_handle($multiHandle, $curl2);
        curl_multi_remove_handle($multiHandle, $curl3);
        curl_multi_close($multiHandle);

        //Ivalid BIN
        //APILayer: {"message": "No such BIN (Bank Identification Number) found"}
        //BINTable: {"result":404,"message":"NOT FOUND","data":{}}
        //BINLIST: 

        $json1 = json_decode($response1, true);
        $bank_name1 = $country1 = $bank_url1 = $type1 = $scheme1 = "";

        if (!array_key_exists("message", $json1)) {
            $bank_name1 = $json1["bank_name"];
            $country1 = $json1["country"];
            $bank_url1 = $json1["url"];
            $type1 = $json1["type"];
            $scheme1 = $json1["scheme"];
        }


        $json2 = json_decode($response2, true);
        $bank_name2 = $country2 = $bank_url2 = $type2 = $scheme2 = "";

        if ($json2['result'] == 200) {
            $bank_name2 = $json2["data"]["bank"]["name"];
            $country2 = $json2["data"]["country"]["name"];
            $bank_url2 = $json2["data"]["bank"]["website"];
            $type2 = $json2["data"]["card"]["type"];
            $scheme2 = $json2["data"]["card"]["scheme"];
        }


        $json3 = json_decode($response3, true);
        $bank_name3 = $country3 = $bank_url3 = $type3 = $scheme3 = "";

        if (!empty($json3) && $json3 !== null) {
            $bank_name3 = $json3["bank"]["name"];
            $country3 = $json3["country"]["name"];
            $bank_url3 = $json3["bank"]["url"];
            $type3 = $json3["type"];
            $scheme3 = $json3["scheme"];
        }

        $response = [
            "APILayer" => [
                "bank" => [
                    "name" => $bank_name1,
                    "url" => $bank_url1
                ],
                "country" => $country1,
                "card" => [
                    "type" => $type1,
                    "scheme" => $scheme1
                ]
            ],
            "BINTable" => [
                "bank" => [
                    "name" => $bank_name2,
                    "url" => $bank_url2
                ],
                "country" => $country2,
                "card" => [
                    "type" => $type2,
                    "scheme" => $scheme2
                ]
            ],
            "BINLIST" => [
                "bank" => [
                    "name" => $bank_name3,
                    "url" => $bank_url3
                ],
                "country" => $country3,
                "card" => [
                    "type" => $type3,
                    "scheme" => $scheme3
                ]
            ]
        ];

        echo json_encode($response);
        break;

    default:
        echo "Not Method Allowed";
        break;
}
