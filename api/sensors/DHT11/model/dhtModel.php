<?php
require_once './config/conexion.php';

class dhtModel extends DatabaseDB {
    private $humedad_ambiente;
    private $temperatura_ambiente;
    private $tipo_sensor;

    public function __construct($paquete = null) {
        parent::__construct();

        $this->temperatura_ambiente = $paquete['temperatura_ambiente'] ?? null;
        $this->humedad_ambiente = $paquete['humedad_ambiente'] ?? null;
        $this->tipo_sensor = $paquete['tipo_sensor'] ?? null;
    }

    // Obtener el ID del sensor
    public function obtenerSensorId() {
        try {
            $sql = "SELECT id FROM sensores WHERE tipo = :tipo_sensor";
            $ejecutar = $this->connBD()->prepare($sql);
            $ejecutar->execute([':tipo_sensor' => $this->tipo_sensor]);

            $respuesta = $ejecutar->fetch(PDO::FETCH_ASSOC);

            if ($respuesta) {
                return $respuesta['id'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error en obtenerSensorId: " . $e->getMessage());
            return false;
        }
    }

    // Registrar los datos del sensor en la base de datos
    public function registrarDatos() {
        try {
            $sensor = $this->obtenerSensorId();
            if (!$sensor) {
                return ["estado" => false, "Error" => "Sensor no encontrado en la base de datos"];
            }

            $sql = "INSERT INTO lecturas(sensor_id, temperatura, humedad, fecha_lectura)
                    VALUES (:sensor_id, :temperatura, :humedad, NOW())";
            $ejecutar = $this->connBD()->prepare($sql);
            $valores = [
                ':sensor_id' => $sensor,
                ':temperatura' => $this->temperatura_ambiente,
                ':humedad' => $this->humedad_ambiente
            ];
            $ejecutar->execute($valores);

            if ($ejecutar->rowCount() > 0) {
                return ["estado" => true, "msg" => "Temperatura registrada con éxito"];
            } else {
                return ["estado" => false, "msg" => "No se pudo registrar la temperatura"];
            }
        } catch (PDOException $e) {
            error_log("Error en registrarDatos: " . $e->getMessage());
            return ["estado" => false, "msg" => "Error en la base de datos"];
        }
    }

    // Obtener la última lectura de temperatura y humedad
    public function obtenerLectura() {
        try {
            $sql = "SELECT temperatura, humedad 
                    FROM lecturas 
                    ORDER BY fecha_lectura DESC 
                    LIMIT 1";
            $ejecutar = $this->connBD()->prepare($sql);
            $ejecutar->execute();

            $respuesta = $ejecutar->fetch(PDO::FETCH_ASSOC);

            return ["estado" => True, "msg" => "Datos DHT11 encontrados", "Datos" => $respuesta];
        } catch (PDOException $e) {
            error_log("Error en obtenerLectura: " . $e->getMessage());
            return ["estado" => false, "msg" => "Error en la base de datos"];
        }
    }

}
?>