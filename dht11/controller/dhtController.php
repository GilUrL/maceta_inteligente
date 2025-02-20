<?php
require_once '../model/dhtModel.php';
require_once '../../helper/convertirJSON.php';

class DhtController extends dhtModel {
    private $peticion = null;
    private $paquete = null;

    public function __construct($p = null, $paq = null) {
        parent::__construct($paq);
        $this->peticion = $p;
        $this->paquete = $paq;
    }

    public function peticiones() {
        switch ($this->peticion) {
            case 'GuardarDHT':
                return $this->registrarDatosSensor();
            case 'ObtenerLecturasDHT':
                return $this->obtenerLecturasDHT();
            default:
                return convertirJSON(["estado" => false, "msg" => "Petición desconocida"]);
        }
    }
    
    public function obtenerLecturasDHT() {
        $mostrar = $this->obtenerLectura();
        if ($mostrar["estado"]) {
            $respuesta = [
                "estado" => true,
                "msg" => $mostrar['msg'],
                "Datos" => $mostrar['Datos']
            ];
        } else {
            $respuesta = [
                "estado" => false,
                "msg" => "Datos no encontrados",
                "Error" => $mostrar['Error']
            ];
        }
        return convertirJSON($respuesta);
    }


    public function registrarDatosSensor() {
        $insertar = $this->registrarDatos(); 
        if ($insertar["estado"]) {
            $respuesta = ["estado" => true, "msg" => $insertar["msg"]];
        } else {
            $respuesta = ["estado" => false, "msg" => "Error al insertar", "Error" => $insertar['Error']];
        }
        return convertirJSON($respuesta);
    }
}

// Leer el cuerpo de la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$p = isset($data['peticion']) ? $data['peticion'] : null;
$paq = isset($data['paquete']) ? $data['paquete'] : null;

$objDht = new DhtController($p, $paq);

echo $objDht->peticiones();
?>