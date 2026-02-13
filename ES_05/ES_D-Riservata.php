<?php
require("ES_D-Funzioni.php");
session_start();
$html = "";

if(CheckSessionRis()){
    $user = $_SESSION['username'];
    $access = getUltimoAccesso();
    if(isset($_COOKIE['user'])){
        $html = <<<COD
        <p>LOGIN EFFETTUATO CON SUCCESSO con <b>$user</b><br><br>
        Ultimo Accesso: $access<br><br>
        Se vuoi effettuare il logout, <button id="button" data-b="button">PREMI QUI</button></p>
        COD;
    } else {
        $html = <<<COD
        <p>LOGIN EFFETTUATO CON SUCCESSO con <b>$user</b><br><br>
        Ultimo Accesso: $access<br><br>
        Se vuoi effettuare il logout, <a href="ES_D-Logout.php"><button id="button" data-b="none">PREMI QUI</button></a></p>
        COD;
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
    <script src="js/script.js" defer></script>
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
                    <li><a href="ES_D-Welcome.php"><u>ES_D - Welcome</u></a></li>
                    <hr>
                    <li><a href="ES_D-Riservata.php"><b>ES_D - Riservata</b></a></li>
                    <hr>                                       
                </ul>
            </nav>
        </div>
        <div class="content">
            <?= $html ?>
            <div id="box">
                <form action="ES_D-Logout.php" method="post">
                    <p>Vuoi rimuovere anche i cookies?</p>
                    <input type="checkbox" name="cookies"><br><br>
                    <input id="button2" type="submit" value="Conferma" style="display: inline;">
                    <button type="button" id="button3">Annulla</button>
                </form>   
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>

