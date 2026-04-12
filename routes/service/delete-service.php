<?php
require_once __DIR__ . '/../../config/services.db.php';
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/../../models/service.class.php';
require_once __DIR__ . '/../../helpers/Auth.php';

session_start();
header('Content-Type: application/json');

try {
    // Verificar que es admin
    requireAdmin();

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['idServicio'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'ID del servicio requerido']);
        exit;
    }

    $idServicio = (int)$data['idServicio'];

    // Eliminar el servicio
    Service::eliminar($conn, $idServicio);

    echo json_encode([
        'success' => true,
        'message' => 'Servicio eliminado exitosamente'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
