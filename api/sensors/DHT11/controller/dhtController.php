<?php
require_once './sensors/DHT11/model/dhtModel.php';
require_once './helper/convertirJSON.php';

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
                return convertirJSON(["estado" => false, "msg" => "Petición desconocida"], 400);
        }
    }
    
    public function obtenerLecturasDHT() {
        try {
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
        } catch (Exception $e) {
            return convertirJSON(["estado" => false, "" => "Error interno", "Error" => $e->getMessage()]);
        }
    }

    public function registrarDatosSensor() {
        try {
            $insertar = $this->registrarDatos(); 
            if ($insertar["estado"]) {
                $respuesta = ["estado" => true, "msg" => $insertar["msg"]];
            } else {
                $respuesta = ["estado" => false, "msg" => "Error al insertar", "Error" => $insertar['Error']];
            }
            return convertirJSON($respuesta);
        } catch (Exception $e) {
            return convertirJSON(["estado" => false, "msg" => "Error interno", "Error" => $e->getMessage()]);
        }
    }
}
?>
