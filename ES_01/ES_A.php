<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleA.css">
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
                    <li><a href="ES_A.php"><b>ES_A</b></a></li>
                    <hr>
                    <li><a href="ES_B.php">ES_B</a></li>
                    <hr>
                    <li><a href="ES_C.php">ES_C</a></li>
                    <hr>
                </ul>
            </nav>
        </div>
        <div class="content">
            <?php 
                echo "<table>";
                for($i=1;$i<=10;$i++){
                    echo "<tr>";
                    for($j=1;$j<=10;$j++){
                        $ris = $i*$j;
                        echo "<th>$ris</th>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>