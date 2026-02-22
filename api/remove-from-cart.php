<?php
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
require_once __DIR__ . '/../clases/service.class.php';
require_once __DIR__ . '/../clases/quote.class.php';
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

// el id es obligatorio para saber qué eliminar
if (!$id) {
    echo json_encode(["success" => false, "message" => "ID de servicio requerido"]);
    exit;
}

// si el ítem está en el carrito, lo borramos
if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
}

// recalcultar totales tras la modificación
$total = 0;
$count = 0;

foreach ($_SESSION['cart'] ?? [] as $item) {
    $total += $item['servicio']['precio'] * $item['cantidad'];
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


