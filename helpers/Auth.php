<?php

/**
 * Middleware para verificar autenticación
 * Uso: requireAuth() en el inicio de una ruta protegida
 */
function requireAuth() {
   
    require_once __DIR__ . '/../config/services.db.php';
    require_once __DIR__ . '/../controllers/AuthController.php';

    if (!AuthController::isAuthenticated()) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Debes iniciar sesión para acceder a este recurso'
        ]);
        exit;
    }
}

/**
 * Middleware para verificar si es administrador
 * Uso: requireAdmin() en el inicio de una ruta solo para admin
 */
function requireAdmin() {
    requireAuth();

    if (!AuthController::isAdmin()) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'No tienes permisos para acceder a este recurso'
        ]);
        exit;
    }
}

/**
 * Obtener el usuario actual
 */
function getCurrentUser() {
    return AuthController::getCurrentUser();
}

/**
 * Verificar si el usuario está autenticado
 */
function isAuthenticated() {
    return AuthController::isAuthenticated();
}

/**
 * Verificar si es administrador
 */
function isAdmin() {
    return AuthController::isAdmin();
}

/**
 * Respuesta JSON estándar
 */
function jsonResponse($success, $message, $data = []) {
    return array_merge(
        [
            'success' => $success,
            'message' => $message
        ],
        $data
    );
}
