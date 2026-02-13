<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleB.css">
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
                    <li><a href="index.php"><u>HomePage ES_01</u></a></li>
                    <hr>
                    <li><a href="ES_A.php">ES_A</a></li>
                    <hr>
                    <li><a href="ES_B.php"><b>ES_B</b></a></li>
                    <hr>
                    <li><a href="ES_C.php">ES_C</a></li>
                    <hr>
                </ul>
            </nav>
        </div>
        <div class="content">
            <?php 
                $orario = new DateTime("now", new DateTimeZone('Europe/Rome'));
                $ora = $orario->format('H');
                if($ora>=8 && $ora<12){
                    echo "<h3>Buongiorno";
                } else if($ora>=12 && $ora<=20) {
                    echo "<h3>Buonasera";
                } else if(($ora>=20 && $ora<=23) || ($ora>=0 && $ora<=7)){
                    echo "<h3>Buonanotte";
                }
                $nome = "Paolo";
                echo " $nome, questa è la mia prima pagina PHP!</h3><br>";

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                echo "<h3>Stai usando il browser: <b>$user_agent</b></h3>"
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>