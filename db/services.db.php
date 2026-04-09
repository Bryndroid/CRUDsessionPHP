<?php
//Esto debe de ser cambiado, ya que ahora la bd va a ser conectada a una de MySQL
const datos_bd = '{
        "categorias": [
            {
                "id": "cat01",
                "nombre": "Seguridad Física",
                "servicios": [
                    {
                        "id": "svc01",
                        "nombre": "Agentes de seguridad",
                        "descripcion": "Personal capacitado para vigilancia, control de acceso y protección de instalaciones y personas.",
                        "precio_base": 500,
                        "stock":10
                    },
                    {
                        "id": "svc02",
                        "nombre": "Protección VIP",
                        "descripcion": "Servicio de protección personal para ejecutivos o personas con necesidades de seguridad especial.",
                        "precio_base": 1200,
                        "stock":5
                    },
                    {
                        "id": "svc03",
                        "nombre": "Patrullaje y vigilancia móvil",
                        "descripcion": "Monitoreo de instalaciones y patrullaje dinámico para reforzar presencia preventiva en áreas de riesgo.",
                        "precio_base": 750,
                        "stock":5
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
                        "precio_base": 900,
                        "stock": 5
                    },
                    {
                        "id": "svc05",
                        "nombre": "Sistema GPS para flota y personal",
                        "descripcion": "Tecnología de localización en tiempo real para vehículos y personal con seguimiento de rutas.",
                        "precio_base": 650,
                        "stock": 5
                    },
                    {
                        "id": "svc06",
                        "nombre": "Sistemas de alarma y monitoreo",
                        "descripcion": "Alarmas electrónicas con supervisión profesional para detección de intrusiones y eventos de seguridad.",
                        "precio_base": 550,
                        "stock": 10
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
                        "precio_base": 400,
                        "stock": 15
                    },
                    {
                        "id": "svc08",
                        "nombre": "Capacitaciones y charlas de seguridad",
                        "descripcion": "Programas de formación para empleados en prácticas de seguridad y protocolos preventivos.",
                        "precio_base": 300,
                        "stock": 7
                    },
                    {
                        "id": "svc09",
                        "nombre": "Administración y contratación de personal",
                        "descripcion": "Gestión integral de recursos humanos especializados para operaciones de seguridad y apoyo logístico.",
                        "precio_base": 700,
                        "stock": 10
                    }
                ]
            }
        ]
    }';