<?php
    require("ES_C-Funzioni.php");

    session_start();
    CheckSessionInLogin();
    PasswordControl();
    $html = DisplayError();
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
                    <li><a href="ES_A-Riservata.php"><u>ES_A - Riservata</u></a></li>
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
            <?php echo $html; ?>
            <form action="ES_C-Riservata.php" method="POST"> 
                <label>Username:</label><br>
                <input type="text" name="usernameC" required><br>
                <label>Password:</label><br>
                <input type="text" name="passwordC" required><br>
                <input id="button" type="submit" value="Accedi">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>