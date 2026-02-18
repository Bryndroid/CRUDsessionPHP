<?php



class Service{
    private const cate_validas = "[{ 'id': 'cat01'}, { 'id': 'cat02'}, { 'id': 'cat03'}]";

    private const datos_bd = '{
        "categorias": [
            {
                "id": "cat01",
                "nombre": "Seguridad Física",
                "servicios": [
                    {
                        "id": "svc01",
                        "nombre": "Agentes de seguridad",
                        "descripcion": "Personal capacitado para vigilancia, control de acceso y protección de instalaciones y personas.",
                        "precio_base": 500
                    },
                    {
                        "id": "svc02",
                        "nombre": "Protección VIP",
                        "descripcion": "Servicio de protección personal para ejecutivos o personas con necesidades de seguridad especial.",
                        "precio_base": 1200
                    },
                    {
                        "id": "svc03",
                        "nombre": "Patrullaje y vigilancia móvil",
                        "descripcion": "Monitoreo de instalaciones y patrullaje dinámico para reforzar presencia preventiva en áreas de riesgo.",
                        "precio_base": 750
                    }
                ]
            },
            {
                "id": "cat02",
                "nombre": "Seguridad Electrónica",
                "servicios": [
                    {
                        "id": "svc04",
                        "nombre": "Sistemas CCTV",
                        "descripcion": "Instalación y monitoreo de circuitos cerrados de televisión para vigilancia visual constante.",
                        "precio_base": 900
                    },
                    {
                        "id": "svc05",
                        "nombre": "Sistema GPS para flota y personal",
                        "descripcion": "Tecnología de localización en tiempo real para vehículos y personal con seguimiento de rutas.",
                        "precio_base": 650
                    },
                    {
                        "id": "svc06",
                        "nombre": "Sistemas de alarma y monitoreo",
                        "descripcion": "Alarmas electrónicas con supervisión profesional para detección de intrusiones y eventos de seguridad.",
                        "precio_base": 550
                    }
                ]
            },
            {
                "id": "cat03",
                "nombre": "Safety & Utilities",
                "servicios": [
                    {
                        "id": "svc07",
                        "nombre": "Consultorías de seguridad preventiva",
                        "descripcion": "Asesoría especializada para evaluar riesgos y diseñar estrategias de prevención y cultura de seguridad.",
                        "precio_base": 400
                    },
                    {
                        "id": "svc08",
                        "nombre": "Capacitaciones y charlas de seguridad",
                        "descripcion": "Programas de formación para empleados en prácticas de seguridad y protocolos preventivos.",
                        "precio_base": 300
                    },
                    {
                        "id": "svc09",
                        "nombre": "Administración y contratación de personal",
                        "descripcion": "Gestión integral de recursos humanos especializados para operaciones de seguridad y apoyo logístico.",
                        "precio_base": 700
                    }
                ]
            }
        ]
    }';

    private const precio_minimo = 100;
    private const precio_maximo = 10000;

    public function __construct(private $id,
    private $nombre, 
    private $descripcion,
    private $precio,
    private $categoria){

        
    }

    public function es_Valido(){
        if(!$this->validar_Precio($this->precio) || !$this->validar_Tipo($this->nombre, $this->descripcion) || !$this->validar_Categoria($this->categoria) ){
            //Quizas por acá podría mandar el mensaje
            return "Validación fallida. Datos del servicio erroneos.";
        }else{
            return "Validación exitosa";
        }
    }
    private function validar_Precio($precio_entrante){
        if($precio_entrante <= self::precio_minimo || $precio_entrante >= self::precio_maximo){
            return false;
        }
    }

    private function validar_Tipo($nombre, $descripcion){
        if(gettype($nombre) != "string" || gettype($descripcion) != "string"){
            return false;
        }

        if(strlen(str_replace(' ', '', $nombre) >= 1000) || strlen(str_replace(' ', '', $descripcion) >= 10000)){
            return false;
        }
    }

    private function validar_Categoria($categoria){
        foreach(json_decode(self::cate_validas, true) as $i){
            if($i["id"] != $categoria){
                return false;
                break;
            }
        }
    }

    //Falta un getter para obtener los DATOS del Carrito (Sessión)

    public static function __get_Values_Carrito(){
        //Acá la lógica de la sessión
    }

   static function  obtener_servicios(){
     return json_decode(self::datos_bd, true)["categorias"];
   }

}