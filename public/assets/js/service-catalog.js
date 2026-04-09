/* service-catalog.js
   ------------------------------------------------------------------
   Este script se encarga de manejar el carrito en el front‑end.
   Contiene funciones para abrir/cerrar el modal, realizar peticiones
   a los endpoints PHP y actualizar la interfaz con la información
   devuelta por el servidor.
   ------------------------------------------------------------------ */

var services_bd;
document.addEventListener("DOMContentLoaded", async function () {
    services = await getCart();
    if(services != null || services != undefined){
        services_bd = services;
        refreshCart(services);
    }
});
// acceso rápido al modal de carrito
const cartModal = document.getElementById('cart-modal');

// funciones utilitarias para mostrar/ocultar el modal
function openCart() {
    cartModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // evitar scroll de fondo
}

function closeCart() {
    cartModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// cerrar modal si se hace clic fuera de él
window.onclick = function(event) {
    if (event.target == cartModal) {
        closeCart();
    }
}

// cerrar con la tecla Escape
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !cartModal.classList.contains('hidden')) {
        closeCart();
    }
});

// ------------------------------------------------------------------
// funciones que llaman a los endpoints AJAX. Todas usan postJson para
// enviar JSON y esperar una respuesta JSON.
// ------------------------------------------------------------------

// realiza POST con JSON y devuelve el cuerpo deserializado
async function postJson(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    return res.json();
}

// agrega un servicio al carrito de sesión
async function addToCart(id) {
    const resp = await postJson('../routes/add-to-cart.php', { id });
    console.log(resp);
    if(resp.success){
        refreshCart(resp);
    }else{
        showError("Error al Añadir Servicio", resp.message);
    }
}

// modifica la cantidad de un servicio
async function updateCart(id, cantidad) {
    const resp = await postJson('../routes/update-cart.php', { id, cantidad });
    console.log(resp);
    if(resp.success){
        refreshCart(resp);
    }else{
        showError("Error al Actualizar", resp.message);
    }

}

// elimina un servicio del carrito
async function removeFromCart(id) {
    const resp = await postJson('../routes/remove-from-cart.php', { id });
    console.log(resp);
    if(resp.success){
        refreshCart(resp);
    }
    else{
        showError("Error al Añadir Eliminar", resp.message);
    }

}

// genera la cotización enviando los datos del cliente
async function processQuote(cliente) {
    const resp = await postJson('../routes/process-quote.php', cliente);
    console.log(resp);
    if(resp.success){
        refreshCart(resp);
    }else{
        showError("Error al Procesar Cuota", resp.message);
    }

}
async function getCart(){
    const resp =  await fetch("../routes/get-service.php");
    return resp.json();
}

// ------------------------------------------------------------------
// actualiza la interfaz con los datos del carrito devueltos por el
// servidor. Crea los elementos HTML para cada ítem y rellena totales.
// ------------------------------------------------------------------

function refreshCart(data) {
    if (!data) return;
    const container = document.getElementById('cart-items-list');
    const counter = document.getElementById('cart-counter');
    const totalEl = document.getElementById('cart-total');

    // actualizar contador y total
    if (counter) counter.textContent = data.items ?? 0;
    if (totalEl) totalEl.textContent = '$' + (data.total ?? 0).toFixed(2);

    if (!container) return;
    container.innerHTML = '';
    
    // construir filas del carrito
    for (const id in (data.cart || {})) {
        const item = data.cart[id];
        
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between bg-[#1a1025]/50 p-4 rounded-xl border border-white/5';
            div.innerHTML = `
                <div class="flex-1">
                        <h3 class="text-gray-100 font-medium">${item.servicio.nombre}</h3>
                        <p class="text-[#F08A5D] font-semibold">$${item.servicio.precio.toFixed(2)}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center bg-[#241535] rounded-lg border border-white/10 overflow-hidden">
                            <button class="px-3 py-1 bg-slate-700/50 hover:bg-slate-700 text-white transition-colors" data-action="decrease" data-id="${id}">-</button>
                            <input type="text" value="${item.cantidad}" readonly class="w-10 text-center bg-transparent text-sm font-bold text-white focus:outline-none">
                            <button class="px-3 py-1 bg-slate-700/50 hover:bg-slate-700 text-white transition-colors" data-action="increase" data-id="${id}">+</button>
                        </div>
                        <button class="p-2 bg-red-900/30 text-red-400 hover:bg-red-900/50 rounded-lg transition-all" title="Eliminar" data-action="remove" data-id="${id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>`;
            container.appendChild(div);
    }
    console.log(data.descuento);
    if(data.descuento != 0){
                document.querySelector("#desc-text").innerHTML = "Descuento aplicado: " + data.descuento*100 + "%";
            }else{
                document.querySelector("#desc-text").innerHTML = "";
            }
}

// ------------------------------------------------------------------
// delegación de eventos dentro del modal para manejar aumentos,
// disminuciones y eliminación sin necesidad de reañadir listeners.
// ------------------------------------------------------------------

cartModal.addEventListener('click', (e) => {
    const action = e.target.closest('button')?.dataset.action;
    const id = e.target.closest('button')?.dataset.id;
    if (!action || !id) return;

    if (action === 'remove') {
        removeFromCart(id);
    } else if (action === 'increase' || action === 'decrease') {
        const input = e.target.closest('.flex').querySelector('input');
        let qty = parseInt(input.value, 10);
        qty += action === 'increase' ? 1 : -1;
        if (qty < 1) { removeFromCart(id); return; }
        updateCart(id, qty);
    }
});

// ------------------------------------------------------------------
// detectar clicks en botones "Añadir al carro" que genera PHP mediante
// data-add-id en las tarjetas de servicio.
// ------------------------------------------------------------------
let btnserv =  document.querySelectorAll(".btn-serv");
btnserv.forEach(t=>{
    t.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-add-id]');
        if (btn) {
            const id = btn.dataset.addId;
            addToCart(id);
        }
    });
})


// si se desea, al cargar la página se puede consultar el estado actual
// del carrito en la sesión (aunque inicialmente normalmente estará vacío)

async function view_Quotes() {
    // 1. Validar que el carrito no esté vacío (opcional pero recomendado)
    const currentCart = await getCart();
    if (!currentCart || Object.keys(currentCart.cart || {}).length === 0) {
        
        showError("Error en el Carrito", "El carrito está vacios");

        
        return;
    }else{
        window.location.href = "../../../views/view-quotes.php";
    }

   
}

let btnCates = document.querySelectorAll(".btn-cat");
let cards = document.querySelectorAll(".cart-serv");

btnCates.forEach(btn => {
    btn.addEventListener("click", () => {
        const categoriaSeleccionada = btn.dataset.addId;

        cards.forEach(card => {
            //Para evitar el btn todos
            if (!categoriaSeleccionada || card.dataset.category === categoriaSeleccionada) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });
});

// Lógica "Todos" 
const btnTodos = document.querySelector('.all-cards'); 
if(btnTodos) {
    btnTodos.classList.add('cursor-pointer');
    btnTodos.addEventListener('click', () => {
        cards.forEach(card => card.classList.remove('hidden'));
    });
}

function showError(titulo, mensaje) {
    const modal = document.getElementById('error-modal');
    const titleEl = document.getElementById('error-modal-title');
    const bodyEl = document.getElementById('error-modal-body');

    if (modal && titleEl && bodyEl) {
        titleEl.textContent = titulo;
        bodyEl.textContent = mensaje;
        
        modal.classList.remove('hidden');
        // Bloqueamos el scroll del body para que el usuario se enfoque en el error
        document.body.style.overflow = 'hidden'; 
    }
}

function closeErrorModal() {
    const modal = document.getElementById('error-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}



