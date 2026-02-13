<?php 
/**
 * @brief Controlla la sessione, in caso viene trovata da che l'accesso è stato effettuato con successo
 * invece se no da errore e visualizza un tasto per andare a Login.php
 */
    session_start();

    $html = "";

    if(!isset($_SESSION['usernameA'])){
        $html = <<<COD
        <p style="color:red">ERRORE NELLA RICEZIONE DELLA SESSIONE<br>
        PROVA AD EFFETTUARE IL LOGIN</p>
        <a href="ES_A-Login.php"><button id="button">LOGIN</button></a>
        COD;
    } else {
        $user = $_SESSION['usernameA'];
        $html = <<<COD
        <p>Hai effettuato l'accesso con successo <b>$user</b><br><br>
        Se vuoi effettuare il logout, <a href="ES_A-Logout.php"><button id="button">PREMI QUI</button></a></p>
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
                    <li><a href="index.php"><u>HomePage ES_04</u></a></li>
                    <hr>
                    <li><a href="ES_A-Welcome.php"><u>ES_A - Welcome</u></a></li>
                    <hr>     
                    <li><a href="ES_A-Riservata.php"><b>ES_A - Riservata</b></a></li>
                    <hr>
                    <li><a href="ES_B-Welcome.php"><u>ES_B - Welcome</u></a></li>
                    <hr> 
                    <li><a href="ES_B-Riservata.php"><u>ES_B - Riservata</u></a></li>
                    <hr>
                    <li><a href="ES_C-Welcome.php"><u>ES_C - Welcome</u></a></li>
                    <hr> 
                    <li><a href="ES_C-Riservata.php"><u>ES_C - Riservata</u></a></li>
                    <hr> 
                </ul>
            </nav>
        </div>
        <div class="content">
            <?php echo $html?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>