<?php
//Clase Controladora que añade servicios al carrito dinamicamente
require_once __DIR__ . '/../models/service.class.php';
require_once __DIR__ . '/../models/quote.class.php';

header('Content-Type: application/json');

class CartController{
    
    private Service $service;
    
    public function __construct(private string $id)
    {   
    }

    //-----------------FUNCIONES PUBLICAS--------------
    public function addService(){
       $this->service = $this->findService();
       $this->addToSession();
    }
    
    public function getServices(){
        if(!isset($_SESSION['cart'])){
            echo json_encode([
                "success" => true,
                "cart"    => null,
                "total"   => 0,
                "items"   => 0
            ]);
            exit;
        }

        $this->returnServices();
    }

    public function removeService(){
        // si el ítem está en el carrito, lo borramos
        if (isset($_SESSION['cart'][$this->id])) {
            unset($_SESSION['cart'][$this->id]);
        }

        // recalcultar totales tras la modificación
        $total = 0;
        $count = 0;

        foreach ($_SESSION['cart'] ?? [] as $item) {
            $total += $item['servicio']['precio'] * $item['cantidad'];
            $count += $item['cantidad'];
        }

        $total =  $total - $total*Quote::calcularPorcentajeDescuento($count);
        echo json_encode([
                "success" => true,
                "cart"    => $_SESSION['cart'],
                "total"   => $total,
                "items"   => $count,
                "descuento" => Quote::calcularPorcentajeDescuento($count)
         ]);
        exit;
    }

    public function patchService($cantidad){
        if (!isset($_SESSION['cart'][$this->id])) {
            echo json_encode(["success" => false, "message" => "Artículo no existe en el carrito"]);
            exit;
        }

        // si la cantidad solicitada es 0 o negativa, eliminamos el ítem
        if ($cantidad < 1) {
            unset($_SESSION['cart'][$this->id]);
        } else {

            $_SESSION['cart'][$this->id]['cantidad'] = $cantidad;
            if($_SESSION['cart'][$this->id]['cantidad'] > $_SESSION['cart'][$this->id]['servicio']["stock"]){
                $_SESSION['cart'][$this->id]['cantidad'] -= 1;
                echo json_encode(["success" => false, "message" => "Limite de stock"]);
                exit;
            }
        }

        $this->returnServices();
    }
    //--- PRIVATE FUNCTIONS -------
    private function findService(){
        $service = Service::obtener_servicio($this->id);
        if(!$service){
            echo json_encode(["success" => false, "message" => "Servicio Inexistente"]);
            exit;
        }
        if (!$service->es_Valido()) {
            echo json_encode(["success" => false, "message" => "Servicio Invalido." ]);
            exit;
        }
        return $service;
    }

    private function addToSession(){
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        if(isset($_SESSION['cart'][$this->id])){
           echo json_encode([
            "success" => false,
            "message" => "Servicio ya en carrito"
            ]);
            exit;
        }

        $_SESSION['cart'][$this->id] = [
            "servicio" => $this->service->jsonSerialize(),
            "cantidad" => 1
        ];
        

        $this->returnServices();
    }
    //TODO
    private function newCountService($cantidad){

        if (!isset($_SESSION['cart'][$this->id])) {
            echo json_encode(["success" => false, "message" => "Artículo no existe en el carrito"]);
            exit;
        }

        if ($cantidad < 1) {
            unset($_SESSION['cart'][$this->id]);
        } else {
            $cantAnterior = $_SESSION['cart'][$this->id]['cantidad'];
            $_SESSION['cart'][$this->id]['cantidad'] = $cantidad;
            if($_SESSION['cart'][$this->id]['cantidad'] > $_SESSION['cart'][$this->id]['servicio']["stock"]){
                $_SESSION['cart'][$this->id]['cantidad'] = $cantAnterior;
                echo json_encode(["success" => false, "message" => "Limite de stock"]);
                exit;
            }
        }

        $this->returnServices();
    }

    private function returnServices(){
        $total = 0;
        $count = 0;

        foreach ($_SESSION['cart'] as $item) {
            $total += $item['servicio']['precio'] * $item['cantidad'];
            $count += $item['cantidad'];
        }
        $total =  $total - $total*Quote::calcularPorcentajeDescuento($count);

        echo json_encode([
            "success" => true,
            "cart"    => $_SESSION['cart'],
            "total"   => $total,
            "items"   => $count,
            "descuento" => Quote::calcularPorcentajeDescuento($count)
        ]);
        exit;
    }

    
}