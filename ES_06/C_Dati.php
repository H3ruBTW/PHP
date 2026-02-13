<?php
require("Funzioni.php");
session_start();

if(CheckSessionRis()){
    $acc = fetch_all();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        ChangePData($_POST['name'], $_POST['surname'], $_POST['date']);
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
            <br>
            <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
                <div class="dati">
                    <label>Nome:</label>
                    <input type="text" name="name" placeholder="Mario" value="<?= $acc['Nome'] ?>" required>
                    <br><br>
                    <label>Data di nascita:</label>
                    <!-- IL MASSIMO CHE VIENE ACCETTATO E' LA DATA DI OGGI -->
                    <input type="date" name="date" max="<?= date('Y-m-d') ?>" value="<?= $acc['Data_Nascita'] ?>" required> 
                </div>
                <div class="dati2">
                    <label>Cognome:</label><br>
                    <input type="text" name="surname" placeholder="Rossi" value="<?= $acc['Cognome'] ?>" required>
                    <br><br><br><br>
                </div> 
                <br>
                <input class="button" type="submit" value="Modifica">
                <a href="Riservata.php"><button type="button" class="button">Indietro</button></a>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>
