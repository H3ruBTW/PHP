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
                    <li><a href="index.php"><u>HomePage ES_02</u></a></li>
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
            <form action="ES_A_login.php" method="POST"> 
                <br><label>Username:</label><br>
                <input type="text" name="username" required><br>
                <label>Password:</label><br>
                <input type="text" name="password" required><br>
                <input id="button" type="submit" value="Accedi">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>