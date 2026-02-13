<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="css/style.css">
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
                    <li><a href="index.php"><u>HomePage ES_01</u></a></li>
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
            <div id="box">
                <h3>1)</h3>
                <p>
                    <?php 
                        for($i=1; $i<=10; $i++){
                            for($j=0; $j<$i; $j++){
                                echo "*";
                            }

                            echo "<br>";
                        }
                    ?>
                </p>
            </div>
            <div id="box">
                <h3>2)</h3>
                <p>
                    <?php 
                        for($i=0; $i<10; $i++){
                            for($j=0; $j<10-$i; $j++){
                                echo "*";
                            }

                            echo "<br>";
                        }
                    ?>
                </p>
            </div>
            <div id="box">
                <h3>3)</h3>
                <p>
                    <?php 
                        for($i=1; $i<=10; $i++){
                            for($j=0; $j<10-$i; $j++){
                                echo "&nbsp;";
                            }
                            for($j=0; $j<$i; $j++){
                                echo "*";
                            }

                            echo "<br>";
                        }
                    ?>
                </p>
            </div>
            <div id="box">
                <h3>4)</h3>
                <p>
                    <?php 
                        for($i=0; $i<=10; $i++){
                            for($j=0; $j<$i; $j++){
                                echo "&nbsp;";
                            }
                            for($j=0; $j<10-$i; $j++){
                                echo "*";
                            }

                            echo "<br>";
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>