<?php
define("HOST", "localhost");
define("USER", "USERS");
define("PASS", "123");
define("DB", "es06");

$conn = mysqli_connect(HOST, USER, PASS, DB);

if(!$conn){
    echo json_encode("Errore di connessione");
    exit;
}

$query = "SELECT * FROM utente LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$ris = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($ris)>0){
    echo json_encode(mysqli_fetch_assoc($ris));
} else {
    echo json_encode("Errore di Fetching");
}

mysqli_close($conn);
?>