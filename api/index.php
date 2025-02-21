<?php
require_once './helper/cors.php';
require_once './helper/convertirJSON.php';

// Leer la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validar el cuerpo de la solicitud
if (json_last_error() !== JSON_ERROR_NONE) {
    convertirJSON(["estado" => false, "msg" => "Solicitud invalida. Formato JSON incorrecto."], 400);
}

$p = $data['peticion'] ?? null;
$paq = $data['paquete'] ?? null;

if (!isset($paq['tipo_sensor'])) {
    convertirJSON(["estado" => false, "msg" => "Tipo de sensor no especificado."], 400);
}

$sensor = $paq['tipo_sensor'];

try {
    switch ($sensor) {
        case 'DHT11':
            require_once './sensors/DHT11/controller/dhtController.php';
            $controller = new DhtController($p, $paq);
            break;
        default:
            convertirJSON(["estado" => false, "msg" => "Sensor no reconocido: $sensor"], 400);
    }

    // Ejecutar la petición y enviar la respuesta
    $response = $controller->peticiones();
    convertirJSON($response);
} catch (Exception $e) {
    convertirJSON(["estado" => false, "msg" => "Error interno del servidor", "error" => $e->getMessage()], 500);
}