    let data = []; // Globalna zmienna na dane
    const itemsPerPage = 10;
    let currentPage = 1;

    // Funkcja do wczytania danych z donejty.json
    async function loadDonejty() {
        try {
            const response = await fetch('../data/donejty.json');
            if (!response.ok) {
                throw new Error('Nie udało się wczytać pliku JSON');
            }
            data = await response.json();

            // Sortuj dane po oryginalnym Lp numerycznie, aby zachować kolejność
            data.sort((a, b) => parseInt(a.Lp) - parseInt(b.Lp));

            displayPage(1);
            setupPagination();
        } catch (error) {
            console.error('Błąd:', error);
            const tbody = document.querySelector('#donejtyTable tbody');
            tbody.innerHTML = '<tr><td colspan="2">Błąd wczytywania danych: ' + error.message + '</td></tr>';
        }
    }

    // Funkcja do wyświetlania danej strony
    function displayPage(page) {
        currentPage = page;
        const tbody = document.querySelector('#donejtyTable tbody');
        tbody.innerHTML = ''; // Wyczyść tabelę

        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = data.slice(start, end);

        pageData.forEach((item, index) => {
            if (item.Treść) { // Sprawdź, czy pole Treść istnieje (ignorujemy Lp z JSON)
                const row = document.createElement('tr');
                const lpCell = document.createElement('td');
                // Generuj ciągłą numerację na podstawie pozycji w całej liście
                lpCell.textContent = start + index + 1;
                const trescCell = document.createElement('td');
                trescCell.textContent = item.Treść;
                row.appendChild(lpCell);
                row.appendChild(trescCell);
                tbody.appendChild(row);
            }
        });

        // Aktualizuj aktywną stronę w paginacji
        updatePagination();
    }

    // Funkcja do ustawienia paginacji
    function setupPagination() {
        const pagination = document.querySelector('#pagination');
        pagination.innerHTML = ''; // Wyczyść paginację

        const pageCount = Math.ceil(data.length / itemsPerPage);

        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement('li');
            li.className = 'page-item';
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = i;
            a.addEventListener('click', (e) => {
                e.preventDefault();
                displayPage(i);
            });
            li.appendChild(a);
            pagination.appendChild(li);
        }
    }

    // Funkcja do aktualizacji aktywnej strony
    function updatePagination() {
        const pages = document.querySelectorAll('#pagination .page-item');
        pages.forEach((page, index) => {
            if (index + 1 === currentPage) {
                page.classList.add('active');
            } else {
                page.classList.remove('active');
            }
        });
    }

    // Wywołaj funkcję po załadowaniu strony
    document.addEventListener('DOMContentLoaded', loadDonejty);