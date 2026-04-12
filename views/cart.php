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