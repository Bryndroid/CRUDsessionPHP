<?php

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/services.db.php';
require_once __DIR__ . '/../controllers/AuthController.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['email']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Email y contraseña son requeridos'
        ]);
        exit;
    }

    $authController = new AuthController($conn);
    $result = $authController->login($data['email'], $data['password']);

    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
