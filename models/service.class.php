<?php
//Ahora estos son Modelos, entonces estas clases deben de poder acceder a los datos en bd
    require_once(__DIR__."/../config/services.db.php");
//Voy a guardar cosos Service dentro del Session xd
class Service implements JsonSerializable{
    private const cate_validas = [
        'fis01' => [5, 3],
        'ele02' => [1, 2],
        'saf03' => [4]
    ];

    private const precio_minimo = 100;
    private const precio_maximo = 10000;
    private $categoria;
    private $stock;

    public function __construct(private $id,
    private $nombre, 
    private $descripcion,
    private $precio,
    private $idCategoria){
        
        $categoria_valida = self::validarCategoria($this->idCategoria);
        if($categoria_valida === null) {
            throw new InvalidArgumentException("Categoría inválida");
        };

        $this->categoria = $categoria_valida;
        $this->stock = $this->setStock($this->categoria);

    }
    //Acá lo voy a ocupar cuando haga las cotizaciónes
    public function es_Valido(){
        //Valido si está en un buen formato ya que lo voy a guardar en la bd.
        //Ya que puede que me estes dando un buen Id, pero que la demás 
        if(!$this->validar_Precio($this->precio) || !$this->validar_Tipo($this->nombre, $this->descripcion)){
            return false;
        }else{ 
           return true;
        }
    }
    //Para cuando se haga json_encode me lo va a detectar
    //automaticamente !!! :0000000000000000000
    public function jsonSerialize(): mixed {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "categoria" => $this->categoria,
            "stock" => $this->stock,
            "idCategoria" => $this->idCategoria
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

    public function setStock(string $cate){
       //Hardcodeado de por momento xd
       if($cate === "fis01"){
            return 7;
       }
       
       if($cate == "ele02"){
            return 5;
       }

       if($cate == "saf03"){
            return 10;
       }
       return 0;
    }


    public function __getPrecio()
    {
        return $this->precio;
    }

    public function __getStock(){
        return $this->stock;
    }

    // -------------- Funciones staticas -------------------------

    public static function validarCategoria(int $id){
        foreach (self::cate_validas as $categoria => $valores) {

            if (in_array($id, $valores, true)) {
                return $categoria;
            }
        }

        return null;
    }
    public static function obtener_servicio($id) {
        global $conn;

        $sql = "SELECT * FROM servicios WHERE idServicio = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $id); // "i" porque es entero
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new self(
                $row['IdServicio'],
                $row['Nombre'],
                $row['Descripcion'],
                $row['Precio'],
                $row['IdCategoria']
            );
        }

        return null;
    }
    //Devuelve INSTANCIAS de Services
    public static function allService() {
        global $conn;

        $sql = "SELECT * FROM servicios";
        $result = $conn->query($sql);

        $services = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $services[] = new self(
                    $row['IdServicio'],
                    $row['Nombre'],
                    $row['Descripcion'],
                    $row['Precio'],
                    $row['IdCategoria']
                );
            }
        }

        return $services;
    }

    /**
     * Crear un nuevo servicio
     */
    public static function crear($conn, $nombre, $descripcion, $precio, $idCategoria) {
        // Validar categoría
        $categoria = self::validarCategoria($idCategoria);
        if ($categoria === null) {
            throw new Exception("Categoría inválida");
        }

        // Validar datos
        if (empty($nombre) || empty($descripcion) || !is_numeric($precio)) {
            throw new Exception("Datos inválidos");
        }

        if ($precio <= self::precio_minimo || $precio >= self::precio_maximo) {
            throw new Exception("El precio debe estar entre " . self::precio_minimo . " y " . self::precio_maximo);
        }

        // Insertar en BD
        $sql = "INSERT INTO servicios (Nombre, Descripcion, Precio, IdCategoria) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $idCategoria);

        if ($stmt->execute()) {
            $nuevoId = $conn->insert_id;
            $stmt->close();
            return new self($nuevoId, $nombre, $descripcion, $precio, $idCategoria);
        } else {
            throw new Exception("Error al crear el servicio: " . $stmt->error);
        }
    }

    /**
     * Obtener todas las categorías disponibles
     */
    public static function obtenerCategorias() {

        global $conn;

        $sql = "SELECT * FROM categorias";
        $result = $conn->query($sql);
        $categorias = [];
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                $categorias[] = [
                    'id' => $row["IdCategoria"],
                    'nombre' => $row["Nombre"]
                ];
            }
        }
        return $categorias;
    }

    /**
     * Obtener nombre legible de la categoría
     */
    private static function getNombreCategoria($codigo) {
        $nombres = [
            'fis01' => 'Seguridad Física',
            'ele02' => 'Seguridad Electrónica',
            'saf03' => 'Safety & Utilities'
        ];
        return $nombres[$codigo] ?? $codigo;
    }

    /**
     * Actualizar un servicio existente
     */
    public static function actualizar($conn, $idServicio, $nombre, $descripcion, $precio, $idCategoria) {
        // Validar categoría
        $categoria = self::validarCategoria($idCategoria);
        if ($categoria === null) {
            throw new Exception("Categoría inválida");
        }

        // Validar datos
        if (empty($nombre) || empty($descripcion) || !is_numeric($precio)) {
            throw new Exception("Datos inválidos");
        }

        if ($precio <= self::precio_minimo || $precio >= self::precio_maximo) {
            throw new Exception("El precio debe estar entre " . self::precio_minimo . " y " . self::precio_maximo);
        }

        // Actualizar en BD
        $sql = "UPDATE servicios SET Nombre = ?, Descripcion = ?, Precio = ?, IdCategoria = ? WHERE IdServicio = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $idCategoria, $idServicio);

        if ($stmt->execute()) {
            $stmt->close();
            return new self($idServicio, $nombre, $descripcion, $precio, $idCategoria);
        } else {
            throw new Exception("Error al actualizar el servicio: " . $stmt->error);
        }
    }

    /**
     * Eliminar un servicio
     */
    public static function eliminar($conn, $idServicio) {

        // Verificar si no está en alguna cotizacion
        $sql = "SELECT COUNT(*) FROM detallecotizacion WHERE IdServicio = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("i", $idServicio);
        $stmt->execute();
        $total = 0;
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close(); 

        if ($total > 0) {
            throw new Exception("Servicio ya existente en cotizacion.");
        }

        // Ahora sí puedes hacer otra query
        $sql = "DELETE FROM servicios WHERE IdServicio = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("i", $idServicio);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            throw new Exception("Error al eliminar el servicio: " . $stmt->error);
        }
    }

}