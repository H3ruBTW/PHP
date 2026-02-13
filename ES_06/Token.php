<?php
require("Funzioni.php");
session_start();

$error = DisplayError();

if(!isset($_SESSION['mail'])){
    header("Location: Login.php?error=Entrata in pagina riservata non autorizzata");
    exit;
}

SendTokenMail();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/gestione.css">
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
            <?= $error ?>
            <p>Ti è stato mandato un codice a 6 cifre alla seguente mail: <?= $_SESSION['mail']?><br>
            Il codice scadrà in <span style="color: red">5 minuti</span> dalla richiesta iniziale</p><br>
            <form action="Token_Password.php" method="post">
                <div class="dati">
                    <label>Token d'autenticazione</label><br>
                    <input type="text" name="token" pattern="[0-9]{6,6}" required>
                </div>
                <div class="dati2">
                    <br>
                    <br>
                </div> 
                <br><br>
                <input class="button" type="submit" value="Conferma">
                <a href="Token.php"><button type="button" class="button">Invia Codice Nuovamente</button></a>
            </form>
            <br>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>