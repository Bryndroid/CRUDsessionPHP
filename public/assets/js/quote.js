
async function generarCotizacionFinal() {
    const telefono = document.querySelector("#clienteTelefono").value;
    const empresa = document.querySelector("#clienteEmpresa").value;

    const cliente = { telefono, empresa };
    const resp = await postJson('../routes/quote/process-quote.php', cliente);

    if (resp.success) {


        // render inmediato
        renderizarTablasEspejo(resp.quote);
        console.log(resp.quote);
    } else {
        showError("Error en la Cotización", resp.message);
    }
}
async function postJson(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    return res.json();
}


function renderizarTablasEspejo(quote) {
    quote = normalizarQuote(quote);
    const container = document.getElementById('quote-display-container');
    container.innerHTML = ''; // Limpiar borradores

    // Generar 2 tablas (Original y Copia)
    for (let i = 1; i <= 2; i++) {
        const esCopia = i === 2;
        const html = `
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-2xl animate-fade-in relative">
            <div class="absolute top-2 right-4 text-[9px] font-bold text-white/20 uppercase tracking-[0.2em]">
                ${esCopia ? 'Copia Archivo' : 'Original Cliente'}
            </div>
            
            <div class="bg-[#F08A5D] p-5">
                <h2 class="text-[#241535] font-black uppercase text-xl leading-none">CA Security</h2>
                <p class="text-[#241535]/70 text-[10px] font-bold mt-1">${quote.id} | ${quote.fecha}</p>
            </div>

            <div class="p-5 border-b border-white/5 bg-white/2">
                <span class="text-[10px] text-[#F08A5D] font-bold uppercase">Preparado para:</span>
                <h3 class="text-lg font-bold text-white leading-tight">${quote.cliente.nombre}</h3>
                <p class="text-xs text-gray-400">${quote.cliente.email}</p>
            </div>

            <div class="p-5">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[#F08A5D] text-[10px] uppercase border-b border-white/10">
                            <th class="pb-2">Servicio</th>
                            <th class="pb-2 text-center">Cant.</th>
                            <th class="pb-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${Object.values(quote.items).map(item => `
                            <tr class="border-b border-white/5">
                                <td class="py-3">
                                    <div class="font-bold text-gray-200">${item.servicio.nombre}</div>
                                    <div class="text-[10px] text-gray-500">${item.servicio.categoria}</div>
                                </td>
                                <td class="py-3 text-center text-gray-300">${item.cantidad}</td>
                                <td class="py-3 text-right font-bold text-white">$${(item.servicio.precio * item.cantidad).toFixed(2)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>

            <div class="p-5 bg-black/40 flex justify-between items-center mt-auto">
                <div class="text-[10px] text-gray-500 leading-tight">
                    * Validez: 15 días hábiles<br>
                    * Precios incluyen IVA
                    * <small>Descuento: - $ ${quote.descuento}</small>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Total Final</p>
                    <p class="text-3xl font-black text-[#F08A5D]">$${quote.total.toFixed(2)}</p>
                </div>
            </div>
        </div>
        `;
        console.log(quote);
        container.insertAdjacentHTML('beforeend', html);
    }
}
document.addEventListener("DOMContentLoaded", () => {
    if (typeof quotesSession !== "undefined") {
        console.log(quotesSession);
        renderizarHistorial(quotesSession);
    }
});
function renderizarHistorial(quotes) {
    const container = document.querySelector('.historial-container');

    if (!quotes || quotes.length === 0) {
        container.innerHTML = `
            <div class="p-10 text-center italic text-gray-500">
                No hay cotizaciones previas...
            </div>
        `;
        return;
    }

    container.innerHTML = '';

    quotes
        .map(normalizarQuote)
        .forEach(quote => {
            container.insertAdjacentHTML(
                'beforeend',
                crearQuoteCard(quote, { tipo: 'historial' })
            );
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
        // Bloqueamos el scroll del body para que el usuar  nfoque en el error
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
function normalizarQuote(quote) {
    return {
        ...quote,
        fecha: quote.fechaCreacion, // unificamos nombre
        items: quote.items || {}    // evitar undefined
    };
}

function renderItems(items, small = false) {
    console.log(items);
    return Object.values(items).map(item => `
        <tr class="border-b border-white/5">
            <td class="py-${small ? '2' : '3'} text-gray-300">
                ${item.servicio.nombre}
            </td>
            <td class="py-${small ? '2' : '3'} text-center">
                ${item.cantidad}
            </td>
            <td class="py-${small ? '2' : '3'} text-right font-bold">
                $${(item.servicio.precio * item.cantidad).toFixed(2)}
            </td>
        </tr>
    `).join('');
}

function crearQuoteCard(quote, options = {}) {
    const { tipo = 'historial' } = options;
    console.log(quote);
    const esHistorial = tipo === 'historial';

    return `
    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-2xl mb-6">
        
        <div class="bg-[#F08A5D] p-${esHistorial ? '4' : '5'}">
            <h2 class="text-[#241535] font-black uppercase text-${esHistorial ? 'sm' : 'xl'}">
                ${quote.codigo} | ${quote.fecha}
            </h2>
        </div>

        <div class="p-${esHistorial ? '4' : '5'} border-b border-white/5">
            <span class="text-[10px] text-[#F08A5D] font-bold uppercase">Cliente:</span>
            <h3 class="text-${esHistorial ? 'md' : 'lg'} font-bold text-white">
                ${quote.cliente.nombre}
            </h3>
            <p class="text-xs text-gray-400">${quote.cliente.email}</p>
        </div>

        <div class="p-${esHistorial ? '4' : '5'}">
            <table class="w-full text-left text-${esHistorial ? 'xs' : 'sm'}">
                <thead>
                    <tr class="text-[#F08A5D] uppercase border-b border-white/10">
                        <th class="pb-2">Servicio</th>
                        <th class="pb-2 text-center">Cant.</th>
                        <th class="pb-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${renderItems(quote.items, esHistorial)}
                </tbody>
            </table>
            <small class="text-gray-400">
                Descuento: - $ ${quote.descuento}
            </small>
        </div>

        <div class="p-${esHistorial ? '4' : '5'} bg-black/40 flex justify-between items-center">
            <span class="text-xs text-gray-400 uppercase font-bold">Total</span>
            <span class="text-${esHistorial ? 'xl' : '3xl'} font-black text-[#F08A5D]">
                $${parseInt(quote.total).toFixed(2)}
            </span>
        </div>
    </div>
    `;
}