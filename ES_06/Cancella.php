<?php
require("Funzioni.php");
session_start();
$html = "";

if(CheckSessionRis()){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        Cancel();
    }
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
                    <li><a href="index.php"><u>HomePage ES_06</u></a></li>
                    <hr>
                    <li><a href="Welcome.php"><u>Welcome</u></a></li>
                    <hr>
                    <li><a href="Riservata.php"><u>Riservata</u></a></li>
                    <hr>                
                </ul>
            </nav>
        </div>
        <div class="content">
            <p><b>SEI SICURO DI VOLER CANCELLARE L'ACCOUNT?</b></p>
            <form action=" <?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input class="rbutton" type="submit" value="CANCELLA DEFINITIVAMENTE">
                <a href="Riservata.php"><button type="button" class="button">ANNULLA</button></a>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>

