# Maseta Inteligente

## Descripción

La maseta inteligente sera un sistema automatizado diseñado para monitorear y mantener condiciones ideales para el crecimiento de cualquier planta pequeña.

## Sensores de monitoreo

- **Sensor de Temperatura DHT11**: Mide la temperatura ambiente.
- **Sensor de Humedad del Aire DHT11**: Monitorea la humedad relativa del aire.
- **Sensor de luz**: Mide la cantidad de luz que recibe la planta
- **Sensor de Humedad de Tierra LM393**: Detecta el nivel de humedad de la tierra

## Caracteristicas
- **Pantalla Oled para visualizar los datos**
- **Panel web para visualizar los datos a distancia**

## Conectividad
- **Microcontrolador inalambrico HC-12**
- **Esp32 WIFI**

## Funcionamiento
La maseta usara el Microcontrolador inalambrico HC-12 para enviar los datos a la Esp32 que estara conectada a WIFI, esto permitira mantener la maseta en zonas donde el WIFI no llega.
Gracias a la integracion de nuestra API, los datos pueden ser visualizados y gestionados de forma remota.


![Panel de control](img/maseta_interfaz.png)




