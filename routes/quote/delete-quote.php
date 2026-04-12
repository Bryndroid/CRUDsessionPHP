<?php
require_once __DIR__ . '/../../config/services.db.php';
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/../../models/quote.class.php';
require_once __DIR__ . '/../../helpers/Auth.php';
require_once __DIR__. '/../../helpers/secure.php';
iniciarSesionSegura();
header('Content-Type: application/json');

try {
    // Verificar que es admin
    requireAdmin();

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['idCotizacion'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'ID de cotización requerido']);
        exit;
    }

    $idCotizacion = (int)$data['idCotizacion'];

    // Eliminar la cotización
    Quote::eliminar($conn, $idCotizacion);

    echo json_encode([
        'success' => true,
        'message' => 'Cotización eliminada exitosamente'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
