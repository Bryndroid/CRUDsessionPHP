<?php
    require_once "./clases/service.class.php";

    $arr_cate = Service::obtener_servicios();
    $length =  count($arr_cate);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CA Security</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="./assets/css/service-catalog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class = "bg-[#241535] bg-[url('https://www.transparenttextures.com/patterns/black-scales.png')] text-white ">
    <header class = "w-full flex flex-wrap justify-around p-4">
       
        <h1 class = "block font-bold text-xl">
            <span class = "text-[#F08A5D]">CA</span> Security
        </h1>
        
        <section class =" text-white flex flex-nowrap justify-between text-sm">
            <div class = "text-center pt-1 pb-1 pr-4">
                <ul class = "flex gap-4">
                    <li><a href ="#services"class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">Services</a></li>
                    <li><a class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">Cotizaciones</a></li>
                    <li><a class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">About</a></li>
                </ul>
            </div>
           
            <button class = "block hover:cursor-pointer bg-[#F08A5D]  pl-3 pr-3 font-semibold text-center rounded-2xl text-[#240a55] w-[100px] transition-all hover:translate-y-1 hover:text-white hover:bg-[#45188b] shadow-[0_0_20px_#F08A5D]" onclick="openCart()" >
                Carrito
            </button>
            
        </section>
    </header>
    <main class ="w-full mt-10 pr-4 pl-4 flex flex-col justify-center items-center">
        <section class = "flex flex-wrap md:flex-wrap md:w-[80%] gap-4">
            <!--Acá va el texto-->
            <!--Dos pilares dónde irá el texto-->
            <section class = "flex-2 flex justify-center items-center">
                <div class ="mr-8">
                    <h2 class = "text-[#F08A5D] font-semibold">Tus necesidades, nuestra ayuda</h2>
                    <p class = "text-sm mb-1 mt-1 text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, maiores. Suscipit laudantium dolores, cumque delectus quidem deleniti placeat, eligendi deserunt quas laboriosam dolor earum vero, illo quisquam. Deserunt, cupiditate vel!</p>
                    <button class = "block  bg-[#F08A5D] pt-1 pb-1 pl-3 pr-3 font-semibold text-center rounded-2xl text-[#240a55] w-[180px] transition-all hover:text-white hover:cursor-pointer hover:bg-[#45188b]">
                        Conoce más...
                    </button>
                </div>
            </section>
            <section class = "md:flex-3 min-w-[40px] min-h-[20px]">
                <img class ="rounded-full shadow-[0_8px_20px_rgba(240,138,93,0.45)]" src ="./assets/img1.jpg">
            </section>

            <section class  ="flex flex-col justify-center items-center w-full">
                <!--Acá que este Div tenga nomas un borde abajo de color naranja-->
                <div class ="mt-4 border-b-4 border-[#F08A5D] shadow-[inset_0_-8px_8px_-6px_#F08A5D] w-full text-center">
                    <h3 class = "text-lg font-semibold text-[#F08A5D]">Conoce sobre nuestros Servicios</h3>
                </div>
                <section class = "flex flex-wrap  justify-around w-full ">
                    
                    <section class = "bg-gradient-to-b from-[#f0625dc0] to-[#241535] flex-1 min-w-[350px]">
                        <section class =" pr-6 pl-6 pt-12 pb-12 text-center">
                            <img src = "assets/img2.jpg" class = "w-[100%] h-[150px] shadow-[0_0_20px_#c71e18]">
                            <p class = "font-semibold mt-4">Seguridad Fisica</p>
                            <span class = "text-sm ">
                                Implementamos tecnología de vanguardia para ofrecer monitoreo inteligente y control total en todo momento. 
                            </span>
                        </section>
                    </section>
                    <section class = "bg-gradient-to-b from-[#5d7ff0c0] to-[#241535] flex-1 min-w-[350px]">
                        <section class =" pr-6 pl-6 pt-12 pb-12 text-center">
                            <img src = "assets/img3.webp" class = "w-[100%] h-[150px]">
                            <p class = "font-semibold mt-4">Seguridad Eletrónica</p>
                            <span class = "text-sm">
                                Creamos entornos protegidos con presencia estratégica y soluciones confiables que brindan tranquilidad a personas y organizaciones.
                            </span>
                        </section>
                    </section>
                    <section class = "bg-gradient-to-b from-[#8cf05dc0] to-[#241535] flex-1">
                        <section class =" pr-6 pl-6 pt-12 pb-12 text-center">
                            <img src = "assets/img4.webp" class = "m-auto min-w-[220px] max-w-[400px] w-[100%] h-[150px]">
                            <p class = "font-semibold mt-4">Safety & Utilities</p>
                            <span class = "text-sm">
                                Apoyamos a las empresas con servicios integrales que fortalecen la prevención, la seguridad y la gestión de sus operaciones.
                            </span>
                        </section>
                    </section>

                </section>
            </section>
        </section>
       
        <section  id = "services" class = "  w-full md:w-[90%] mt-10  flex flex-wrap h-fit">
                <!--Primer columna-->
                <div class="w-[5%] md:flex  flex-col items-end pt-10 gap-5 z-[100] hidden">
                    <div class ="bg-[#F08A5D] rounded-xl p-2 w-fit h-fit">
                        <i class="fa-solid fa-arrow-down-1-9"></i>
                    </div>
                    <div class ="bg-[#F08A5D] rounded-xl p-2 w-fit h-fit">
                        <i class="fa-solid fa-arrow-down-9-1"></i>
                    </div>
                </div>
                <!--Segunda columna-->
                <!--Acá tiene que ir todos los cursos-->
                <section class = "w-[95%]  min-h-[410px]  ml-[-10px]">
                   <section class="flex gap-8 w-full mb-[-10px] ">
                        <!--PRIMERA VAINA-->
                        <div class ="p-2 w-fit h-fit text-center text-[13px] rounded-xl text-[#fff] bg-[#F08A5D] font-semibold hidden sm:block">
                            <p class = "hidden sm:block">Todos</p>
                        </div>
                        <div class ="p-2 w-fit h-fit text-center text-[13px] rounded-xl text-[#fff] bg-[#f0625dc0] font-semibold whitespace-nowrap">
                            <p class ="flex justify-center items-center"><i class="fa-solid fa-person-military-rifle"></i> <span class = "hidden md:block">Seguridad Física</span> </p>
                        </div>
                        <div class ="p-2 w-fit h-fit text-center text-[13px]  text-sm rounded-xl text-[#fff] bg-[#5d7ff0c0] font-semibold whitespace-nowrap">
                           <p class ="flex justify-center items-center"><i class="fa-solid fa-building-shield"></i> <span class = "hidden md:block">Seguridad Eletrónica</span> </p>
                        </div>
                        <div class ="p-2 w-fit h-fit text-center text-[13px]  text-sm rounded-xl text-[#fff] bg-[#8cf05dc0] font-semibold whitespace-nowrap">
                           <p class ="flex justify-center items-center"><i class="fa-solid fa-shield-heart"></i> <span class = "hidden md:block">Safety & Utilities</span> </p>
                        </div>
                    </section>
                    <section class ="bg-[#1d0931] bg-[url('https://www.transparenttextures.com/patterns/pinstriped-suit.png')] z-[100000] p-6 h-full rounded-lg flex gap-20 flex-wrap">
                        <!--Carta-->
                        <!--Este va a ser por categorias-->
                        <?php for($i = 0; $i < $length; $i++ ):?>
                            <?php for($j = 0; $j < 3; $j++):?>
                                <div class="w-[290px] min-h-[160px] h-fit text-center bg-[#2f0c68] rounded-sm relative flex flex-col justify-between">

                                    <div class ="">
                                        <h3 class = "text-xl font-semibold text-[#ffffff] p-2"><?= $arr_cate[$i]["servicios"][$j]["nombre"] ?></h3>

                                    <p class = "p-2 text-sm"><?= $arr_cate[$i]["servicios"][$j]["descripcion"] ?></p>

                                    <span class = "text-sm text-[#940c0c]">$<?= $arr_cate[$i]["servicios"][$j]["precio_base"] ?></span>
                                    </div>
                                    <div class ="w-full bg-[#d6c2fc] rounded-b-xl p-2 flex justify-center items-center">
                                            <button class = "block  bg-[#F08A5D] pt-1 pb-1 pl-3 pr-3 font-semibold text-center rounded-2xl text-[#240a55] w-[180px] transition-all hover:text-white hover:cursor-pointer hover:bg-[#45188b]">
                                            Añadir al carro
                                        </button>
                                    </div>
                                    
                                        <?php if($i ==0 ): ?>
                                            <div class ="absolute left-[100%] bottom-[75%] bg-[#f0625dc0] rounded-r-xl">
                                                <i class="fa-solid fa-person-military-rifle text-[20px] pt-2 pb-2" ></i>
                                            </div>
                                        <?php elseif($i ==1): ?>
                                            <div class ="absolute left-[100%] bottom-[75%] bg-[#5d7ff0c0] rounded-r-xl">
                                                <i class="fa-solid fa-building-shield text-[20px] pt-2 pb-2"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class ="absolute left-[100%] bottom-[75%] bg-[#8cf05dc0] rounded-r-xl">
                                                <i class="fa-solid fa-user-shield text-[20px] pt-2 pb-2"></i>
                                            </div>
                                        <?php endif ?>
                                        
                                </div>
                            <?php endfor; ?>
                        <?php endfor; ?>
                        
                    </section>  
                </section>
        </section>
    </main>

     <div id="cart-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="w-full max-w-lg bg-[#241535] rounded-2xl shadow-2xl border border-white/5 overflow-hidden">
            
            <div class="bg-[#1a1025] px-6 py-4 flex justify-between items-center border-b border-white/10">
                <div>
                    <h2 class="text-[#F08A5D] text-xl font-bold tracking-tight">Tu Carrito</h2>
                    <p class="text-xs text-gray-400">Tienes <span id="cart-counter" class="text-[#F08A5D]">3</span> servicios seleccionados</p>
                </div>
                <button class="text-gray-400 hover:text-white transition-colors text-2xl" onclick="closeCart()">&times;</button>
            </div>

            <div class="max-height-[400px] overflow-y-auto p-6 space-y-4" id="cart-items-list">
                
                <div class="flex items-center justify-between bg-[#1a1025]/50 p-4 rounded-xl border border-white/5">
                    <div class="flex-1">
                        <h3 class="text-gray-100 font-medium">Asesoría de Arquitectura</h3>
                        <p class="text-[#F08A5D] font-semibold">$50.00</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center bg-[#241535] rounded-lg border border-white/10 overflow-hidden">
                            <button class="px-3 py-1 bg-slate-700/50 hover:bg-slate-700 text-white transition-colors">-</button>
                            <input type="text" value="1" readonly class="w-10 text-center bg-transparent text-sm font-bold text-white focus:outline-none">
                            <button class="px-3 py-1 bg-slate-700/50 hover:bg-slate-700 text-white transition-colors">+</button>
                        </div>

                        <button class="p-2 bg-red-900/30 text-red-400 hover:bg-red-900/50 rounded-lg transition-all" title="Eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                </div>

            <div class="bg-[#1a1025] p-6 border-t border-white/10">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-400 text-lg">Total estimado:</span>
                    <span id="cart-total" class="text-2xl font-bold text-white leading-none">$150.00</span>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <button class="col-span-1 py-3 px-4 bg-slate-700/40 hover:bg-slate-700/60 text-gray-300 rounded-xl font-medium transition-all border border-white/5">
                        Vaciar
                    </button>
                    <button class="col-span-2 py-3 px-4 bg-[#F08A5D] hover:bg-[#e07a4d] text-[#1a1025] rounded-xl font-bold transition-all shadow-lg shadow-[#F08A5D]/10">
                        CONTINUAR COMPRA
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class = "mt-10">

    </footer>
    <script src ="assets/js/service-catalog.js"></script>
</body>
</html>