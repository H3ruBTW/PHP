<?php
require("Funzioni.php");
session_start();

$error = DisplayError();

if(!isset($error)){
    $error = "<br>";
}

if(!isset($_SESSION['mail'])){
    header("Location: Login.php?error=Entrata in pagina riservata non autorizzata");
    exit;
}

$token = (isset($_POST['token'])) ? $_POST['token'] : "";

if(isset($_POST['psw'])){
    $pass = $_POST['psw'];

    setPassword($pass);
}

verify_token($token);

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
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="dati">
                <label>Nuova Password:</label><br>
                <input type="text" name="psw" placeholder="min 8 car./1 spec./1 maiu." pattern="(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%&\-_+=?]).{8, 72}" required>
                </div>
                <div class="dati2">
                    <br>
                    <br>
                </div> 
                <br><br>
                <input class="button" type="submit" value="Conferma">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>