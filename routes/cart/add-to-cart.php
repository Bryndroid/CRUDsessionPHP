<?php

//Se va a reducir codigo en estas rutas, para que ahora ese codigo sea manejado dentro de los controladores!


// add-to-cart.php
// ------------------------------------------------------------------
// Este endpoint recibe el identificador de un servicio y lo añade al
// carrito guardado en la sesión PHP. El carrito se mantiene en
// $_SESSION['cart'] como un arreglo asociativo donde la clave es el id
// del servicio.
//
// Formas de invocar:
//   - POST tradicional: body form-url-encoded con campo "id"
//   - JSON: Content-Type: application/json y {"id": "svc01"}
//
// Respuesta: siempre devuelve JSON con estas claves:
//   success  -> boolean
//   message  -> opcional, en caso de error
//   cart     -> objeto con los elementos actuales
//   total    -> suma de precio*cantidad
//   items    -> total de unidades
// ------------------------------------------------------------------

require_once __DIR__ . "/../../controllers/CartController.php";
require_once __DIR__. "/../../helpers/Auth.php";
require_once __DIR__. '/../../helpers/secure.php';
iniciarSesionSegura();
header('Content-Type: application/json');
try{

    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;

    if (!$id) {
        echo json_encode(["success" => false, "message" => "ID de servicio requerido"]);
        exit;
    }
    requireAuth();
    $cartController =  new CartController($id);
    $cartController->addService();


}catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

 