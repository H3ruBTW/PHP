<?php 
    $html = "";
    session_start();
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $user = $_POST['usernameB'];
        $psw = $_POST['passwordB'];
        if($user == "Aless" && $psw == "123"){
            $_SESSION['usernameB']=$user;
            $html = <<<COD
            <p>Hai effettuato l'accesso con successo <b>$user</b> con metodo POST<br><br>
            Se vuoi effettuare il logout, <a href="ES_B-Logout.php"><button id="button">PREMI QUI</button></a></p>
            COD;
        } else {
            $url = 'ES_B-Login.php?error=Credenziali errate&from=';
            $url .= basename($_SERVER['PHP_SELF']);
            header("Location: $url");
            exit;
        }
        
    } else {
        if(!isset($_SESSION['usernameB'])){
            $url = 'ES_B-Login.php?error=Per accedere alla pagina bisogna fare prima l\'accesso&from=';
            $url .= basename($_SERVER['PHP_SELF']);
            header("Location: $url");
            exit;            
        } else {
            $user = $_SESSION['usernameB'];
            $html = <<<COD
            <p>Hai effettuato l'accesso con successo <b>$user</b> usando la sessione<br><br>
            Se vuoi effettuare il logout, <a href="ES_B-Logout.php"><button id="button">PREMI QUI</button></a></p>
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
                    <li><a href="ES_B-Riservata.php"><b>ES_B - Riservata</b></a></li>
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