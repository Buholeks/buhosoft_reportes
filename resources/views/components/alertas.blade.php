{{-- resources/views/components/alertas.blade.php --}}
@if (session('mensaje') && session('tipo'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let tipo = '{{ session("tipo") }}';
            let icono = 'info';
            let titulo = 'Aviso';
            let sonido = '';

            switch (tipo) {
                case 'creado':
                    icono = 'success';
                    titulo = '¡Registrado!';
                    sonido = '/sounds/success.mp3';
                    break;
                case 'actualizado':
                    icono = 'info';
                    titulo = '¡Actualizado!';
                    sonido = '/sounds/update.mp3';
                    break;
                case 'eliminado':
                    icono = 'success';
                    titulo = '¡Eliminado!';
                    sonido = '/sounds/delete.mp3';
                    break;
                case 'error':
                    icono = 'error';
                    titulo = '¡Error!';
                    sonido = '/sounds/error.mp3';
                    break;
            }

            // ✅ Reproducir sonido si existe
            if (sonido) {
                const audio = new Audio(sonido);
                audio.play();
            }
            
            // ✅ Mostrar SweetAlert con animación
            Swal.fire({
                icon: icono,
                title: titulo,
                text: '{{ session("mensaje") }}',
                showConfirmButton: false,
                timer: 4000,
                toast: true,
                position: 'center',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const audio = new Audio('/sounds/error.mp3');
            audio.play();

            Swal.fire({
                icon: 'error',
                title: 'Errores de Validación',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                showClass: {
                    popup: 'animate__animated animate__shakeX'
                }
            });
        });
    </script>
@endif
