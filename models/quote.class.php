<?php
require_once __DIR__ . "/../config/services.db.php";
require_once __DIR__ . "/QuoteDetail.php";

class Quote {
    private $conn;
    private $table = 'cotizaciones';

    public $IdCotizacion;
    public $Codigo;
    public $NombreCliente;
    public $Email;
    public $Empresa;
    public $Correo;
    public $Telefono;
    public $Subtotal = 0;
    public $Descuento = 0;
    public $Iva = 0;
    public $Total = 0;
    public $FechaCreacion;
    public $FechaValidez;
    public $IdUser;

    private $items = [];
    private $cantidadTotal = 0;
    private $quoteDetail;

    const PRECIO_MAXIMO = 10000;
    const IVA_PORCENTAJE = 0.13;

    public function __construct($conn, $nombreCliente, $email, $empresa = '', $telefono = '', $idUser = null) {
        $this->conn = $conn;
        $this->NombreCliente = trim($nombreCliente);
        $this->Email = trim($email);
        $this->Empresa = trim($empresa);
        $this->Correo = trim($email);
        $this->Telefono = trim($telefono);
        $this->IdUser = $idUser;
        $this->Codigo = self::generarCodigo();
    }

    /**
     * Establecer los items del carrito
     */
    public function setItems($cartItems) {
        $this->items = $cartItems;
        $this->calcularTotales();
    }

    /**
     * Calcular subtotal, descuento, IVA y total
     */
    private function calcularTotales() {
        $this->Subtotal = 0;
        $this->cantidadTotal = 0;

        // Calcular subtotal y cantidad total
        foreach ($this->items as $item) {
            $this->Subtotal += $item['servicio']['precio'] * $item['cantidad'];
            $this->cantidadTotal += $item['cantidad'];
        }

        // Calcular descuento según cantidad
        $this->Descuento = $this->Subtotal * self::calcularPorcentajeDescuento($this->cantidadTotal);

        // Calcular IVA sobre subtotal
        $this->Iva = $this->Subtotal * self::IVA_PORCENTAJE;

        // Calcular total
        $this->Total = $this->Subtotal + $this->Iva - $this->Descuento;
    }

    /**
     * Validar los datos de la cotización
     */
    public function validar() {
        $errores = [];

        if (empty($this->NombreCliente)) {
            $errores[] = "El nombre del cliente es obligatorio";
        }

        if (empty($this->Email) || !filter_var($this->Email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El email es inválido";
        }

        if (empty($this->items)) {
            $errores[] = "La cotización debe contener al menos un item";
        }

        if ($this->Total <= 0 || $this->Total > self::PRECIO_MAXIMO) {
            $errores[] = "El total debe estar entre 0 y " . self::PRECIO_MAXIMO;
        }

        return $errores;
    }

    /**
     * Guardar la cotización en la BD junto con sus detalles
     */
    public function guardar() {
        // Validar antes de guardar
        $erroresValidacion = $this->validar();
        if (!empty($erroresValidacion)) {
            throw new Exception(implode(", ", $erroresValidacion));
        }

        $this->FechaCreacion = date("Y-m-d H:i:s");
        $this->FechaValidez = date("Y-m-d", strtotime("+30 days"));

        // Preparar la query de inserción
        $query = "INSERT INTO {$this->table} 
                  (Codigo, NombreCliente, Empresa, Correo, Telefono, Subtotal, Descuento, Iva, Total, FechaCreacion, FechaValidez, IdUser)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssssddddssi",
            $this->Codigo,
            $this->NombreCliente,
            $this->Empresa,
            $this->Correo,
            $this->Telefono,
            $this->Subtotal,
            $this->Descuento,
            $this->Iva,
            $this->Total,
            $this->FechaCreacion,
            $this->FechaValidez,
            $this->IdUser
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al guardar la cotización: " . $stmt->error);
        }

        $this->IdCotizacion = $this->conn->insert_id;

        // Crear los detalles de la cotización
        $this->crearDetalles();

        return true;
    }

    /**
     * Crear los detalles de cada item en la cotización
     */
    private function crearDetalles() {
        $quoteDetail = new QuoteDetail($this->conn);

        foreach ($this->items as $item) {
            $quoteDetail->crear(
                $this->IdCotizacion,
                $item['servicio']['id'],
                $item['cantidad'],
                $item['servicio']['precio']
            );
        }
    }

    /**
     * Obtener todas las cotizaciones
     */
    public static function obtenerTodas($conn) {
        $query = "SELECT * FROM cotizaciones ORDER BY FechaCreacion DESC";
        $result = $conn->query($query);

        if (!$result) {
            throw new Exception("Error en la consulta: " . $conn->error);
        }

        $cotizaciones = [];
        while ($row = $result->fetch_assoc()) {
            $cotizaciones[] = $row;
        }

        return $cotizaciones;
    }

    public static function obtenerCotizaciones($conn, $idUser) {
        $query = "SELECT * FROM cotizaciones WHERE IdUser = ? ORDER BY FechaCreacion DESC";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $result = $stmt->get_result();

        $cotizaciones = [];

        while ($row = $result->fetch_assoc()) {
            // Obtener los items/detalles de esta cotización
            $items = self::obtenerDetallesCotizacion($conn, $row["IdCotizacion"]);

            $cotizaciones[] = [
                "id" => $row["IdCotizacion"],
                "codigo" => $row["Codigo"],
                "cliente" => [
                    "nombre" => $_SESSION["nombre"] ?? null,
                    "email" => $_SESSION["email"] ?? null,
                    "empresa" => $row["Empresa"],
                    "telefono" => $row["Telefono"]
                ],
                "subtotal" => $row["Subtotal"],
                "descuento" => $row["Descuento"],
                "items" => $items,
                "iva" => $row["Iva"],
                "total" => $row["Total"],
                "fechaCreacion" => $row["FechaCreacion"],
                "fechaValidez" => $row["FechaValidez"]
            ];
        }

        return $cotizaciones;
    }

    /**
     * Obtener detalles de una cotización con información del servicio
     */
    private static function obtenerDetallesCotizacion($conn, $idCotizacion) {
        $query = "SELECT d.Cantidad, d.PrecioUnitario, s.IdServicio, s.Nombre, s.Descripcion, s.Precio
                  FROM detallecotizacion d
                  JOIN servicios s ON d.IdServicio = s.IdServicio
                  WHERE d.IdCotizacion = ?";
        
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("i", $idCotizacion);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items[] = [
                "servicio" => [
                    "id" => $row["IdServicio"],
                    "nombre" => $row["Nombre"],
                    "descripcion" => $row["Descripcion"],
                    "precio" => (float)$row["PrecioUnitario"]
                ],
                "cantidad" => (int)$row["Cantidad"]
            ];
        }

        return $items;
    }

    /**
     * Obtener una cotización por ID
     */
    public static function obtenerPorId($conn, $idCotizacion) {
        $query = "SELECT * FROM cotizaciones WHERE IdCotizacion = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("i", $idCotizacion);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Obtener una cotización por código
     */
    public static function obtenerPorCodigo($conn, $codigo) {
        $query = "SELECT * FROM cotizaciones WHERE Codigo = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Generar un código único para la cotización
     */
    public static function generarCodigo() {
        return "COT-" . date("Y") . "-" . str_pad(rand(1, 999), 3, "0", STR_PAD_LEFT);
    }

    /**
     * Calcular el porcentaje de descuento según la cantidad
     */
    public static function calcularPorcentajeDescuento($cantidad) {
        $cantidad = (int) $cantidad;

        if ($cantidad >= 10) {
            return 0.18;
        } elseif ($cantidad >= 6) {
            return 0.12;
        } elseif ($cantidad >= 4) {
            return 0.08;
        }

        return 0;
    }

    /**
     * Eliminar una cotización y sus detalles
     */
    public static function eliminar($conn, $idCotizacion) {
        try {
            // Primero eliminar los detalles
            $queryDetalles = "DELETE FROM detallecotizacion WHERE IdCotizacion = ?";
            $stmtDetalles = $conn->prepare($queryDetalles);
            if (!$stmtDetalles) {
                throw new Exception("Error en la preparación: " . $conn->error);
            }
            $stmtDetalles->bind_param("i", $idCotizacion);
            $stmtDetalles->execute();

            // Luego eliminar la cotización
            $queryCot = "DELETE FROM cotizaciones WHERE IdCotizacion = ?";
            $stmtCot = $conn->prepare($queryCot);
            if (!$stmtCot) {
                throw new Exception("Error en la preparación: " . $conn->error);
            }
            $stmtCot->bind_param("i", $idCotizacion);
            
            if ($stmtCot->execute()) {
                return true;
            } else {
                throw new Exception("Error al eliminar la cotización: " . $stmtCot->error);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Generar JSON de la cotización con sus detalles
     */
    public function generarJson() {

        return [
            "id" => $this->IdCotizacion,
            "codigo" => $this->Codigo,
            "cliente" => [
                "nombre" => $this->NombreCliente,
                "email" => $this->Email,
                "empresa" => $this->Empresa,
                "telefono" => $this->Telefono
            ],
            "subtotal" => $this->Subtotal,
            "descuento" => $this->Descuento,
            "items" => $this->items,
            "iva" => $this->Iva,
            "total" => $this->Total,
            "fechaCreacion" => $this->FechaCreacion,
            "fechaValidez" => $this->FechaValidez
        ];
    }
}