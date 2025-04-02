<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BuhoSoft')</title>
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/js/buscar.js,resources/css/paginas.css'])
    @include('components.alertas')

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<header class="header" style="display: flex; justify-content: space-between;">
    <div>
        <img src="{{ asset('imagenes/logopgweb.png') }}" alt="Logo" class="logo">
    </div>
    <div style="display: flex; align-items: center;">
        @php
            $sucursalSelected = session('sucursal_id');
        @endphp

        @if (!$sucursalSelected)
            <script>
                window.location.href = "{{ route('vista_sucursal') }}";
            </script>
        @endif

        @php
            $userId = session('user_id');
            $empresaId = session('empresa_id');
            $sucursalId = session('sucursal_id');

            // Suponiendo que tienes modelos User, Empresa y Sucursal
            $user = \App\Models\User::find($userId);
            $empresa = \App\Models\Empresa::find($empresaId);
            $sucursal = \App\Models\Sucursal::find($sucursalId);
        @endphp

        <p style="margin-right: 30px;"><i class="fa-solid fa-user"></i> {{ $user ? $user->name : 'N/A' }}</p>
        <p style="margin-right: 30px;"><i class="fa-regular fa-building"></i>
            {{ $empresa ? $empresa->nom_empresa : 'N/A' }}</p>
        <p><i class="fa-solid fa-shop"></i> {{ $sucursal ? $sucursal->nombre : 'N/A' }}</p>
    </div>

    <div>
        <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="d-flex align-items-center p-2 text-white text-decoration-none">
            <i class="fa-solid fa-sign-out-alt"></i> <span>Cerrar Sesión</span>
        </a>
    </div>
</header>

<body>
    <div class="content-wrapper">
        <nav class="sidebar text-white p-3" style="width: 13rem; height: calc(100vh - 5rem); overflow-y: auto;">
            <ul class="list-unstyled">
                <li>
                    <a href="#" class="d-flex align-items-center p-2 text-white text-decoration-none"
                        data-bs-toggle="collapse" data-bs-target="#submenu-equipos">
                        <i class="fa-solid fa-mobile"></i>
                        <span class="ms-2">Equipos</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>
                    <ul id="submenu-equipos" class="collapse list-unstyled ps-4">
                        @can('vista equipos_local')
                            <li>
                                <a href="{{ route('equipos.create') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <span class="ms-2">Registrar Venta</span>
                                </a>
                            </li>
                        @endcan
                        @can('vista equipos_admin')
                            <li>
                                <a href="{{ route('equipos.index') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none">
                                    <i class="fa-solid fa-mobile"></i>
                                    <span class="ms-2">Administracion</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can('vista chip')
                    <li>
                        <a href="{{ route('chip') }}" class="d-flex align-items-center p-2 text-white text-decoration-none">
                            <i class="fa-solid fa-sim-card"></i>
                            <span class="ms-2">Chip Express</span>
                        </a>
                    </li>
                @endcan
                @can('vista recarga')
                    <li>
                        <a href="#" onclick="loadPage('precargas.php'); return false;"
                            class="d-flex align-items-center p-2 text-white text-decoration-none">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                            <span class="ms-2">Recargas</span>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="#" class="d-flex align-items-center p-2 text-white text-decoration-none"
                        data-bs-toggle="collapse" data-bs-target="#submenu-garantia">
                        <i class="fa-solid fa-mobile"></i>
                        <span class="ms-2">Garantía</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>
                    <ul id="submenu-garantia" class="collapse list-unstyled ps-4">
                        @can('vista garantia')
                            <li>
                                <a href="{{ route('garantias.index') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none">
                                    <i class="fa-solid fa-award"></i>
                                    <span class="ms-2">Garantías</span>
                                </a>
                            </li>
                        @endcan
                        @can('vista seguimiento_garantia')
                            <li>
                                <a href="{{ route('garantia.status') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none {{ request()->routeIs('garantia.status') ? 'bg-primary' : '' }}">
                                    <i class="fa-solid fa-award"></i>
                                    <span class="ms-2">Seguimiento</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can('vista precio')
                    <li>
                        <a href="{{ route('listadeprecios.index') }}"
                            class="d-flex align-items-center p-2 text-white text-decoration-none">
                            <i class="fa-solid fa-money-check"></i>
                            <span class="ms-2">Lista de Precios</span>
                        </a>
                    </li>
                @endcan
                <li>
                    <a href="#" class="d-flex align-items-center p-2 text-white text-decoration-none"
                        data-bs-toggle="collapse" data-bs-target="#submenu-configuracion">
                        <i class="fa-solid fa-cog"></i>
                        <span class="ms-2">Configuración</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>
                    <ul id="submenu-configuracion" class="collapse list-unstyled ps-4">
                        @can('ver usuarios')
                            <li>
                                <a href="{{ route('usuarios.index') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none">
                                    <i class="fa-solid fa-users"></i>
                                    <span class="ms-2">Usuarios</span>
                                </a>
                            </li>
                        @endcan
                        @can('ver roles')
                            <li>
                                <a href="{{ route('roles.index') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none">
                                    <i class="fa-solid fa-user-shield"></i>
                                    <span class="ms-2">Roles</span>
                                </a>
                            </li>
                        @endcan
                        @can('vista sucursal')
                            <li>
                                <a href="{{ route('sucursales.index') }}"
                                    class="d-flex align-items-center p-2 text-white text-decoration-none">
                                    <i class="fa-solid fa-store"></i>
                                    <span class="ms-2">Sucursales</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                    @can('vista comisiones')
                    <li>
                        <a href="{{ route('comisiones.index') }}"
                            class="d-flex align-items-center p-2 text-white text-decoration-none">
                            <i class="fa-solid fa-dollar-sign"></i>
                            <span class="ms-2">Comisiones</span>
                        </a>
                    </li>
                @endcan

                </li>
            </ul>
        </nav>

        <main class="main-content"
            style="height: calc(100vh - 5.2rem); overflow-y: auto;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            @yield('content')
        </main>
    </div>

    <footer class="footer">
        <p>&copy; 2025 BuhoSoft. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
