<?php
define("HOST", "localhost");
define("USER", "root");
define("PASS", "1234");
define("DB", "es06");

try {
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    
    
    // ERRORE CONNESSIONE
    if (!$conn) {
        throw new Exception("Errore di connessione al DB. Riprovare più tardi.");
    }

    $id      = trim($_POST['UserID']);
    $nome    = trim($_POST['Nome']);
    $cognome = trim($_POST['Cognome']);
    $mail    = trim($_POST['Email']);
    $dob     = trim($_POST['Data_Nascita']);
    $user    = trim($_POST['Username']);
    $err     = trim($_POST['Errori']);
    $derr    = trim($_POST['Ultimo_Errore']);
    $dacc    = trim($_POST['Ultimo_Accesso']);
    $token   = trim($_POST['Token']);
    $dtoken  = trim($_POST['Token_Creation']);
    $oldID   = trim($_POST['oldID']);
    $oldMail  = trim($_POST['oldMail']);
    $oldUser   = trim($_POST['oldUser']);

    //CHECK ID
    $query = "SELECT COUNT(*) FROM utente WHERE UserID = ? AND UserID != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id, $oldID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        throw new Exception("L'utente con ID:" . $id . " esiste già");
    }

    // CHECK nome
    if ($nome == "") {
        throw new Exception("Il campo \"NOME\" è vuoto");
    }

    // CHECK cognome
    if ($cognome == "") {
        throw new Exception("Il campo \"COGNOME\" è vuoto");
    }

    // CHECK mail
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $mail)) {
        throw new Exception("Il campo \"MAIL\" è errato");
    }

    // CHECK duplicato Email - usa subquery invece di COUNT con colonna
    $query = "SELECT UserID FROM utente WHERE Email = ? AND Email != ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $mail, $oldMail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $exist);
    $hasDuplicate = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($hasDuplicate) {
        throw new Exception("L'utente con id: " . $exist . " ha questa Email");
    }


    // CHECK data di nascita
    if ($date = strtotime($dob)) {
        if ($date >= strtotime(date("Y-m-d"))) {
            throw new Exception("La \"Data Di Nascita\" non è valida, data oltre quella odierna");
        }
    } else {
        throw new Exception("La \"Data Di Nascita\" non è valida, formato ANNO-MS-GG");
    }

    // CHECK user
    // CHECK duplicato Username
    $query = "SELECT UserID FROM utente WHERE Username = ? AND Username != ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $user, $oldUser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $exist);
    $hasDuplicate = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($hasDuplicate) {
        throw new Exception("L'utente con id: " . $exist . " ha questo Username");
    }


    // CHECK Errori
    if (filter_var($err, FILTER_VALIDATE_INT) !== false) {
        $err = intval($err);
        if (!($err >= 0 && $err <= 5)) {
            throw new Exception("Il campo \"Errori\" è errato, è stato inserito un numero minore di 0 o maggiore di 5");
        }
    } else {
        throw new Exception("Il campo \"Errori\" è errato, è stato inserito un NaN");
    }

    // CHECK Data Ultimo Errore
    if (!strtotime($derr)) {
        throw new Exception("Il campo \"Ultimo_Errore\" è errato, usa il formato ANNO-MS-GG HH:MM:SS");
    }

    // CHECK Data Ultimo Accesso
    if (!strtotime($dacc)) {
        throw new Exception("Il campo \"Ultimo_Accesso\" è errato, usa il formato ANNO-MS-GG HH:MM:SS");
    }

    // CHECK Token
    if (!preg_match("/^[0-9]{6,6}$/", $token) && $token != "") {
        throw new Exception("Il campo \"Token\" è errato, è stato inserito un NaN o non esattamente 6 cifre");
    }

    // CHECK Data Token
    if (!strtotime($dtoken)) {
        throw new Exception("Il campo \"Token_Creation\" è errato, usa il formato ANNO-MS-GG HH:MM:SS");
    }


    $query = "UPDATE utente 
    SET UserID = ?, Nome = ?, Cognome = ?, Email = ?, Data_Nascita = ?, Username = ?, Errori = ?, Ultimo_Errore = ?, 
    Ultimo_Accesso = ?, Token = ?, Token_Creation = ?
    WHERE UserID = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issssssssssi", $id, $nome, $cognome, $mail, $dob, $user, $err, $derr, $dacc, $token, $dtoken, $oldID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    http_response_code(200);
    echo "Utente con id: " . $oldID . " modificato con successo";
} catch (mysqli_sql_exception $th) {
    http_response_code(500);
    //restituisco il messaggio nel formato testo
    //echo "Errore di connessione al DB. Riprovare più tardi.";
    echo "ERRORE SQL: " . $th->getMessage();
} catch (\Throwable $th) {
    http_response_code(400);
    echo $th->getMessage();
} 
    

?>