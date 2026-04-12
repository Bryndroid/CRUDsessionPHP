/**
 * admin.js - Manejo de operaciones del panel administrador
 */

// Eliminar una cotización
async function eliminarCotizacion(idCotizacion, codigo) {
    if (!confirm(`¿Estás seguro de que deseas eliminar la cotización ${codigo}?`)) {
        return;
    }

    try {
        const response = await fetch('../routes/quote/delete-quote.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idCotizacion })
        });

        const data = await response.json();

        if (data.success) {
            alert('Cotización eliminada exitosamente');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al eliminar la cotización: ' + error.message);
    }
}

// Abrir modal para agregar servicio
function abrirModalServicio() {
    document.getElementById('addServiceModal').classList.remove('hidden');
}

// Cerrar modal de servicio
function cerrarModalServicio() {
    document.getElementById('addServiceModal').classList.add('hidden');
    document.getElementById('formAddService').reset();
}

// Crear nuevo servicio
async function crearServicio(event) {
    event.preventDefault();

    const nombre = document.getElementById('servicioNombre').value.trim();
    const descripcion = document.getElementById('servicioDescripcion').value.trim();
    const precio = parseFloat(document.getElementById('servicioPrecio').value);
    const idCategoria = parseInt(document.getElementById('servicioCategoria').value);

    if (!nombre || !descripcion || !precio || !idCategoria) {
        alert('Por favor completa todos los campos');
        return;
    }

    try {
        const response = await fetch('../routes/service/add-service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombre,
                descripcion,
                precio,
                idCategoria
            })
        });

        const data = await response.json();

        if (data.success) {
            alert('Servicio creado exitosamente');
            cerrarModalServicio();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al crear el servicio: ' + error.message);
    }
}

// Eliminar servicio
async function eliminarServicio(idServicio, nombre) {
    if (!confirm(`¿Estás seguro de que deseas eliminar el servicio "${nombre}"?`)) {
        return;
    }

    try {
        const response = await fetch('../routes/service/delete-service.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idServicio })
        });

        const data = await response.json();

        if (data.success) {
            alert('Servicio eliminado exitosamente');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al eliminar el servicio: ' + error.message);
    }
}

// Abrir modal para editar servicio
function abrirModalEditar(idServicio, nombre, descripcion, precio, idCategoria) {
    document.getElementById('servicioEditId').value = idServicio;
    document.getElementById('servicioEditNombre').value = nombre;
    document.getElementById('servicioEditDescripcion').value = descripcion;
    document.getElementById('servicioPrecioEdit').value = precio;
    document.getElementById('servicioCategoriEdit').value = idCategoria;
    
    // Cargar categorías
    cargarCategoriasEditar();
    
    document.getElementById('editServiceModal').classList.remove('hidden');
}

// Cerrar modal de editar
function cerrarModalEditar() {
    document.getElementById('editServiceModal').classList.add('hidden');
    document.getElementById('formEditService').reset();
}

// Actualizar servicio
async function actualizarServicio(event) {
    event.preventDefault();

    const idServicio = document.getElementById('servicioEditId').value;
    const nombre = document.getElementById('servicioEditNombre').value.trim();
    const descripcion = document.getElementById('servicioEditDescripcion').value.trim();
    const precio = parseFloat(document.getElementById('servicioPrecioEdit').value);
    const idCategoria = parseInt(document.getElementById('servicioCategoriEdit').value);

    if (!nombre || !descripcion || !precio || !idCategoria) {
        alert('Por favor completa todos los campos');
        return;
    }

    try {
        const response = await fetch('../routes/service/update-service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idServicio,
                nombre,
                descripcion,
                precio,
                idCategoria
            })
        });

        const data = await response.json();

        if (data.success) {
            alert('Servicio actualizado exitosamente');
            cerrarModalEditar();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al actualizar el servicio: ' + error.message);
    }
}

// Cargar categorías
async function cargarCategorias() {
    try {
        const response = await fetch('../routes/service/get-categories.php');
        const data = await response.json();
        console.log(data);
        if (data.success && Array.isArray(data.categorias)) {
            const select = document.getElementById('servicioCategoria');
            select.innerHTML = '<option value="">Selecciona una categoría...</option>';
           
            data.categorias.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id; // Usar el primer ID
                option.textContent = cat;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error al cargar categorías:', error);
    }
}

// Cargar categorías en modal de editar
async function cargarCategoriasEditar() {
    try {
        const response = await fetch('../routes/service/get-categories.php');
        const data = await response.json();
        
        if (data.success && Array.isArray(data.categorias)) {
            const select = document.getElementById('servicioCategoriEdit');
            const currentValue = select.value;
            select.innerHTML = '<option value="">Selecciona una categoría...</option>';
            
            data.categorias.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.nombre;
                select.appendChild(option);
            });
            
            // Restaurar la selección anterior
            if (currentValue) {
                select.value = currentValue;
            }
        }
    } catch (error) {
        console.error('Error al cargar categorías:', error);
    }
}

// Cambiar tabs
function cambiarTab(event) {
    const tabBtn = event.currentTarget;
    
    // Remover clases activas
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('border-[#F08A5D]');
        b.classList.add('border-transparent');
    });
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });

    // Agregar clases activas
    tabBtn.classList.add('border-[#F08A5D]');
    tabBtn.classList.remove('border-transparent');
    const tabId = tabBtn.getAttribute('data-tab') + '-tab';
    document.getElementById(tabId).classList.remove('hidden');
}

// Logout
function logout() {
    fetch('../routes/user/logout-user.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'index.php';
        }
    });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Cargar categorías
    cargarCategorias();
    
    // Agregar listeners a los tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', cambiarTab);
    });
});
