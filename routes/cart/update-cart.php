<?php
//Se va a reducir codigo en estas rutas, para que ahora ese codigo sea manejado dentro de los controladores!
// update-cart.php
// ---------------------------------------------------------------
// Ajusta la cantidad de un servicio ya presente en el carrito de la
// sesión. Si la nueva cantidad es menor que 1 se borra el elemento.
//
// Entrada:
//    id       -> string (identificador del servicio)
//    cantidad -> entero
// Respuesta: JSON con carrito y totales como en add-to-cart.
// ---------------------------------------------------------------
require_once __DIR__ . "/../../controllers/CartController.php";
require_once __DIR__. '/../../helpers/secure.php';
iniciarSesionSegura();
header('Content-Type: application/json');

// leer parámetros (acepta JSON y POST)
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;
$cantidad = isset($input['cantidad']) ? (int)$input['cantidad'] : null;

// validaciones básicas
if (!$id || $cantidad === null) {
    echo json_encode(["success" => false, "message" => "ID y cantidad requeridos"]);
    exit;
}

if (!isset($_SESSION['cart'][$id])) {
    echo json_encode(["success" => false, "message" => "Artículo no existe en el carrito"]);
    exit;
}

$cartController =  new CartController($id);
$cartController->patchService($cantidad);
