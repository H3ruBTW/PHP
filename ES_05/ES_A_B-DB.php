<?php
$html="";

define("HOST", "localhost");
define("USER", "USERS");
define("PSW", "123");
define("DB", "es05");

try {
    $conn = mysqli_connect(HOST, USER, PSW, DB);

    if($conn){
        $html = "<p>Connessione al DB con successo con " . USER . "</p>";
    } else {
        $html = "<p>Connessione fallita.</p>";
    }
} catch (\Throwable $th) {
    $err = mysqli_connect_error();

    $html = <<<COD
    <p>Si è verificato un errore nella connessione al DB.<br>
    Riprovare più tardi.<br>
    Errore: $err</p>
    COD;
}

mysqli_close($conn);
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
                    <li><a href="index.php"><u>HomePage ES_05</u></a></li>
                    <hr>
                    <li><a href="ES_A_B-DB.php"><b>ES_AB - Accesso DB</b></a></li>
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
            <?= $html ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>