<?php

require_once __DIR__ . '/../config/services.db.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $user;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->user = new User($conn);
    }

    /**
     * Procesar el registro de un nuevo usuario
     */
    public function register($nombre, $email, $password, $confirm_password) {
        try {
            // Validar que las contraseñas coincidan
            if ($password !== $confirm_password) {
                return [
                    'success' => false,
                    'message' => 'Las contraseñas no coinciden'
                ];
            }

            // Registrar el usuario
            $result = $this->user->register($nombre, $email, $password);

            return [
                'success' => true,
                'message' => 'Usuario registrado exitosamente. Puedes iniciar sesión.',
                'user_id' => $result['user_id']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Procesar el login de un usuario
     */
    public function login($email, $password) {
        try {
            $result = $this->user->login($email, $password);

            if ($result['success']) {
                // Iniciar sesión
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['rol'] = $result['rol'];
                $_SESSION['logged_in'] = true;

                return [
                    'success' => true,
                    'message' => 'Inicio de sesión exitoso',
                    'user' => [
                        'id' => $result['user_id'],
                        'nombre' => $result['nombre'],
                        'email' => $result['email'],
                        'rol' => $result['rol']
                    ]
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        session_destroy();
        return [
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ];
    }

    /**
     * Verificar si el usuario está autenticado
     */
    public static function isAuthenticated() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Verificar si el usuario es administrador
     */
    public static function isAdmin() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] == "admin";
    }

    /**
     * Obtener los datos del usuario actual
     */
    public static function getCurrentUser() {
        if (self::isAuthenticated()) {
            return [
                'id' => $_SESSION['user_id'],
                'nombre' => $_SESSION['nombre'],
                'email' => $_SESSION['email'],
                'rol' => $_SESSION['rol']
            ];
        }
        return null;
    }
}
