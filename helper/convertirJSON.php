<?php
/**
 * 📌 convertirJSON
 * 📝 Descripción: Convierte un array o un objeto a formato JSON y lo imprime en el navegador.
 * @param mixed $respuesta - Datos a convertir a JSON.
 * @return string - Datos convertidos en formato JSON.
 */
function convertirJSON($respuesta)
{
    $jsonResponse = json_encode($respuesta);
    header("HTTP/1.1 200 OK");
    header("Content-Type: application/json");
    
    // Hacer echo del JSON y salir
    echo $jsonResponse;
    exit;  // Detener la ejecución del script después de imprimir
}
?>
