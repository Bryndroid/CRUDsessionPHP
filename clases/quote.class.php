<?php
class Quote {
    private $codigo;
    private $subtotal = 0;
    private $descuento = 0;
    private $iva = 0;
    private $total = 0;
    private $cantidadTotal = 0;
   
    public function __construct(private $cliente_nombre, private $cliente_email, private $items = [] ) {
        $this->codigo = self::generar_Codigo();
    }

    public function agregarItem() {
        if (!isset($_SESSION['quotes'])) {
            $_SESSION['quotes'] = [];
        }
        $this->calcularSubtotal($this->items);
        $this->calcularIVA();
        $this->calcularTotal();

        if(self::validarMonto($this->total)){
            $_SESSION['quotes'][] = [
                "id"        => $this->codigo,
                "cliente"   => ["nombre" => $this->cliente_nombre, "email" => $this->cliente_email],
                "items"     => $this->items,
                "total"     => $this->total,
                "itemsCount"=> $this->cantidadTotal,
                "fecha"     => date("Y-m-d H:i:s"),
                "descuento" => self::calcularDescuento($this->total)
            ];
            return true;
        }
        return false;
    }

    private function calcularSubtotal($items) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['servicio']['precio'] * $item['cantidad'];
            $this->cantidadTotal += $item["cantidad"];
        }
        $this->subtotal = $total;
    }
    
    private function calcularIVA() {
        $this->iva = $this->subtotal * 0.13; // IVA El Salvador
    }

    private function calcularTotal() {
        $this->total = $this->subtotal + $this->iva - $this->descuento;
    }

    public function generarJson() {
        return [
            "id" => $this->codigo,
            "cliente" => ["nombre" => $this->cliente_nombre, "email" => $this->cliente_email],
            "items" => $this->items,
            "total" => $this->total,
            "fecha" => date("d/m/Y H:i")
        ];
    }

    static function generar_Codigo() {
        return "COT-" . date("Y") . "-" . str_pad(rand(1, 999), 3, "0", STR_PAD_LEFT);
    }
    static function validarMonto($monto){
        if($monto > 100000 ){
            return false;
        }else if($monto < 0){
            return false;
        }
        return true;
    }
    static function calcularDescuento($cantidad){

        $cantidad = (int) $cantidad;

        if($cantidad >= 4 && $cantidad <= 5){
            return 0.08;
        }
        elseif ($cantidad >= 6 && $cantidad <= 9){
            return 0.12;
        }
        elseif($cantidad >= 10){
            return 0.18;
        }

        return 0;
    }
}