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
</head>
<body>

<div class="container">
    <div id="info">
        Treść donejtów głosowych przesłanych Krzysztofowi Kononowiczowi oraz Wojciechowi Suchodolskiemu przez jedną i tą samą osobę (ponad 300 wiadomości)
    </div>

    <div class="content">
        <img src="bogu.png" width="240">
        <p id="tresc"></p>
    </div>

    <div id="footer">
        Strona jest niepowiązana z Bogumiłem Storchem, zbieżność nazw przypadkowa
    </div>
</div>

<div class="container ksiega-gosc">
    <h1>Do Bogutka</h1>
    <p>Księga gości niecenzurowana</p>

    <form method="post">
        <div class="formularz">
            <input class="text-input" type="text" name="name" placeholder="Twoje imię" required>
            <textarea class="textarea-input" name="message" placeholder="Wpisz wiadomość" required></textarea>
            <button class="button" type="submit">Dodaj wpis</button>
        </div>
    </form>

    <?php
    $result = $conn->query("SELECT * FROM guestbook ORDER BY created_at DESC");

    if ($result === false) {
        die('Błąd SQL (SELECT): ' . $conn->error);
    }

    while ($row = $result->fetch_assoc()):
    ?>
        <div class="entry">
            <strong><?= htmlspecialchars($row['name']) ?></strong>
            <em>(<?= $row['created_at'] ?>)</em>
            <?= nl2br(htmlspecialchars($row['message'])) ?>
        </div>
    <?php endwhile; ?>
</div>

<script src="script.js"></script>
</body>
</html>
