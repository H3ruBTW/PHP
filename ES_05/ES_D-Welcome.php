<?php
session_start();

if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $html = "<h2>Effettua il login nella pagina, $user.</h2>";
} else {
    $html = "<h2>Devi effettuare il login, sei in modalità ospite.</h2>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/base.css">
    <script src="js/scriptcookie.js" defer></script>
    <title>Esecizi</title>
</head>
<body>
    <header><h1>ESERCIZI PHP</h1></header>
    <div class="divs">
        <div class="menu">
            <nav>
                <ul>
                    <hr>
                    <li><a href="../index.php"><b>HomePage PHP</b></a></li>
                    <hr>
                    <li><a href="index.php"><u>HomePage ES_05</u></a></li>
                    <hr>
                    <li><a href="ES_A_B-DB.php"><u>ES_AB - Accesso DB</u></a></li>
                    <hr>  
                    <li><a href="ES_C-Welcome.php"><u>ES_C - Welcome</u></a></li>
                    <hr>
                    <li><a href="ES_C-Riservata.php"><u>ES_C - Riservata</u></a></li>
                    <hr>    
                    <li><a href="ES_D-Welcome.php"><b>ES_D - Welcome</b></a></li>
                    <hr>
                    <li><a href="ES_D-Riservata.php"><u>ES_D - Riservata</u></a></li>
                    <hr>                                   
                </ul>
            </nav>
        </div>
        <div class="content">
            <?= $html ?>
            <a href="ES_D-Login.php"><button id="button">LOGIN</button></a>

            <div id="cookie">
                Questo sito utilizza solo cookie tecnici per la gestione della sessione utente. Nessun tracciamento viene effettuato.
                <button id="button2">OK</button>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>
