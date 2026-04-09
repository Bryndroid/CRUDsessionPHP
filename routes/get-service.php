<?php
//Se va a reducir codigo en estas rutas, para que ahora ese codigo sea manejado dentro de los controladores!
require_once __DIR__.'/../models/quote.class.php';
    session_start();
    header('Content-Type: application/json');

    if(!isset($_SESSION['cart'])){
        echo json_encode([
            "success" => true,
            "cart"    => null,
            "total"   => 0,
            "items"   => 0
        ]);
        exit;
    }else{
        $total = 0;
        $count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['servicio']['precio'] * $item['cantidad'];
            $count += $item['cantidad'];
        }
        echo json_encode([
            "success" => true,
            "cart"    => $_SESSION['cart'],
            "total"   => $total,
            "items"   => $count,
            "descuento" => Quote::calcularDescuento($count)
        ]);
        exit;
    }