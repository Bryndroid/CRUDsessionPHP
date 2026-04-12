<?php

require_once __DIR__. '/../../helpers/secure.php';
iniciarSesionSegura();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/services.db.php';
require_once __DIR__ . '/../../controllers/AuthController.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    

    if (!isset($data['nombre']) || !isset($data['email']) || !isset($data['password']) || !isset($data['confirm_password'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son requeridos'
        ]);
        exit;
    }

    $authController = new AuthController($conn);
    $result = $authController->register($data['nombre'], $data['email'], $data['password'], $data['confirm_password']);

    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

