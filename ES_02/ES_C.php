<?php 
    $html = <<<COD
        <form action="ES_C.php" method="POST"> 
            <br><label>Mostra i numeri fino a (max: 10):</label><br>
            <input type="number" name="num" min="1" max="10" value="1" required>
            <br>
            <input id="button" type="submit" value="Crea Tabella">
        </form><br>
    COD;

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $num = $_POST['num'];

        $html = "<h4>Ecco la tabella dei quadrati e dei cubi fino a $num:</h4><br>";
        $html = $html . "<table><tr><th>Numero</th><th>Quadrato</th><th>Cubo</th></tr>" ;

        for($i=1; $i<=$num; $i++){
            $quad = pow($i, 2);
            $cub = pow($i, 3);

            $html = $html . "<tr><th>$i</th><th>$quad</th><th>$cub</th></tr>";
        }

        $html = $html . "</table><br>";
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
    <link rel="stylesheet" href="css/styleC.css">
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
                    <li><a href="index.php"><u>HomePage ES_02</u></a></li>
                    <hr>
                    <li><a href="ES_A.php">ES_A</a></li>
                    <hr>
                    <li><a href="ES_B.php">ES_B</a></li>
                    <hr>
                    <li><a href="ES_C.php"><b>ES_C</b></a></li>
                    <hr>
                </ul>
            </nav>
        </div>
        <div class="content">
            <?=$html?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>