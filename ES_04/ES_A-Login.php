<?php
/**
 * @brief Si ricerca il POST è poi si controlla se la passeord è giusta
 * in caso salva nella sessione l'username e reindirizza alla riservata
 * nell'altro rimanda alla login con l'errore
 */
    session_start();
    $html = "";

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $user = $_POST['usernameA'];
        $psw = $_POST['passwordA'];
        if($user == "Aless" && $psw == "123"){
            $_SESSION['usernameA']=$user;
            header("Location: ES_A-Riservata.php");
            exit;
        } else {
            $url = 'ES_A-Login.php?error=Per accedere alla pagina bisogna fare prima l\'accesso';
            header("Location: $url");
            exit; 
        }
        
    } else {
        if(isset($_GET['error'])){
            $error = "<p style=\"color:red\">" . $_GET['error'] . "</p>";
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
            <br>
            <?php echo $error ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 
                <label>Username:</label><br>
                <input type="text" name="usernameA" required><br>
                <label>Password:</label><br>
                <input type="text" name="passwordA" required><br>
                <input id="button" type="submit" value="Accedi">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>