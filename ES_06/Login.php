<?php
require("Funzioni.php");
session_start();


$succ = DisplaySuccess();
$error = DisplayError();

if(!isset($succ) && !isset($error)){
    $succ = "<br>";
}
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
        header("Location: Login.php?error=Il captcha non è stato risolto correttamente");
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
            <?= $succ ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 
                <label>Username:</label><br>
                <input type="text" name="username" required value="<?= $cookies ?>"><br>
                <label>Password:</label><br>
                <input type="text" name="password" required>
                <p><a class="link" href="Forgot_password.php">Password Dimenticata?</a></p>
                <?= $remeberUser ?>
                <!-- Google reCAPTCHA -->
                <div class="g-recaptcha" data-sitekey="6Lftjt0qAAAAAB41wvUFgRvl5MiGUuuywu-zRZaV"></div>
                <br>
                <input class="button" type="submit" value="Accedi">
            </form>
            <p><a class="link" href="Registrazione.php">Non hai un account? Crealo!</a></p><br>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>
