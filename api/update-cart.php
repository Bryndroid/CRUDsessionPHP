<?php
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
require_once __DIR__ . '/../clases/service.class.php';
require_once __DIR__ . '/../clases/quote.class.php';
session_start();
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

// si la cantidad solicitada es 0 o negativa, eliminamos el ítem
if ($cantidad < 1) {
    unset($_SESSION['cart'][$id]);
} else {
    $_SESSION['cart'][$id]['cantidad'] = $cantidad;
    if($_SESSION['cart'][$id]['cantidad'] > $_SESSION['cart'][$id]['servicio']["stock"]){
        $_SESSION['cart'][$id]['cantidad'] -= 1;
        echo json_encode(["success" => false, "message" => "Limite de stock"]);
        exit;
    }
}

// recalcular totales para la respuesta
$total = 0;
$count = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['servicio']["precio"] * $item['cantidad'];
    $count += $item['cantidad'];
}

$total =  $total - $total*Quote::calcularDescuento($count);
echo json_encode([
        "success" => true,
        "cart"    => $_SESSION['cart'],
        "total"   => $total,
        "items"   => $count,
        "descuento" => Quote::calcularDescuento($count)
    ]);
    exit;
