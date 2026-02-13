<?php
require("ES_D-Funzioni.php");
session_start();

$error = DisplayError();
$cookies = "";
$remeberUser = "";

CheckSession();

//controlla la presenza di cookie
if(isset($_COOKIE['user'])){
    $cookies = $_COOKIE['user'];
} else {
    $remeberUser="<label>Vuoi salvare il username?</label>\n<input type=\"checkbox\" name=\"cookies\"><br><br>";
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $user = (isset($_POST["username"])) ? $_POST['username'] : "";
    $pass = (isset($_POST['password'])) ? $_POST['password'] : "";
    $cookies = (isset($_POST['cookies'])) ? $_POST['cookies'] : false; 

    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6Lftjt0qAAAAAP4d_OhBwClGleD53NDXOqlRIXP7"; 

    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        Login($user, $pass, $cookies);
    } else {
        header("Location: ES_D-Login.php?error=Il captcha non è stato risolto correttamente");
        exit;
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                    <li><a href="ES_D-Riservata.php"><u>ES_D - Riservata</u></a></li>
                    <hr>       
                </ul>
            </nav>
        </div>
        <div class="content">
            <?= $error ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 
                <label>Username:</label><br>
                <input type="text" name="username" required value="<?= $cookies ?>"><br>
                <label>Password:</label><br>
                <input type="text" name="password" required><br><br>
                <?= $remeberUser ?>
                <!-- Google reCAPTCHA -->
                <div class="g-recaptcha" data-sitekey="6Lftjt0qAAAAAB41wvUFgRvl5MiGUuuywu-zRZaV"></div>
                <br>
                <input id="button" type="submit" value="Accedi"><br><br><br>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>
