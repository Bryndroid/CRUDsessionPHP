# 🛡️ CA Security – Sistema Web de Cotizaciones

CA Security es un sistema web desarrollado en PHP 8 utilizando Programación Orientada a Objetos (POO) y JavaScript con comunicación asíncrona mediante Fetch API (AJAX). La aplicación permite gestionar un catálogo de servicios, agregar elementos a un carrito dinámico y generar cotizaciones persistentes utilizando sesiones PHP, sin necesidad de base de datos. El sistema fue diseñado con un enfoque académico y profesional, aplicando buenas prácticas de arquitectura modular y separación de responsabilidades.

## Lógica 
El proyecto implementa clases como `Service` y `Quote`, haciendo uso de encapsulación, métodos estáticos y constantes. Además, incorpora validación dual: en el frontend mediante JavaScript para mejorar la experiencia del usuario, y en el backend con PHP para garantizar la integridad de los datos. La comunicación entre cliente y servidor se realiza a través de múltiples endpoints que intercambian información en formato JSON.

 ## AJAX con PHP
El carrito de compras funciona en tiempo real sin recargar la página gracias al consumo de PHP con fetch, trabajando asi con la teoría de AJAX. permitiendo agregar, eliminar y actualizar servicios dinámicamente. El sistema realiza cálculos automáticos de subtotales, totales y cantidades de ítems, genera códigos únicos de cotización y mantiene un historial de cotizaciones almacenado en `$_SESSION`, demostrando el manejo correcto de persistencia en aplicaciones web sin base de datos.

## Ejecución

Para ejecutar el proyecto se requiere PHP 8 o superior y un servidor local como XAMPP, Laragon o similar. Basta con clonar el repositorio, colocarlo en el directorio del servidor (por ejemplo, `htdocs`), iniciar Apache y acceder desde el navegador mediante `http://localhost/`. El proyecto demuestra dominio en POO, validación de formularios, manejo de JSON, manipulación dinámica del DOM y gestión de estado en aplicaciones web modernas.