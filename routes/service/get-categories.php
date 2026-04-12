<?php
require_once __DIR__ . '/../../models/service.class.php';

header('Content-Type: application/json');

try {
    $categorias = Service::obtenerCategorias();

    echo json_encode([
        'success' => true,
        'categorias' => $categorias
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
