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

    // Validar datos requeridos
    $idServicio = isset($data['idServicio']) ? (int)$data['idServicio'] : null;
    $nombre = trim($data['nombre'] ?? '');
    $descripcion = trim($data['descripcion'] ?? '');
    $precio = isset($data['precio']) ? (float)$data['precio'] : null;
    $idCategoria = isset($data['idCategoria']) ? (int)$data['idCategoria'] : null;

    if ($idServicio === null || empty($nombre) || empty($descripcion) || $precio === null || $idCategoria === null) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son requeridos'
        ]);
        exit;
    }

    // Actualizar el servicio
    $servicio = Service::actualizar($conn, $idServicio, $nombre, $descripcion, $precio, $idCategoria);

    echo json_encode([
        'success' => true,
        'message' => 'Servicio actualizado exitosamente',
        'servicio' => $servicio->jsonSerialize()
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
