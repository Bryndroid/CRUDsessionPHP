<?php session_start(); 

    if(isset($_SESSION["quotes"])){
        $arr_session = $_SESSION["quotes"];
    }else{
        $arr_session = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CA Security</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../assets/css/service-catalog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class = "bg-[#241535] bg-[url('https://www.transparenttextures.com/patterns/black-scales.png')] text-white ">
    <header class = "w-full flex flex-wrap justify-around p-4">
       
        <h1 class = "block font-bold text-xl">
            <span class = "text-[#F08A5D]">CA</span> Security | Cotización
        </h1>
        
        <section class =" text-white flex flex-nowrap justify-between text-sm">
            <div class = "text-center pt-1 pb-1 pr-4">
                <ul class = "flex gap-4">
                    <li><a href ="#services"class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">Services</a></li>
                    <li><a class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">Cotizaciones</a></li>
                    <li><a class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">About</a></li>
                </ul>
            </div>
           
            
        </section>
    </header>
    <main class="max-w-7xl mx-auto p-6 space-y-10">
        <section class="bg-white/5 p-6 rounded-xl border border-white/10 shadow-lg animate-fade-in">
            <h3 class="text-[#F08A5D] font-bold mb-4 flex items-center gap-2 uppercase tracking-widest text-sm">
                <i class="fas fa-user-shield"></i> Datos de Facturación | <span class = "text-[#fff]">Completa los campos para generar la cotización...</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label class="text-xs text-gray-400 ml-1">Nombre Completo</label>
                    <input type="text" id="clienteNombre" placeholder="Ej. Bryan Fuentes" 
                        class="bg-[#1a1025] border border-white/10 p-3 rounded-lg focus:outline-none focus:border-[#F08A5D] transition-all text-white">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs text-gray-400 ml-1">Correo Electrónico</label>
                    <input type="email" id="clienteEmail" placeholder="contacto@ejemplo.com" 
                        class="bg-[#1a1025] border border-white/10 p-3 rounded-lg focus:outline-none focus:border-[#F08A5D] transition-all text-white">
                </div>
            </div>
            <button onclick="generarCotizacionFinal()" 
                    class="mt-6 w-full md:w-auto bg-[#F08A5D] hover:bg-[#d9794d] text-[#241535] font-black py-3 px-10 rounded-lg transition-all active:scale-95 cursor-pointer uppercase shadow-lg shadow-[#F08A5D]/20">
                Confirmar y Generar PDF
            </button>
        </section>

        <div id="quote-display-container" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php for ($i = 1; $i <= 2; $i++): ?>
                <div class="bg-white/5 backdrop-blur-md rounded-xl border border-white/10 overflow-hidden shadow-2xl opacity-60">
                    <div class="bg-gray-700/50 p-4">
                        <h2 class="text-white font-bold uppercase flex justify-between">
                            <span>Borrador #00<?php echo $i; ?></span>
                            <i class="fas fa-clock"></i>
                        </h2>
                    </div>
                    <div class="p-10 text-center italic text-gray-500">
                        Esperando datos del cliente...
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <h4 class = "text-[#e2860d] font-semibold text-lg">Historial de Cotización.</h4>
        <div class ="historial-container grid grid-cols-1 md:grid-cols-1 gap-8">
            <div class="bg-white/5 backdrop-blur-md rounded-xl border border-white/10 overflow-hidden shadow-2xl opacity-60">
                <div class="bg-gray-700/50 p-4">
                    <h2 class="text-white font-bold uppercase flex justify-between">
                        <span>Borrador #00</span>
                        <i class="fas fa-clock"></i>
                    </h2>
                </div>
                <div class="p-10 text-center italic text-gray-500">
                    Esperando datos del cliente...
                </div>
            </div>
        </div>
    </main>
    <script>
       const quotesSession = <?php echo json_encode(array_values($arr_session)); ?>;
    </script>
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
    <section class ="">

    </section>
    <script src ="../assets/js/quote.js"></script>
</body>
</html>