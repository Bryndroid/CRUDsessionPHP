<?php
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


require_once __DIR__ . '/../clases/service.class.php';
require_once __DIR__ . '/../clases/quote.class.php';
session_start();
header('Content-Type: application/json');

// 1. leer entrada (admite JSON o formulario)
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

// 2. validar parámetro obligatorio
if (!$id) {
    echo json_encode(["success" => false, "message" => "ID de servicio requerido"]);
    exit;
}

// 3. localizar la información del servicio consultando la clase Service
$service = Service::obtener_servicio($id);
 if(!$service){
    echo json_encode(["success" => false, "message" => "Servicio Inexistente"]);
    exit;
 }


if (!$service->es_Valido()) {
    echo json_encode(["success" => false, "message" => "Servicio Invalido." ]);
    exit;
}

// 4. inicializar carrito en sesión si aún no existe
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 5. añadir o incrementar la cantidad
if (isset($_SESSION['cart'][$id])) {
    //Si ya está seteado, nomas le aumento la cantidad
    $_SESSION['cart'][$id]['cantidad'] += 1;
    if($_SESSION['cart'][$id]['cantidad'] > $service->__getStock()){

        $_SESSION['cart'][$id]['cantidad'] -= 1;
        echo json_encode(["success" => false, "message" => "Limite de stock" ]);

        exit;
    }
} else {
    $_SESSION['cart'][$id] = [
        "servicio" => $service->jsonSerialize(),
        "cantidad" => 1
    ];
}

// 6. recalcular totales para inclusión en la respuesta
$total = 0;
$count = 0;

foreach ($_SESSION['cart'] as $item) {
    $total += $item['servicio']['precio'] * $item['cantidad'];
    $count += $item['cantidad'];
}
$total =  $total - $total*Quote::calcularDescuento($count);


echo json_encode([
        "success" => true,
        "cart"    => $_SESSION['cart'],
        "total"   => $total,
        "items"   => $count,
        "descuento" => Quote::calcularDescuento($count)
    ]);
    exit;
