<?php
//Ahora estos son Modelos, entonces estas clases deben de poder acceder a los datos en bd
    require_once(__DIR__."/../db/services.db.php");
//Voy a guardar cosos Service dentro del Session xd
class Service implements JsonSerializable{
    private const cate_validas = ['cat01', 'cat02', 'cat03'];

    private const precio_minimo = 100;
    private const precio_maximo = 10000;
 

    public function __construct(private $id,
    private $nombre, 
    private $descripcion,
    private $precio,
    private $categoria,
    private $stock){

    }
    //Acá lo voy a ocupar cuando haga las cotizaciónes
    public function es_Valido(){
        //Valido si está en un buen formato ya que lo voy a guardar en la bd.
        //Ya que puede que me estes dando un buen Id, pero que la demás 
        if(!$this->validar_Precio($this->precio) || !$this->validar_Tipo($this->nombre, $this->descripcion) || !$this->validar_Categoria($this->categoria) || !$this->validar_Id($this->id)){
            return false;
        }else{ 
           return true;
        }
    }

    public function jsonSerialize(): mixed {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "categoria" => $this->categoria,
            "stock" => $this->stock
        ];
    }
    private function validar_Precio($precio_entrante){
        if($precio_entrante <= self::precio_minimo || $precio_entrante >= self::precio_maximo){
            return false;
        }
        return true;
    }

    private function validar_Tipo($nombre, $descripcion){
        if(gettype($nombre) != "string" || gettype($descripcion) != "string"){
            return false;
        }

        if(strlen(str_replace(' ', '', $nombre)) >= 1000 || strlen(str_replace(' ', '', $descripcion)) >= 10000){
            return false;
        }
        return true;
    }

    private function validar_Categoria($categoria){
        return in_array($categoria, self::cate_validas, true);
    }

    private function validar_Id($id){
        if (!preg_match('/^svc\d{2}$/', $id)) {
            return false;
        }
        return true;
    }


    public function __getPrecio()
    {
        return $this->precio;
    }

    public function __getStock(){
        return $this->stock;
    }
    static function obtener_servicio($id) {

        $data = json_decode(datos_bd, true);

        if ($data === null) {
            return null; // JSON inválido
        }

        foreach ($data["categorias"] as $categoria) {

            foreach ($categoria["servicios"] as $servicio) {

                if ($servicio["id"] === $id) {

                    return new self(
                        $servicio["id"],
                        $servicio["nombre"],
                        $servicio["descripcion"],
                        $servicio["precio_base"],
                        $categoria["id"],
                        $servicio["stock"]
                    );
                }
            }
        }

        return null;
    }

}