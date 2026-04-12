<?php

require_once __DIR__ . '/../config/services.db.php';
require_once __DIR__ . '/../models/quote.class.php';
require_once __DIR__ . '/../models/QuoteDetail.php';

header('Content-Type: application/json');   

class QuoteController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Crear una cotización a partir del carrito
     */
    public function crearCotizacion($nombreCliente, $email, $items, $empresa = '', $telefono = '', $idUser = null) {
        try {
            // Validaciones básicas
            $nombreCliente = trim($nombreCliente ?? '');
            $email = trim($email ?? '');


            // Crear la instancia de Quote
            $quote = new Quote(
                $this->conn,
                $nombreCliente,
                $email,
                $empresa,
                $telefono,
                $idUser
            );

            // Establecer los items del carrito
            $quote->setItems($items);

            // Guardar la cotización en la BD
            $quote->guardar();

            // Guardar también en sesión para compatibilidad
            if (!isset($_SESSION['quotes'])) {
                $_SESSION['quotes'] = [];
            }
            $_SESSION['quotes'][] = $quote->generarJson();

            return [
                "success" => true,
                "message" => "Cotización creada exitosamente",
                "quote" => $quote->generarJson()
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => "Error al crear la cotización: " . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener todas las cotizaciones
     */
    public function obtenerCotizaciones() {
        try {
            $cotizaciones = Quote::obtenerTodas($this->conn);
            return [
                "success" => true,
                "cotizaciones" => $cotizaciones
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => "Error al obtener cotizaciones: " . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener una cotización por código
     */
    public function obtenerPorCodigo($codigo) {
        try {
            $codigo = trim($codigo ?? '');

            if (empty($codigo)) {
                return [
                    "success" => false,
                    "message" => "El código es obligatorio"
                ];
            }

            $cotizacion = Quote::obtenerPorCodigo($this->conn, $codigo);

            if (!$cotizacion) {
                return [
                    "success" => false,
                    "message" => "Cotización no encontrada"
                ];
            }

            // Obtener los detalles
            $detalles = QuoteDetail::obtenerDetalles($this->conn, $cotizacion['IdCotizacion']);

            return [
                "success" => true,
                "cotizacion" => $cotizacion,
                "detalles" => $detalles
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => "Error al obtener la cotización: " . $e->getMessage()
            ];
        }
    }
}
