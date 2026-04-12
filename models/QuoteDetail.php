<?php

class QuoteDetail {
    private $conn;
    private $table = 'detallecotizacion';

    public $IdDetalleCotizacion;
    public $IdCotizacion;
    public $IdServicio;
    public $Cantidad;
    public $PrecioUnitario;
    public $Subtotal;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Crear un detalle de cotización en la BD
     */
    public function crear($idCotizacion, $idServicio, $cantidad, $precioUnitario) {
        $subtotal = $cantidad * $precioUnitario;

        $query = "INSERT INTO {$this->table} (IdCotizacion, IdServicio, Cantidad, PrecioUnitario, Subtotal)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $this->conn->error);
        }

        $stmt->bind_param("iiidd", $idCotizacion, $idServicio, $cantidad, $precioUnitario, $subtotal);

        if ($stmt->execute()) {
            $this->IdDetalleCotizacion = $this->conn->insert_id;
            $this->IdCotizacion = $idCotizacion;
            $this->IdServicio = $idServicio;
            $this->Cantidad = $cantidad;
            $this->PrecioUnitario = $precioUnitario;
            $this->Subtotal = $subtotal;
            return true;
        } else {
            throw new Exception("Error al crear detalle: " . $stmt->error);
        }
    }

    /**
     * Obtener todos los detalles de una cotización
     */
    public static function obtenerDetalles($conn, $idCotizacion) {
        $query = "SELECT * FROM detallecotizacion WHERE IdCotizacion = ?";
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("i", $idCotizacion);
        $stmt->execute();
        $result = $stmt->get_result();

        $detalles = [];
        while ($row = $result->fetch_assoc()) {
            $detalles[] = $row;
        }

        return $detalles;
    }
}
