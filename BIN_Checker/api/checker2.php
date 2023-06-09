<?php

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':


        $body = json_decode(file_get_contents('php://input'), true);
        $BIN = $body['BIN'];

        // URL de la API o el servicio que deseas consumir
        $url = "https://api.bintable.com/v1/" . $BIN . "?api_key=c4f73dba47404d4487a4f34345271c589f8e13c8";
        // Inicializar cURL
        $curl = curl_init($url);


        // Establecer opciones de cURL

        // Devuelve la respuesta como una cadena en lugar de imprimirla directamente.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Establecer el encabezado personalizado
        $headers = array(
            "Content-Type: text/plain"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Habilitar la compresión de respuesta
        curl_setopt($curl, CURLOPT_ENCODING, "");

        // Establecer el número máximo de redireccionamientos a seguir
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        // Establecer el tiempo máximo de espera en segundos
        // Esperará indefinidamente hasta que se establezca la conexión con el servidor
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);

        // Establecer el método de solicitud GET
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");


        // Realizar la solicitud GET
        $response = curl_exec($curl);

        // Verificar si la solicitud fue exitosa
        if ($response === false) {
            $error = curl_error($curl);
            // Manejar el error
        } else {
            // Procesar la respuesta
            echo $response;
        }

        curl_close($curl);

        break;

    default:
        echo "Not Method Allowed";
        break;
}
