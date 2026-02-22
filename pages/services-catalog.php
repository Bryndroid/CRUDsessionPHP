<?php
    require_once "./db/services.db.php";

    $arr_cate = json_decode(datos_bd, true)["categorias"];
    $length =  count($arr_cate);
?>

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
                <section class = "w-[95%]  min-h-[410px]  ml-[-10px] ">
                   <section class="flex gap-8 w-full mb-[-10px] ">
                        <div class ="all-cards p-2 w-fit h-fit text-center text-[13px] rounded-xl text-[#fff] bg-[#F08A5D] font-semibold hidden sm:block">
                            <p class = "hidden sm:block">Todos</p>
                        </div>
                        <div class ="btn-cat p-2 w-fit h-fit text-center text-[13px] rounded-xl text-[#fff] bg-[#f0625dc0] font-semibold whitespace-nowrap cursor-pointer
                        " data-add-id = "cat01">
                            <p class ="flex justify-center items-center"><i class="fa-solid fa-person-military-rifle"></i> <span class = "hidden md:block">Seguridad Física</span> </p>
                        </div>
                        <div class ="btn-cat p-2 w-fit h-fit text-center text-[13px]  text-sm rounded-xl text-[#fff] bg-[#5d7ff0c0] font-semibold whitespace-nowrap cursor-pointer" data-add-id = "cat02">
                           <p class ="flex justify-center items-center"><i class="fa-solid fa-building-shield"></i> <span class = "hidden md:block">Seguridad Eletrónica</span> </p>
                        </div>
                        <div class ="btn-cat p-2 w-fit h-fit text-center text-[13px]  text-sm rounded-xl text-[#fff] bg-[#8cf05dc0] font-semibold whitespace-nowrap cursor-pointer" data-add-id = "cat03">
                           <p class ="flex justify-center items-center"><i class="fa-solid fa-shield-heart"></i> <span class = "hidden md:block">Safety & Utilities</span> </p>
                        </div>
                    </section>
                    <section class ="bg-[#1d0931] bg-[url('https://www.transparenttextures.com/patterns/pinstriped-suit.png')] z-[100000] p-6 h-full rounded-lg flex gap-20 flex-wrap shadow-[0_0_20px_rgba(168,85,247,0.5)]">
                        <!--Carta-->
                        <!--Este va a ser por categorias-->
                        <?php for($i = 0; $i < $length; $i++ ):?>
                            <?php for($j = 0; $j < count($arr_cate[$i]["servicios"]); $j++):?>
                                <div class="cart-serv w-[290px] min-h-[160px] h-fit text-center bg-[#2f0c68] rounded-sm relative flex flex-col justify-between"     data-category="cat0<?= ($i + 1) ?>">

                                    <div class ="">
                                        <h3 class = "text-xl font-semibold text-[#ffffff] p-2"><?= $arr_cate[$i]["servicios"][$j]["nombre"] ?></h3>

                                    <p class = "p-2 text-sm"><?= $arr_cate[$i]["servicios"][$j]["descripcion"] ?></p>

                                    <span class = "text-sm text-[#940c0c]">$<?= $arr_cate[$i]["servicios"][$j]["precio_base"] ?></span>
                                    </div>
                                    <div class ="w-full bg-[#d6c2fc] rounded-b-xl p-2 flex justify-center items-center">
                                            <button class = "btn-serv block  bg-[#F08A5D] pt-1 pb-1 pl-3 pr-3 font-semibold text-center rounded-2xl text-[#240a55] w-[180px] transition-all hover:text-white hover:cursor-pointer hover:bg-[#45188b]" data-add-id="<?= $arr_cate[$i]["servicios"][$j]["id"] ?>">
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
                        <div class ="w-full bg-[#0000003a] rounded-3xl text-center">
                            <small class ="italic">Los precios son sin contar IVA</small><br>
                            <small class ="italic">Descuentos por: 3-5 servicios = 8%, 6-9 servicios = 12%, 10+ servicios = 18%</small>
                        </div>
                    </section>  
                </section>
        </section>
    </main>

     <div id="cart-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="w-full max-w-lg bg-[#241535]  h-fit rounded-2xl shadow-2xl border border-white/5 overflow-hidden">
            
            <div class="bg-[#1a1025] px-6 py-4 flex justify-between items-center border-b border-white/10">
                <div>
                    <h2 class="text-[#F08A5D] text-xl font-bold tracking-tight">Tu Carrito</h2>
                    <p class="text-xs text-gray-400">Tienes <span id="cart-counter" class="text-[#F08A5D]"></span> servicios</p>
                </div>
                <button class="text-gray-400 hover:text-white transition-colors text-2xl" onclick="closeCart()">&times;</button>
            </div>

                <div class="max-h-[450px] overflow-y-auto p-6 space-y-4" id="cart-items-list">
                    
                
                </div>

            <div class="bg-[#1a1025] p-6 border-t border-white/10">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-400 text-lg">Total estimado:</span>
                    <span id ="desc-text"class = "text-yellow-300 text-sm">Descuento aplicado: 10% </span>
                    <span id="cart-total" class="text-2xl font-bold text-white leading-none"></span>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <button class="col-span-3 py-3 px-4 bg-[#F08A5D] hover:bg-[#e07a4d] text-[#1a1025] rounded-xl font-bold transition-all shadow-lg shadow-[#F08A5D]/10" onclick= "view_Quotes()">
                        GENERAR COTIZACIÓN
                    </button>
                    <small class ="italic w-full">Los precios son sin contar IVA</small><br>
                </div>
            </div>
        </div>
    </div>

    <div id="error-modal" class=" hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/80 backdrop-blur-md p-4 animate-fade-in">
        <div class="w-full max-w-md bg-[#e9a1349f] rounded-2xl shadow-[0_0_40px_rgba(239,68,68,0.25)] border border-red-500/30 overflow-hidden">
            
            <div class="bg-[#111111cc] px-6 py-5 flex items-center gap-4 border-b border-red-500/20">
                <div>
                    <h2 id="error-modal-title" class="text-[#ecbf6b] text-lg font-black uppercase tracking-tighter leading-none">
                        Acceso Denegado
                    </h2>
                    <p class="text-[10px] text-red-400/50 font-mono uppercase tracking-[0.2em] mt-1">Ocurrió un errror: </p>
                </div>
            </div>

            <div class="p-8">
                <p id="error-modal-body" class="text-gray-300 text-sm leading-relaxed text-center font-medium">
                    Ocurrió un error al procesar tu solicitud de cotización. Por favor, verifica los datos e intenta nuevamente.
                </p>
            </div>

            <div class="p-4 pt-0">
                <button onclick="closeErrorModal()" 
                        class="w-full bg-red-600 hover:bg-[#ecbf6b] text-white font-black py-4 rounded-xl transition-all active:scale-95 cursor-pointer uppercase text-xs tracking-[0.3em] shadow-lg shadow-red-900/40">
                    Descartar Notificación
                </button>
            </div>
        </div>
    </div>
    <script src ="assets/js/service-catalog.js"></script>
 