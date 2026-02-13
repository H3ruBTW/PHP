<?php
require("Funzioni.php");

$error = DisplayError();

if($_SERVER['REQUEST_METHOD']=="POST"){
    Registration();   
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
    <link rel="stylesheet" href="css/gestione.css">
    <script src="js/form.js" defer></script>
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
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form">
            <h4>Dati Personali</h4>
                <div class="dati">
                    <label>Nome:</label>
                    <input type="text" name="name" placeholder="Mario" required>
                    <br><br>
                    <label>Data di nascita:</label>
                    <!-- IL MASSIMO CHE VIENE ACCETTATO E' LA DATA DI OGGI -->
                    <input type="date" name="date" max="<?= date('Y-m-d') ?>" required>                    
                </div>
                <div class="dati2">
                    <label>Cognome:</label><br>
                    <input type="text" name="surname" placeholder="Rossi" required>
                    <br><br>
                    <label>E-mail:</label><br>
                    <input type="text" name="mail" placeholder="mario.rossi@mail.*" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required>
                </div>

                <h4>Account</h4>
                <div class="dati">
                    <label>Username:</label>
                    <input type="text" name="username" pattern="[a-zA-Z0-9]{4, 50}" required>
                </div>
                <div class="dati2">
                    <label>Password:</label><br>
                    <input type="text" name="password" placeholder="min 8 car./1 spec./1 maiu." pattern="(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%&\-_+=?]).{8, 72}" required>
                </div>
                <br>
                <input class="button" type="submit" value="Crea Account">
                <a href="Login.php"><button type="button" class="button">Indietro</button></a>
            </form>
            <br>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>
