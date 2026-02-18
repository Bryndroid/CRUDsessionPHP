<?php

class Quote{
    //Propiedades fuera del constructor para evitar instanciar este coso. La idea es tener el coso ya instanciado para que tenga correlación con los datos.
    private $codigo;
    private $items;
    private $subtotal;
    private $descuento;
    private $iva;
    private $total;

    public function __construct(
        private $cliente
    )
    {
        
    }
    //Acá voy a agregar el item a sessión.
    private function agregar_Item(){

    }
    //Antes del iva y descuentos.
    private function calcular_Subtotal(){

    }
    private function calcular_Descuento(){

    }
    private function calcular_IVA(){

    }
    //Después de todo: Los descuentos e IVA
    private function agregarTotal(){

    }
    private function generar(){

    }

    static function generar_Codigo(){
        $anio = date("Y");
        $numero = str_pad(rand(1, 9999), 4, "0", STR_PAD_LEFT);

        return "COT-$anio-$numero";
    }

    static function validar_Monto($monto){
        if($monto <= 0 || gettype($monto) != "number" || $monto >= 10000000){
            return false;
        }else{
            return true;
        }
    }
}