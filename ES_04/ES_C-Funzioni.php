<?php
function CheckSessionInLogin(){
    if(isset($_SESSION['usernameC'])){
        header('Location: ES_C-Riservata.php');
        exit;
    } 
}

function CheckSessionInPages(){
    if(!isset($_SESSION['usernameC'])){
        $url = "ES_C-Login.php?error=Non è stata possibile la ricezione della sessione&from=" . basename($_SERVER['PHP_SELF']);
        header("Location: $url");
        exit;
    } else {
        return true;
    }
}

function DisplayError(){
    if($_SERVER['REQUEST_METHOD']=="GET"){
        if(isset($_GET['error'])){
            $html = "<p style=\"color:red\">" . $_GET['error'] . "</p>";
            return $html;
        }       
    }

    return "<br>";
}

function PasswordControl(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $user = $_POST['usernameC'];
        $psw = $_POST['passwordC'];
        if(AttempsControl($user)){
            if($user == "Aless" && $psw == "123"){
                $_SESSION['usernameC']=$user;
                apcu_store("failed_attempts_$user", 0, 0);
                header('Location: ES_C-Riservata.php');
                exit;
            } else {
                $Attemps = apcu_fetch("failed_attempts_$user") ?: 0;
                $Attemps++;
                if($Attemps == 3){
                    apcu_store("failed_attempts_$user", $Attemps, 60);
                } else {
                    apcu_store("failed_attempts_$user", $Attemps, 0);
                }

                $Attemps = 3 - $Attemps;

                if($Attemps == 0){
                    $url = 'ES_C-Login.php?error=Troppi accessi all\'account. ACCOUNT BLOCCATO';
                    header("Location: $url");
                    exit; 
                } else{
                    $url = "ES_C-Login.php?error=Credenziali errate. Tentativi Rimasti: $Attemps";
                    header("Location: $url");
                    exit;
                }
            }
        } else {
            $url = 'ES_C-Login.php?error=Troppi accessi all\'account. ACCOUNT BLOCCATO';
            header("Location: $url");
            exit; 
        }
    } 
}

function AttempsControl($userattempt){
    $MAXATTEMPS = 3;

    $failedAttempts = apcu_fetch("failed_attempts_$userattempt") ?: 0;

    if($failedAttempts >= $MAXATTEMPS){
        return false;
    } else {
        return true;
    }
}

function Logout(){
    session_destroy();
    header('Location: ES_C-Welcome.php');
    exit;
}
?>