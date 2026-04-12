<?php
//Se va a reducir codigo en estas rutas, para que ahora ese codigo sea manejado dentro de los controladores!

require_once __DIR__ . "/../controllers/CartController.php";
session_start();
header('Content-Type: application/json');
try{

    $cartController = new CartController("");
    $cartController->getServices();

}catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

