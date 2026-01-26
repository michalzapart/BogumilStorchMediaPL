<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<!DOCTYPE html>
<html lang="pl">

    <?php
        include ("include/head.html");
    ?>

    <body style="background-color: black">

        <?php

            include ("include/hero.html");
            include ("include/donejty_tabela.html");

        ?>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="js/hero.js"></script>
        <script src="js/donejty_tabela.js"></script>
    </body>
</html>
