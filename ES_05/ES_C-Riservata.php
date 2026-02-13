<?php
require("ES_C-Funzioni.php");
session_start();
$html = "";

if(CheckSessionRis()){
    $user = $_SESSION['username'];
    $html = <<<COD
    <p>LOGIN EFFETTUATO CON SUCCESSO con <b>$user</b><br><br>
    Se vuoi effettuare il logout, <a href="ES_C-Logout.php"><button id="button">PREMI QUI</button></a></p>
    COD;
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
                    <li><a href="ES_C-Riservata.php"><b>ES_C - Riservata</b></a></li>
                    <hr>     
                    <li><a href="ES_D-Welcome.php"><u>ES_D - Welcome</u></a></li>
                    <hr>
                    <li><a href="ES_D-Riservata.php"><u>ES_D - Riservata</u></a></li>
                    <hr>                                   
                </ul>
            </nav>
        </div>
        <div class="content">
            <?= $html ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>

