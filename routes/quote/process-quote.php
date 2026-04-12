<?php
// process-quote.php
// ---------------------------------------------------------------
// Esta ruta transforma el contenido del carrito en una cotización
// Delega la lógica al QuoteController
//
// Entrada (JSON):
//    nombre -> nombre del cliente
//    email  -> correo electrónico
//    empresa (opcional) -> empresa del cliente
//    telefono (opcional) -> teléfono del cliente
//
// ---------------------------------------------------------------
require_once __DIR__ . '/../../config/services.db.php';
require_once __DIR__ . '/../../controllers/QuoteController.php';
require_once __DIR__. "/../../helpers/Auth.php";

require_once __DIR__. '/../../helpers/secure.php';
iniciarSesionSegura();
header('Content-Type: application/json');

// Obtener datos del request
$input = json_decode(file_get_contents('php://input'), true);

$nombre = $input['nombre'] ?? '';
$email = $input['email'] ?? '';
$empresa = $input['empresa'] ?? '';
$telefono = $input['telefono'] ?? '';

// Validar que existe carrito)
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(["success" => false, "message" => "Carrito vacío"]);
    exit;
}

requireAuth();

// Crear controlador y procesar la cotización
$quoteController = new QuoteController($conn);
$resultado = $quoteController->crearCotizacion(
    $_SESSION["nombre"],
    $_SESSION["email"],
    $_SESSION['cart'],
    $empresa,
    $telefono,
    $_SESSION['user_id'] ?? null  // Si existe usuario autenticado
);

echo json_encode($resultado);