<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/style.css">
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
                    <li><a href="ES_B.php"><b>ES_B</b></a></li>
                    <hr>
                    <li><a href="ES_C.php">ES_C</a></li>
                    <hr>
                </ul>
            </nav>
        </div>
        <div class="content">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"> 
                <br><label>Username:</label><br>
                <input type="text" name="username" required><br>
                <label>Password:</label><br>
                <input type="text" name="password" required><br>
                <input id="button" type="submit" value="Accedi">
            </form>

            <?php 
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    $user = $_POST['username'];
                    $psw = $_POST['password'];

                    if($user == "admin" && $psw == "pass123"){
                        echo "<br><h4>Accesso venuto con successo con account: $user</h4>";
                    } else {
                        echo "<br><h4>Accesso fallito, credeziali errate</h4>";
                    }
                }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>