<?php 
$html = <<<COD
<form action="" method="post" id="form">
    <h4>Dati Personali</h4>
    <div class="box">
        <label for="name">Nome:</label>
        <input type="text" name="name" placeholder="Mario" required>
        <br><br>
        <label for="dob">Data di nascita:</label>
        <input type="date" name="date" required>
        <br><br>
        <label for="mail">E-mail:</label>
        <input type="text" name="mail" placeholder="mario.rossi@mail.*" pattern="[a-zA-Z0-9\.\-_]{1,}[@][a-zA-Z0-9]{1,}[\.][a-zA-Z]{2,}" required title=" \nSi prega di inserire una mail valida">
    </div>
    <div class="box2">
        <label for="surname" >Cognome:</label><br>
        <input type="text" name="surname" placeholder="Rossi" required>
        <br><br>
        <label for="fiscale">Codice fiscale:</label><br>
        <input type="text" name="codicefis" placeholder="MRIRSS..." pattern="[a-zA-Z]{6}[\d]{2}[a-zA-Z][\d]{2}[a-zA-Z][\d]{3}[a-zA-Z]" title=" \nFormato del codice fiscale errato">
        <br><br>
        <label for="cellnumber" >Numero di cellulare:</label><br>
        <input type="tel" name="tel" placeholder="39 333 333 3333" pattern="[0-9]{11,12}" required title=" \nNumero di telefono non valido\nInserire anche il prefisso">
    </div>

    <h4>Indirizzo</h4>
    <div class="box">
        <label for="tipo">Tipo di strada:</label><br>
        <select name="tipo">
            <option value="Via">Via</option>
            <option value="Viale">Viale</option>
            <option value="Vicolo">Vicolo</option>
            <option value="Corso">Corso</option>
        </select>
        <br><br>
        <label for="prov">Provincia:</label>
        <input type="text" name="prov" placeholder="MI" pattern="[a-zA-Z]{2}" required title=" \nScrivere l'ABBREVIAZIONE della provincia">
    </div>
    <div class="box2">
        <label for="nomevia">Nome Via:</label><br>
        <input type="text" name="via" placeholder="Vittorio Emanuele III" required>
        <br><br>
        <label for="comune">Comune:</label><br>
        <input type="text" name="comune" placeholder="Bollate" required>
    </div>


    <h4>Account</h4>
    <div class="box">
        <label for="username">Username:</label>
        <input type="text" name="user" pattern=".{4,}" required title=" \nL'username deve essere di minimo 4 caratteri">
    </div>
    <div class="box2">
        <label for="password">Password:</label><br>
        <input type="text" name="password" placeholder="min 8 car./1 spec./1 maiu." pattern="(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%&\-_+=?]).{8,}" required title=" \nNon hai inserito una o più delle seguenti cose\nUna maiuscola, Un Carattere Speciale, La password è più corta di 8 caratteri">
    </div>
    <br>
    <input id="button" type="submit" value="Crea Account">
</form>
COD;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST["name"];
    $cog = $_POST["surname"];
    $data = $_POST["date"];
    $codfis = ($_POST["codicefis"] != null) ? strtoupper($_POST["codicefis"]) : "";
    $mail = $_POST["mail"];
    $tel = $_POST["tel"];
    $ind = $_POST["tipo"] . " " . $_POST["via"] . ", " . strtoupper($_POST["prov"]) . " " . $_POST["comune"];
    $user = $_POST["user"];
    $pass = $_POST["password"];

    $html = "<h3>Dati Inseriti</h3>\n";
    $html = $html . "<h4>Dati Personali</h4><br>\n";
    $html = $html . "<p>Nome e Cognome: $nome $cog<br>\n";
    $html = $html . "Nato il: $data<br>\n";
    if($_POST["codicefis"] != null){
        $html = $html . "Codice Fiscale: $codfis<br>\n";
    }
    $html = $html . "Mail Personale: $mail<br>\n";
    $html = $html . "Telefono Personale: $tel<br>\n";
    $html = $html . "Indirizzo Completo: $ind</p><br>\n";
    $html = $html . "<h4>Dati D'Accesso</h4>\n";  
    $html = $html . "<p>Username: $user<br>\n";
    $html = $html . "<p>Password: $pass<br>\n";
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
    <link rel="stylesheet" href="css/gestione.css">
    <script src="js/script.js" defer></script>
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
                    <li><a href="index.php"><u>HomePage ES_03</u></a></li>
                    <hr>
                    <li><a href="ES_A.php"><b>ES_A</b></a></li>
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