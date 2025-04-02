document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-search-url]').forEach(searchInput => {
        let currentFocus = -1;
        const resultsList = document.createElement('ul');
        searchInput.parentNode.insertBefore(resultsList, searchInput.nextSibling);

        // Función debounce para retrasar la ejecución de la búsqueda
        function debounce(func, wait) {
            let timeout;
            return function (...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        // Función que realiza la búsqueda
        function performSearch() {
            const searchUrl = searchInput.dataset.searchUrl;
            const searchTerm = searchInput.value;
            const hiddenInput = document.getElementById(searchInput.dataset.hiddenInputId);

            if (searchTerm) {
                fetch(`${searchUrl}?term=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Aseguramos que el contenedor se muestre al obtener resultados
                        resultsList.style.display = 'block';
                        resultsList.innerHTML = '';
                        currentFocus = -1;
                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.classList.add('list-group-item');
                            li.dataset.id = item.id;
                            li.textContent = item.nombre;
                            resultsList.appendChild(li);
                        });
                    });
            } else {
                resultsList.innerHTML = '';
                resultsList.style.display = 'none';
            }
        }

        // Envolvemos la función performSearch con debounce (espera de 300ms)
        const debouncedSearch = debounce(performSearch, 300);

        // Usamos la versión debounced en el evento input
        searchInput.addEventListener('input', debouncedSearch);

        searchInput.addEventListener('keydown', function (e) {
            const items = resultsList.querySelectorAll('li');
            if (e.keyCode === 40) { // Flecha abajo
                currentFocus++;
                addActive(items);
            } else if (e.keyCode === 38) { // Flecha arriba
                currentFocus--;
                addActive(items);
            } else if (e.keyCode === 13) { // Enter
                e.preventDefault();
                if (currentFocus > -1 && items.length) {
                    searchInput.value = items[currentFocus].textContent;
                    const hiddenInput = document.getElementById(searchInput.dataset.hiddenInputId);
                    hiddenInput.value = items[currentFocus].dataset.id;
                    resultsList.innerHTML = ''; // Vacía la lista
                    resultsList.style.display = 'none'; // Oculta el contenedor
                }
            }
        });

        resultsList.addEventListener('click', function (e) {
            if (e.target.tagName === 'LI') {
                searchInput.value = e.target.textContent;
                const hiddenInput = document.getElementById(searchInput.dataset.hiddenInputId);
                hiddenInput.value = e.target.dataset.id;
                resultsList.innerHTML = '';
                resultsList.style.display = 'none'; // Oculta al hacer click
            }
        });

        resultsList.addEventListener('mouseover', function (e) {
            if (e.target.tagName === 'LI') {
                e.target.classList.add('active');
            }
        });

        resultsList.addEventListener('mouseout', function (e) {
            if (e.target.tagName === 'LI') {
                e.target.classList.remove('active');
            }
        });

        function addActive(items) {
            if (!items) return false;
            removeActive(items);
            if (currentFocus >= items.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = items.length - 1;
            items[currentFocus].classList.add('active');
        }

        function removeActive(items) {
            items.forEach(item => item.classList.remove('active'));
        }



        resultsList.classList.add('list-group', 'mt-3', 'position-absolute', 'w-50');
        resultsList.style.zIndex = '1050';  // Asegura que esté sobre los demás elementos
        resultsList.style.backgroundColor = 'white'; // Evita transparencia accidental
        resultsList.style.boxShadow = '0px 4px 6px rgba(0,0,0,0.1)'; // Sombras para resaltar

    });
});

