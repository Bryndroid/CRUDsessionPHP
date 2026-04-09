<?php
//Se va a reducir codigo en estas rutas, para que ahora ese codigo sea manejado dentro de los controladores!
// process-quote.php
// ---------------------------------------------------------------
// Este endpoint transforma el contenido del carrito en una cotización
// que guarda en la sesión junto con los datos del cliente.
//
// Entrada (JSON o POST):
//    nombre -> nombre del cliente
//    email  -> correo electrónico
//
// Comprueba que exista un carrito no vacío y que se hayan enviado
// datos de contacto. Genera un id aleatorio para la cotización, guarda
// toda la información en $_SESSION['quote'] y devuelve el objeto.
// ---------------------------------------------------------------
    require_once __DIR__ . '/../models/service.class.php';
    require_once __DIR__.'/../models/quote.class.php';
    session_start();
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $nombre = trim($input['nombre'] ?? '');
    $email  = trim($input['email'] ?? '');

    // validar precondiciones
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode(["success" => false, "message" => "Carrito vacío"]);
        exit;
    }

    if ($nombre === '' || $email === '') {
        echo json_encode(["success" => false, "message" => "Nombre y email son obligatorios"]);
        exit;
    }
    

        $quoteId = Quote::generar_Codigo();

        $quote =  new Quote($nombre, $email, $_SESSION["cart"]);
    
    if($quote->agregarItem()){
        // devolver la cotización creada
        echo json_encode([
            "success" => true,
            "quote"   => end($_SESSION['quotes'])
        ]);
        exit;
    }
    // devolver la cotización creada
    echo json_encode([
        "success" => false,
        "message"   => "Error al crear la cotización. Datos invalidos"
    ]);