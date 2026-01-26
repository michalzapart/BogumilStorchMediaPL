<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli(
    'localhost',
    'emieemus_bogutek',
    '?$fFTb@kQYPaJ!P3',
    'emieemus_bogutek'
);

if ($conn->connect_error) {
    die('Błąd połączenia: ' . $conn->connect_error);
}

// zapis wpisu
if (!empty($_POST['name']) && !empty($_POST['message'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    $stmt = $conn->prepare("INSERT INTO guestbook (name, message) VALUES (?, ?)");

    if ($stmt === false) {
        die('Błąd SQL (INSERT): ' . $conn->error);
    }

    $stmt->bind_param("ss", $name, $message);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Donejty Bogutka</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: black">

<div class="container d-flex align-items-center justify-content-center" style="background-color: black; min-height: 100vh; flex-direction: column">

    <div class="d-flex gap-4 align-items-center" style="flex-grow: 1">
        <img src="bogu.png" width="240">
        <div class="content-quote gap-4">
            <p id="tresc"></p>
            <p>- Bogumił S., wiadomości głosowe</p>
        </div>
    </div>

    <div id="footer">
        Strona jest niepowiązana z Bogumiłem Storchem, zbieżność nazw przypadkowa
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col">

            <h2 class="mb-4" style="color: white">Wiadomości głosowe wysłane przez Bogumiła S.</h2>
<table id="donejtyTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Lp</th>
                    <th>Treść</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dane zostaną wstawione przez JavaScript -->
            </tbody>
        </table>
        <nav aria-label="Pagination">
            <ul id="pagination" class="pagination justify-content-center">
                <!-- Przyciski paginacji zostaną wstawione przez JavaScript -->
            </ul>
        </nav>


        </div>
    </div>
</div>




<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    HTML<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela Donejtów</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tabela z Donejtami</h2>
        <table id="donejtyTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Lp</th>
                    <th>Treść</th>
                </tr>
            </thead>
            <tbody style="color: white">
                <!-- Dane zostaną wstawione przez JavaScript -->
            </tbody>
        </table>
        <nav aria-label="Pagination">
            <ul id="pagination" class="pagination justify-content-center">
                <!-- Przyciski paginacji zostaną wstawione przez JavaScript -->
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script>
        let data = []; // Globalna zmienna na dane
        const itemsPerPage = 10;
        let currentPage = 1;

        // Funkcja do wczytania danych z donejty.json
        async function loadDonejty() {
            try {
                const response = await fetch('donejty.json');
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
    </script>

<script src="script.js"></script>
</body>
</html>
