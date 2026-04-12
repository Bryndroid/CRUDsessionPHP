
<?php
session_start();
require_once __DIR__ . '/../controllers/AuthController.php';

// Si es admin, redirigir a panel admin
if (AuthController::isAuthenticated() && AuthController::isAdmin()) {
    require_once __DIR__ . '/../views/view-admin.php';
    exit;
}
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
                    <li><a href = "../views/view-quotes.php" class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">Cotizaciones</a></li>
                    <li><a class = "hover:cursor-pointer transition-all hover:text-[#F08A5D]">About</a></li>
                </ul>
            </div>
           
            <button class = "block hover:cursor-pointer bg-[#F08A5D]  pl-3 pr-3 font-semibold text-center rounded-2xl text-[#240a55] w-[100px] transition-all hover:translate-y-1 hover:text-white hover:bg-[#45188b] shadow-[0_0_20px_#F08A5D]" onclick="openCart()" >
                Carrito
            </button>

            <?php if (AuthController::isAuthenticated()): ?>
                    <button class="hover:cursor-pointer bg-[#45188b] border border-[#F08A5D] pl-3 pr-3 font-semibold text-center rounded-2xl text-[#F08A5D] w-auto transition-all hover:bg-[#F08A5D] hover:text-[#240a55]" onclick="document.getElementById('userModal').classList.remove('hidden')">
                        <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                    </button>
                <?php else: ?>
                    <button class = "block hover:cursor-pointer bg-[#45188b] border border-[#F08A5D] pl-3 pr-3 font-semibold text-center rounded-2xl text-[#F08A5D] transition-all hover:bg-[#F08A5D] hover:text-[#240a55] shadow-[0_0_20px_#F08A5D]" onclick="openAuthModal()" >
                        Inicia Sesión
                    </button>
                <?php endif; ?>
            
        </section>
    </header>
    <?php require_once __DIR__ . "/../views/services-catalog.php" ?>
    <?php require_once __DIR__ . "/../views/auth.php" ?>
    
    <script>
        // Mostrar modal de usuario logueado al cargar
        window.addEventListener('load', () => {
            <?php if (AuthController::isAuthenticated()): ?>
                const user = {
                    nombre: '<?php echo htmlspecialchars($_SESSION['nombre']); ?>',
                    rol: "<?php echo htmlspecialchars((string) $_SESSION['rol']); ?>"
                };
                showUserModal(user);
            <?php endif; ?>
        });
    </script>
</body>
</html>