<?php
session_start();
session_destroy();

if($_SERVER['REQUEST_METHOD']=="POST"){
    //faccio scadere il cookie, eliminandolo
    if($_POST['cookies'])
        setcookie("user", "" , time() - 1, "/");
}

header("Location: Welcome.php");
exit;
?>
