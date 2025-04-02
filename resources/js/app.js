// Asegúrate de importar jQuery primero
import $ from 'jquery'; 
window.$ = $;
window.jQuery = $;
// Luego importa otros recursos
import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'; // Importa los estilos de Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Importa Bootstrap con Popper.js incluido
import '@fortawesome/fontawesome-free/js/all';
// import 'izitoast/dist/css/iziToast.min.css';
// import iziToast from 'izitoast';
import Swal from "sweetalert2";
window.Swal = Swal;


document.addEventListener('DOMContentLoaded', () => {
    window.loadPage = function (page) {
        fetch(page)
            .then(response => response.text())
            .then(html => {
                document.querySelector('main').innerHTML = html;
            })
            .catch(error => console.error('Error al cargar la página:', error));
    };
});


// Confirmación global para formularios de eliminación
document.querySelectorAll('.btn-eliminar').forEach(boton => {
    boton.addEventListener('click', () => {
        const url = boton.dataset.url;
        const id = boton.dataset.id;

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡Esto no se puede deshacer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (res.ok) {
                        // 🔥 Eliminar la fila del DOM
                        const fila = document.getElementById(`fila-${id}`);
                        if (fila) fila.remove();

                        // ✅ Mostrar alerta de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'El equipo fue eliminado correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Error', 'No se pudo eliminar', 'error');
                    }
                });
            }
        });
    });
});

// script para desactivar boton al hacer click
document.addEventListener('DOMContentLoaded', function () {
    let lastClickedButton = null;

    // Detecta el último botón que se clickeó
    document.querySelectorAll('button[type="submit"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            lastClickedButton = btn;
        });
    });

    // Al enviar cualquier formulario...
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (lastClickedButton && form.contains(lastClickedButton)) {
                lastClickedButton.disabled = true;

                if (!lastClickedButton.dataset.originalText) {
                    lastClickedButton.dataset.originalText = lastClickedButton.innerHTML;
                }

                lastClickedButton.innerText = 'Espere...';
            }
        });
    });
});

