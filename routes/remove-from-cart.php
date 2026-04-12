<?php
//Se va a reducir codigo en estas rutas, para que ahora ese codigo sea manejado dentro de los controladores!
// remove-from-cart.php
// ---------------------------------------------------------------
// Endpoint para borrar un servicio del carrito. Este script no tiene
// lógica de validación de existencia más allá de comprobar que se
// reciba un id; si el ítem no está presente simplemente permanece
// el carrito como estaba.
//
// La entrada puede venir en formato JSON o como variables POST.
//
// La salida es un JSON con el objeto completo del carrito y los
// totales recalculados.
// ---------------------------------------------------------------
require_once __DIR__ . "/../controllers/CartController.php";
session_start();
header('Content-Type: application/json');


$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

// el id es obligatorio para saber qué eliminar
if (!$id) {
    echo json_encode(["success" => false, "message" => "ID de servicio requerido"]);
    exit;
}
$cartController = new CartController($id);

$cartController->removeService();


