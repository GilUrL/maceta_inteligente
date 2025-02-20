# Maseta Inteligente

## Descripción

La maseta inteligente es un sistema automatizado diseñado para monitorear y mantener condiciones ideales para el crecimiento de las plantas. Está equipada con un microcontrolador **ESP32** que le proporciona conectividad WiFi para enviar datos en tiempo real. El sistema incluye tres sensores que permiten medir parámetros clave del ambiente de la planta:

- **Sensor de Temperatura**: Mide la temperatura ambiente.
- **Sensor de Humedad del Aire**: Monitorea la humedad relativa del aire.
- **Sensor de Humedad de Tierra**: Determina el nivel de humedad en el sustrato de la planta.

Estos datos pueden ser visualizados y gestionados de forma remota, permitiendo alertas personalizadas y un seguimiento continuo del estado de la planta.

## Características

- Conexión WiFi a través del microcontrolador ESP32.
- Medición en tiempo real de temperatura, humedad ambiental y humedad del sustrato.
- Visualización de datos en paneles de control remotos.
- Alertas configurables para niveles fuera de los parámetros ideales.

## Requisitos

- **ESP32**.
- **Sensores**:
  - Sensor de temperatura.
  - Sensor de humedad del aire.
  - Sensor de humedad de tierra.
- Conexión a red WiFi.

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/maseta-inteligente.git
