<div class="sidebar bg-dark text-white p-2" style="width: 14rem; height: calc(100vh - 5rem);">
    <ul class="list-unstyled">
        <li>
            <a href="{{ route('equipos') }}" class="d-flex align-items-center p-2 text-white text-decoration-none bg-dark hover-effect">
                <i class="fa-solid fa-mobile"></i>
                <span class="ms-2">Equipos</span>
            </a>
        </li>
        <li>
        <a href="{{ route('chip') }}" class="d-flex align-items-center p-2 text-white text-decoration-none bg-dark hover-effect">
        <i class="fa-solid fa-sim-card"></i>
                <span class="ms-2">Chip Express</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="loadPage('precargas.php'); return false;" class="d-flex align-items-center p-2 text-white text-decoration-none bg-dark hover-effect">
                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                <span class="ms-2">Recargas</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="loadPage('pgarantia.php'); return false;" class="d-flex align-items-center p-2 text-white text-decoration-none bg-dark hover-effect">
                <i class="fa-solid fa-award"></i>
                <span class="ms-2">Garantías</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="loadPage('pprecios.php'); return false;" class="d-flex align-items-center p-2 text-white text-decoration-none bg-dark hover-effect">
                <i class="fa-solid fa-money-check"></i>
                <span class="ms-2">Lista de Precios</span>
            </a>
        </li>
    </ul>
</div>
