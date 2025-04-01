<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite([ 'resources/js/app.js','resources/css/login.css'])
    @include('components.alertas')

</head>

<body>
    <div id="divpadre loginForm">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <img style="width: 190px;" src="{{ asset('imagenes/logopgweb.png') }}">
            <p></p>
            <input class="form-control" type="email" name="email" id="email" placeholder="Ingrese su Correo:" required>
            <p></p>
            <input class="form-control" type="password" name="password" id="password" placeholder="Ingrese su Contraseña" required>
            <p></p>
            <button id="btiniciarsesion" type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesion</button>
        </form>
        <p></p>
        <!-- Mostrar mensajes de error -->
        @if ($errors->any())
        <div style="color: white;" class="error-messages">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <!-- Enlace que abrirá el modal -->
        <a style="color: white;" href="#" id="openRegisterModal">¿No tienes una cuenta? Regístrate aquí</a>
    </div>
</body>

<script>
    document.getElementById('openRegisterModal').addEventListener('click', function(event) {
        event.preventDefault();

        fetch('autenticacion/registro')
            .then(response => response.text())
            .then(html => {
                Swal.fire({
                    title: 'Registro de Usuario',
                    html: html,
                    showConfirmButton: false
                });

                document.getElementById('registerForm').addEventListener('submit', function() {
                    Swal.close();
                });
            });
    });
</script>

</html>