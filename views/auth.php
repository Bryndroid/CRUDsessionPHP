<div id="authModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-[#241535] rounded-lg shadow-lg w-96 p-8 border border-[#F08A5D]">
        <div class="flex justify-between items-center mb-6">
            <h2 id="authTitle" class="text-2xl font-bold text-[#F08A5D]">Iniciar Sesión</h2>
            <button onclick="closeAuthModal()" class="text-gray-400 hover:text-[#F08A5D] text-2xl">×</button>
        </div>

        <div id="authMessage" class="mb-4"></div>

        <!-- Formulario de Login -->
        <form id="loginForm" class="space-y-4" style="display: block;">
            <div>
                <label class="block text-gray-300 mb-2 text-sm font-semibold">Email</label>
                <input 
                    type="email" 
                    id="loginEmail" 
                    name="email" 
                    required 
                    class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    placeholder="tu@email.com"
                />
            </div>

            <div>
                <label class="block text-gray-300 mb-2 text-sm font-semibold">Contraseña</label>
                <input 
                    type="password" 
                    id="loginPassword" 
                    name="password" 
                    required 
                    class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    placeholder="Tu contraseña"
                />
            </div>

            <button 
                type="submit"
                class="w-full bg-[#F08A5D] text-[#240a55] font-semibold py-2 rounded hover:bg-[#45188b] hover:text-white transition-all"
            >
                Iniciar Sesión
            </button>
        </form>

        <!-- Formulario de Registro -->
        <form id="registerForm" class="space-y-4" style="display: none;">
            <div>
                <label class="block text-gray-300 mb-2 text-sm font-semibold">Nombre Completo</label>
                <input 
                    type="text" 
                    id="registerNombre" 
                    name="nombre" 
                    required 
                    class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    placeholder="Tu nombre"
                    minlength="3"
                />
            </div>

            <div>
                <label class="block text-gray-300 mb-2 text-sm font-semibold">Email</label>
                <input 
                    type="email" 
                    id="registerEmail" 
                    name="email" 
                    required 
                    class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    placeholder="tu@email.com"
                />
            </div>

            <div>
                <label class="block text-gray-300 mb-2 text-sm font-semibold">Contraseña</label>
                <input 
                    type="password" 
                    id="registerPassword" 
                    name="password" 
                    required 
                    class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    placeholder="Mínimo 6 caracteres"
                    minlength="6"
                />
            </div>

            <div>
                <label class="block text-gray-300 mb-2 text-sm font-semibold">Confirmar Contraseña</label>
                <input 
                    type="password" 
                    id="registerConfirmPassword" 
                    name="confirm_password" 
                    required 
                    class="w-full px-4 py-2 rounded bg-[#1a0f2e] border border-[#F08A5D] text-white focus:outline-none focus:ring-2 focus:ring-[#F08A5D]"
                    placeholder="Confirma tu contraseña"
                    minlength="6"
                />
            </div>

            <button 
                type="submit"
                class="w-full bg-[#F08A5D] text-[#240a55] font-semibold py-2 rounded hover:bg-[#45188b] hover:text-white transition-all"
            >
                Registrarse
            </button>
        </form>

        <!-- Toggle entre Login y Registro -->
        <div class="mt-6 text-center">
            <p id="toggleText" class="text-gray-400 text-sm">
                ¿No tienes cuenta? 
                <button 
                    type="button"
                    onclick="toggleAuthForm()" 
                    class="text-[#F08A5D] hover:underline font-semibold"
                >
                    Regístrate
                </button>
            </p>
        </div>
    </div>
</div>

<!-- Modal de usuario logueado -->
<div id="userModal" class="hidden fixed top-4 right-4 bg-[#1a0f2e] border border-[#F08A5D] rounded-lg shadow-lg p-4 w-72">
    <div class="flex items-center gap-4">
        <div>
            <p class="text-gray-300 text-sm">Bienvenido,</p>
            <p id="userNameDisplay" class="text-[#F08A5D] font-bold"></p>
            <p id="userRoleDisplay" class="text-gray-400 text-xs mt-1"></p>
        </div>
        <button 
            onclick="logoutUser()" 
            class="ml-auto bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-semibold"
        >
            Salir
        </button>
    </div>
</div>

<script>
function openAuthModal() {
    document.getElementById('authModal').classList.remove('hidden');
    resetAuthForms();
}

function closeAuthModal() {
    document.getElementById('authModal').classList.add('hidden');
}

function toggleAuthForm() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const authTitle = document.getElementById('authTitle');
    const toggleText = document.getElementById('toggleText');

    if (loginForm.style.display !== 'none') {
        // Cambiar a registro
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        authTitle.textContent = 'Registrarse';
        toggleText.innerHTML = '¿Ya tienes cuenta? <button type="button" onclick="toggleAuthForm()" class="text-[#F08A5D] hover:underline font-semibold">Inicia Sesión</button>';
    } else {
        // Cambiar a login
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        authTitle.textContent = 'Iniciar Sesión';
        toggleText.innerHTML = '¿No tienes cuenta? <button type="button" onclick="toggleAuthForm()" class="text-[#F08A5D] hover:underline font-semibold">Regístrate</button>';
    }
    clearAuthMessage();
}

function resetAuthForms() {
    document.getElementById('loginForm').reset();
    document.getElementById('registerForm').reset();
    clearAuthMessage();
}

function clearAuthMessage() {
    document.getElementById('authMessage').textContent = '';
    document.getElementById('authMessage').className = 'mb-4';
}

function showAuthMessage(message, isSuccess) {
    const messageDiv = document.getElementById('authMessage');
    messageDiv.textContent = message;
    messageDiv.className = `mb-4 p-3 rounded text-sm ${isSuccess ? 'bg-green-900 text-green-200 border border-green-700' : 'bg-red-900 text-red-200 border border-red-700'}`;
}

// Manejar login
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
        const response = await fetch('../routes/user/login-user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (data.success) {
            showAuthMessage(data.message, true);
            setTimeout(() => {
                closeAuthModal();
                showUserModal(data.user);
                location.reload();
            }, 1000);
        } else {
            showAuthMessage(data.message, false);
        }
    } catch (error) {
        showAuthMessage('Error en la solicitud', false);
    }
});

// Manejar registro
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const nombre = document.getElementById('registerNombre').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;
    const confirm_password = document.getElementById('registerConfirmPassword').value;

    try {
        const response = await fetch('../routes/user/register-user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nombre, email, password, confirm_password })
        });

        const data = await response.json();

        if (data.success) {
            showAuthMessage('Registro exitoso. Ahora inicia sesión.', true);
            setTimeout(() => {
                toggleAuthForm();
                document.getElementById('loginEmail').value = email;
            }, 1500);
        } else {
            showAuthMessage(data.message, false);
        }
    } catch (error) {
        showAuthMessage('Error en la solicitud', false);
    }
});

function showUserModal(user) {
    const userModal = document.getElementById('userModal');
    document.getElementById('userNameDisplay').textContent = user.nombre;
    console.log(user)
    const roleText = user.rol;
    document.getElementById('userRoleDisplay').textContent = roleText;
    
   userModal.classList.remove('hidden'); 
   
}

async function logoutUser() {
    try {
        const response = await fetch('../routes/user/logout-user.php', {
            method: 'POST'
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('userModal').classList.add('hidden');
            location.reload();
        }
    } catch (error) {
        alert('Error al cerrar sesión');
    }
}

// Cerrar modal al hacer click fuera
document.getElementById('authModal').addEventListener('click', (e) => {
    if (e.target.id === 'authModal') {
        closeAuthModal();
    }
});
</script>
