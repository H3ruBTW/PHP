<?php
require("Funzioni.php");
session_start();
$html = "";
$error = DisplayError();
$succ = DisplaySuccess();

if(CheckSessionRis()){
    $user = $_SESSION['username'];
    $access = getUltimoAccesso();
    if(isset($_COOKIE['user'])){
        $html = <<<COD
        <p>LOGIN EFFETTUATO CON SUCCESSO con <b>$user</b><br><br>
        Ultimo Accesso: $access<br><br>
        Se vuoi effettuare il logout, <button id="button" class="button">PREMI QUI</button></p>
        COD;
    } else {
        $html = <<<COD
        <p>LOGIN EFFETTUATO CON SUCCESSO con <b>$user</b><br><br>
        Ultimo Accesso: $access<br><br>
        Se vuoi effettuare il logout, <a href="Logout.php"><button class="button">PREMI QUI</button></a></p>
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
                    <li><a href="index.php"><u>HomePage ES_06</u></a></li>
                    <hr>
                    <li><a href="Welcome.php"><u>Welcome</u></a></li>
                    <hr>
                    <li><a href="Riservata.php"><b>Riservata</b></a></li>
                    <hr>                
                </ul>
            </nav>
        </div>
        <div class="content">
            <h2>PAGINA ACCOUNT</h2>
            <?= $succ ?>
            <?= $error ?>
            <?= $html ?>
            <div id="box">
                <form action="Logout.php" method="post" style="justify-content: center; text-align:center">
                    <p>Vuoi rimuovere anche i cookies?</p>
                    <input type="checkbox" name="cookies"><br><br>
                    <input class="button" type="submit" value="Logout" style="display: inline; width: 147px">
                    <button id="cancel" type="button" class="button" style="width: 148px">Annulla</button>
                </form>   
            </div>
            <h2>GESTIONE ACCOUNT</h2>
            <div id="manage_box">
                <a href="C_User.php"><button class="button">Cambia Username</button></a>
                <a href="C_Psw.php"><button class="button">Cambia Password</button></a>
                <br>
                <a href="C_Mail.php"><button class="button">Cambia E-mail</button></a>
                <a href="C_Dati.php"><button class="button">Cambia Dati Personali</button></a>
            </div>
            <br><br>
            <a href="Cancella.php"><button class="rbutton">Cancellazione Account</button></a><br>
            <br><br><br><br>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>

