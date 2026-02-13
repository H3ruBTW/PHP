<?php 
define("HOST", "localhost");
define("USER", "USERS");
define("PASS", "123");
define("DB", "es05");

$conn = mysqli_connect(HOST, USER, PASS, DB);
$query = "select * from utente where Username = \"aless\"";
$ris = mysqli_query($conn, $query);
$acc = mysqli_fetch_assoc($ris);
$ultimo_errore = strtotime($acc['Ultimo_Errore']);

$html = $acc['Errori'] . " " . $acc['Ultimo_Errore'] . " " . $ultimo_errore . " " . time() . " " . time()-$ultimo_errore;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">
    <title>Esercizi</title>
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
                    <li><a href="index.php"><u>HomePage prova</u></a></li>
                    <hr>
                    <li><a href="APCu.php"><u>Prova APCu</u></a></li>
                    <hr>
                    <li><a href="PHPMailer.php"><u>PHPMailer</u></a></li>
                    <hr>
                    <li><a href="fetch.php"><u>Fetch</u></a></li>
                    <hr>
                </ul>
            </nav>
        </div>
        <div class="content">
            <?php echo $html; ?>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>