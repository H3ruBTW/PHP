<?php
require "Fnz_pannello.php";
session_start();

$succ = DisplaySuccess();
$error = DisplayError();

$orderby = $_GET['orderby'] ?? "UserID";
$di = $_GET['di'] ?? "i";
$pag = $_GET['pag'] ?? "1";

$id = $_GET['id'] ?? "";

if($_SERVER['REQUEST_METHOD']=="POST"){
    switch ($_POST['type']) {
        case 'update':
            UpdateTable();
            break;

        case 'delete':
            deleteInDB();
            break;
        
        default:
            break;
    }
}

switch ($id) {
    case '1':
        $html = show_table1();
        break;
    
    case '2':
        $html = show_table2();
        break;

    case '3':
        $html = show_table3();
        break;
    
    default:
        $html = show_table1();
        break;
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
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/load.css">
    <title>Esecizi</title>
    <script>
        //oggetto globale per il browser per comunicare con PHP
        window.tab = <?= $id ?>;
        window.orderby = "<?= $orderby ?>";
        window.di = "<?= $di ?>";
        window.pag = "<?= $pag ?>";
    </script>
    <script src="js/tabelle.js" defer></script>
</head>
<body>
    <header id="header"><h1>ESERCIZI PHP</h1></header>
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
                    <li><a href="Pannello.php"><b>Pannello</b></a></li>
                    <hr>                  
                </ul>
            </nav>
        </div>
        <div class="content">
            <div style="display:inline">
                <p><span style="font-size: 40px; font-weight:bold;">Tabella utenti n°<?= $id ?></span>
                <a href="Pannello.php?id=1" class="link">Tabella 1</a> | 
                <a href="Pannello.php?id=2&orderby=UserID&di=i&pag=1" class="link">Tabella 2</a> |
                <a href="Pannello.php?id=3&orderby=UserID&di=i&pag=1" class="link">Tabella 3</a>
                </p>
            </div>
            <br>
            <?= $html ?>
            <br><br><br>
        </div>
    </div>

    <div id="displaybox" class="<?php if(isset($error)){echo "err";}elseif(isset($succ)){echo "succ";}?>" hidden>
        <p><?php if(isset($error)){echo $error;}elseif(isset($succ)){echo $succ;} ?></p>
    </div>

    <?php if($id == 3){echo "<img src=\"img/loading.gif\" id=\"loader\">";}?>

    <footer>
        <p>&copy; 2025 Buongallino Alessandro</p>
    </footer>
</body>
</html>