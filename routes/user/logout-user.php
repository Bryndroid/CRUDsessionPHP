<?php

require_once __DIR__. '/../../helpers/secure.php';
iniciarSesionSegura();
header('Content-Type: application/json');

try {
    // Destruir la sesión
    session_destroy();

    echo json_encode([
        'success' => true,
        'message' => 'Sesión cerrada exitosamente'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al cerrar sesión: ' . $e->getMessage()
    ]);
}
