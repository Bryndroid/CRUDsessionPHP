<?php
require_once __DIR__ . '/../config/services.db.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/quote.class.php';
require_once __DIR__ . '/../models/service.class.php';

// Verificar que sea admin
if (!AuthController::isAdmin()) {
    header('Location: index.php');
    exit;
}

// Obtener todas las cotizaciones y servicios
try {
    $cotizaciones = Quote::obtenerTodas($conn);
    $servicios = Service::allService();
} catch (Exception $e) {
    $cotizaciones = [];
    $servicios = [];
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - CA Security</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-[#241535] bg-[url('https://www.transparenttextures.com/patterns/black-scales.png')] text-white">
    <!-- Header -->
    <header class="w-full flex justify-between items-center p-6 border-b border-[#F08A5D]/30">
        <h1 class="text-2xl font-bold">
            <span class="text-[#F08A5D]">CA</span> Security - Panel Admin
        </h1>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-300">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            <button 
                onclick="logout()" 
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-semibold transition-all"
            >
                Cerrar Sesión
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6">
        <!-- Tabs -->
        <div class="flex gap-4 mb-6 border-b border-[#F08A5D]/20">
            <button 
                class="tab-btn active px-6 py-3 font-semibold hover:text-[#F08A5D] transition-all border-b-2 border-[#F08A5D]" 
                data-tab="cotizaciones"
            >
                <i class="fas fa-file-invoice-dollar mr-2"></i>Cotizaciones
            </button>
            <button 
                class="tab-btn px-6 py-3 font-semibold hover:text-[#F08A5D] transition-all border-b-2 border-transparent" 
                data-tab="servicios"
            >
                <i class="fas fa-cogs mr-2"></i>Servicios
            </button>
        </div>

        <!-- Tab: Cotizaciones -->
        <div id="cotizaciones-tab" class="tab-content">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-[#F08A5D]">Cotizaciones en el Sistema</h2>
                <span class="bg-[#F08A5D] text-[#240a55] px-4 py-2 rounded font-semibold">
                    Total: <?php echo count($cotizaciones); ?>
                </span>
            </div>

            <?php if (empty($cotizaciones)): ?>
                <div class="bg-[#1a0f2e] border border-[#F08A5D]/20 rounded-lg p-8 text-center">
                    <i class="fas fa-inbox text-4xl text-[#F08A5D]/50 mb-4"></i>
                    <p class="text-gray-400">No hay cotizaciones en el sistema</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-[#F08A5D]/30">
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Código</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Cliente</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Email</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Empresa</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Subtotal</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Descuento</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">IVA</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Total</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Fecha</th>
                                <th class="text-left px-4 py-3 text-[#F08A5D] font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cotizaciones as $cot): ?>
                                <tr class="border-b border-[#F08A5D]/10 hover:bg-[#1a0f2e] transition-all">
                                    <td class="px-4 py-3 font-mono text-[#F08A5D]"><?php echo htmlspecialchars($cot['Codigo']); ?></td>
                                    <td class="px-4 py-3"><?php echo htmlspecialchars($cot['NombreCliente']); ?></td>
                                    <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($cot['Correo']); ?></td>
                                    <td class="px-4 py-3"><?php echo htmlspecialchars($cot['Empresa'] ?: '-'); ?></td>
                                    <td class="px-4 py-3">$<?php echo number_format($cot['Subtotal'], 2); ?></td>
                                    <td class="px-4 py-3 text-red-400">-$<?php echo number_format($cot['Descuento'], 2); ?></td>
                                    <td class="px-4 py-3">$<?php echo number_format($cot['Iva'], 2); ?></td>
                                    <td class="px-4 py-3 font-bold text-[#F08A5D]">$<?php echo number_format($cot['Total'], 2); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-400"><?php echo date('d/m/Y H:i', strtotime($cot['FechaCreacion'])); ?></td>
                                    <td class="px-4 py-3">
                                        <button 
                                            onclick="eliminarCotizacion(<?php echo $cot['IdCotizacion']; ?>, '<?php echo htmlspecialchars($cot['Codigo']); ?>')"
                                            class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm font-semibold transition-all"
                                        >
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tab: Servicios -->
        <div id="servicios-tab" class="tab-content hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-[#F08A5D]">Servicios Disponibles</h2>
                <div class="flex gap-4">
                    <span class="bg-[#F08A5D] text-[#240a55] px-4 py-2 rounded font-semibold">
                        Total: <?php echo count($servicios); ?>
                    </span>
                    <button 
                        onclick="abrirModalServicio()"
                        class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded font-semibold transition-all"
                    >
                        <i class="fas fa-plus"></i> Agregar Servicio
                    </button>
                </div>
            </div>

            <?php if (empty($servicios)): ?>
                <div class="bg-[#1a0f2e] border border-[#F08A5D]/20 rounded-lg p-8 text-center">
                    <i class="fas fa-inbox text-4xl text-[#F08A5D]/50 mb-4"></i>
                    <p class="text-gray-400">No hay servicios disponibles</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($servicios as $servicio): ?>
                        <div class="bg-gradient-to-b from-[#f0625dc0] to-[#241535] rounded-lg p-6 border border-[#F08A5D]/20 hover:border-[#F08A5D] transition-all">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-bold text-[#F08A5D] flex-1">
                                    <?php echo htmlspecialchars($servicio->jsonSerialize()['nombre']); ?>
                                </h3>
                                <span class="bg-[#F08A5D] text-[#240a55] px-3 py-1 rounded text-sm font-semibold">
                                    ID: <?php echo htmlspecialchars($servicio->jsonSerialize()['id']); ?>
                                </span>
                            </div>

                            <p class="text-gray-300 text-sm mb-4">
                                <?php echo htmlspecialchars(substr($servicio->jsonSerialize()['descripcion'], 0, 120) . '...'); ?>
                            </p>

                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Precio:</span>
                                    <span class="font-bold text-[#F08A5D]">
                                        $<?php echo number_format($servicio->jsonSerialize()['precio'], 2); ?>
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Stock:</span>
                                    <span class="font-bold <?php echo $servicio->jsonSerialize()['stock'] > 0 ? 'text-green-400' : 'text-red-400'; ?>">
                                        <?php echo htmlspecialchars($servicio->jsonSerialize()['stock']); ?> unidades
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Categoría:</span>
                                    <span class="font-mono text-[#F08A5D]">
                                        <?php echo htmlspecialchars($servicio->jsonSerialize()['categoria']); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-2 pt-3 border-t border-[#F08A5D]/10">
                                <button 
                                    onclick="abrirModalEditar(<?php echo $servicio->jsonSerialize()['id']; ?>, '<?php echo htmlspecialchars($servicio->jsonSerialize()['nombre']); ?>', '<?php echo htmlspecialchars($servicio->jsonSerialize()['descripcion']); ?>', <?php echo $servicio->jsonSerialize()['precio']; ?>, <?php echo $servicio->jsonSerialize()['idCategoria']; ?>)"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded text-sm font-semibold transition-all"
                                >
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button 
                                    onclick="eliminarServicio(<?php echo $servicio->jsonSerialize()['id']; ?>, '<?php echo htmlspecialchars($servicio->jsonSerialize()['nombre']); ?>')"
                                    class="flex-1 bg-red-600 hover:bg-red-700 px-3 py-2 rounded text-sm font-semibold transition-all"
                                >
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Modal: Agregar Servicio -->
    <div id="addServiceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-[#241535] rounded-lg shadow-lg w-full max-w-md p-8 border border-[#F08A5D]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#F08A5D]">Agregar Nuevo Servicio</h2>
                <button onclick="cerrarModalServicio()" class="text-gray-400 hover:text-[#F08A5D] text-2xl">×</button>
            </div>

            <form id="formAddService" onsubmit="crearServicio(event)" class="space-y-4">
                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Nombre</label>
                    <input 
                        type="text" 
                        id="servicioNombre" 
                        required 
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                        placeholder="Nombre del servicio"
                    />
                </div>

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Descripción</label>
                    <textarea 
                        id="servicioDescripcion" 
                        required 
                        rows="3"
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                        placeholder="Descripción del servicio"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Precio ($)</label>
                    <input 
                        type="number" 
                        id="servicioPrecio" 
                        required 
                        step="0.01"
                        min="100"
                        max="10000"
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                        placeholder="100 - 10000"
                    />
                    <small class="text-gray-400">Rango: $100 - $10,000</small>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Categoría</label>
                    <select 
                        id="servicioCategoria" 
                        required 
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    >
                        <option value="">Cargando categorías...</option>
                    </select>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-[#F08A5D] text-[#240a55] font-semibold py-2 rounded hover:bg-[#45188b] hover:text-white transition-all"
                >
                    Crear Servicio
                </button>
            </form>
        </div>
    </div>

    <!-- Modal: Editar Servicio -->
    <div id="editServiceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-[#241535] rounded-lg shadow-lg w-full max-w-md p-8 border border-[#F08A5D]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#F08A5D]">Editar Servicio</h2>
                <button onclick="cerrarModalEditar()" class="text-gray-400 hover:text-[#F08A5D] text-2xl">×</button>
            </div>

            <form id="formEditService" onsubmit="actualizarServicio(event)" class="space-y-4">
                <input type="hidden" id="servicioEditId" />

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Nombre</label>
                    <input 
                        type="text" 
                        id="servicioEditNombre" 
                        required 
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                        placeholder="Nombre del servicio"
                    />
                </div>

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Descripción</label>
                    <textarea 
                        id="servicioEditDescripcion" 
                        required 
                        rows="3"
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                        placeholder="Descripción del servicio"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Precio ($)</label>
                    <input 
                        type="number" 
                        id="servicioPrecioEdit" 
                        required 
                        step="0.01"
                        min="100"
                        max="10000"
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                        placeholder="100 - 10000"
                    />
                    <small class="text-gray-400">Rango: $100 - $10,000</small>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2 text-sm font-semibold">Categoría</label>
                    <select 
                        id="servicioCategoriEdit" 
                        required 
                        class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    >
                        <option value="">Cargando categorías...</option>
                    </select>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-[#F08A5D] text-[#240a55] font-semibold py-2 rounded hover:bg-[#45188b] hover:text-white transition-all"
                >
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>

    <script src="./assets/js/admin.js"></script>
</body>
</html>
