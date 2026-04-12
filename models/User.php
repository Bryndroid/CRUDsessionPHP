<?php

class User {
    private $conn;
    private $table = 'usuarios';

    public $IdUser;
    public $Nombre;
    public $Email;
    public $Rol; // 1 = Usuario Registrado, 2 = Administrador

    // Constantes de roles
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Registrar un nuevo usuario
     */
    public function register($nombre, $email, $password) {
        // Validaciones
        if (empty($nombre) || empty($email) || empty($password)) {
            throw new Exception("Todos los campos son requeridos");
        }

        if (strlen($nombre) < 3) {
            throw new Exception("El nombre debe tener al menos 3 caracteres");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El email no es válido");
        }

        if (strlen($password) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres");
        }

        // Verificar si el email ya existe
        if ($this->emailExists($email)) {
            throw new Exception("El email ya está registrado");
        }

        // Cifrar la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario
        $query = "INSERT INTO {$this->table} (Nombre, Email, Password, Rol) 
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
        }

        // Por defecto, nuevos usuarios tienen rol de usuario registrado (1)
        $rol = self::ROLE_USER;
        $stmt->bind_param("sssi", $nombre, $email, $hashed_password, $rol);

        if ($stmt->execute()) {
            $this->IdUser = $this->conn->insert_id;
            return [
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'user_id' => $this->IdUser
            ];
        } else {
            throw new Exception("Error al registrar el usuario: " . $stmt->error);
        }
    }

    /**
     * Login del usuario
     */
    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            throw new Exception("Email y contraseña son requeridos");
        }

        $query = "SELECT IdUser, Nombre, Email, Password, Rol FROM {$this->table} WHERE Email = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Usuario o contraseña incorrectos");
        }

        $user = $result->fetch_assoc();

        // Verificar la contraseña con bcrypt
        if (!password_verify($password, $user['Password'])) {
            throw new Exception("Usuario o contraseña incorrectos");
        }

        // Retornar datos del usuario (sin la contraseña)
        return [
            'success' => true,
            'user_id' => $user['IdUser'],
            'nombre' => $user['Nombre'],
            'email' => $user['Email'],
            'rol' => $user['Rol']
        ];
    }

    /**
     * Verificar si el email existe
     */
    private function emailExists($email) {
        $query = "SELECT IdUser FROM {$this->table} WHERE Email = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}
