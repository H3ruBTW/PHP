<?php
function CheckSession(){
    if(isset($_SESSION['usernameC'])){
        header('Location: ES_C-Riservata.php');
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
        if($user == "Aless" && $psw == "123"){
            $_SESSION['usernameC']=$user;
            $html = <<<COD
            <p>Hai effettuato l'accesso con successo <b>$user</b> con metodo POST<br><br>
            Se vuoi effettuare il logout, <a href="ES_C-Logout.php"><button id="button">PREMI QUI</button></a></p>
            COD;
            return $html;
        } else {
            $url = 'ES_C-Login.php?error=Credenziali errate&from=';
            $url .= basename($_SERVER['PHP_SELF']);
            header("Location: $url");
            exit;
        }
        
    } else {
        if(!isset($_SESSION['usernameC'])){
            $url = 'ES_C-Login.php?error=Per accedere alla pagina bisogna fare prima l\'accesso&from=';
            $url .= basename($_SERVER['PHP_SELF']);
            header("Location: $url");
            exit;            
        } else {
            $user = $_SESSION['usernameC'];
            $html = <<<COD
            <p>Hai effettuato l'accesso con successo <b>$user</b> usando la sessione<br><br>
            Se vuoi effettuare il logout, <a href="ES_C-Logout.php"><button id="button">PREMI QUI</button></a></p>
            COD;  
            return $html;
        }
    }
}

function PasswordControl2(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $user = $_POST['usernameC'];
        $psw = $_POST['passwordC'];
        if(AttempsControl($user)){
            if($user == "Aless" && $psw == "123"){
                $_SESSION['usernameC']=$user;
                $_SESSION['passwordC']=$psw;
                $html = <<<COD
                <p>Hai effettuato l'accesso con successo <b>$user</b> con metodo POST<br><br>
                Se vuoi effettuare il logout, <a href="ES_C-Logout.php"><button id="button">PREMI QUI</button></a></p>
                COD;
                apcu_store("failed_attempts_$user", 0, 0);
                return $html;
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
                    $url = 'ES_C-Login.php?error=Troppi accessi all\'account. ACCOUNT BLOCCATO&from=';
                    $url .= basename($_SERVER['PHP_SELF']);
                    header("Location: $url");
                    exit; 
                } else{
                    $url = "ES_C-Login.php?error=Credenziali errate. Tentativi Rimasti: $Attemps&from=";
                    $url .= basename($_SERVER['PHP_SELF']);
                    header("Location: $url");
                    exit;
                }
            }
        } else {
            $url = 'ES_C-Login.php?error=Troppi accessi all\'account. ACCOUNT BLOCCATO&from=';
            $url .= basename($_SERVER['PHP_SELF']);
            header("Location: $url");
            exit; 
        }
    } else {
        if(!isset($_SESSION['usernameC']) || !isset($_SESSION['passwordC'])){
            $url = 'ES_C-Login.php?error=Per accedere alla pagina bisogna fare prima l\'accesso&from=';
            $url .= basename($_SERVER['PHP_SELF']);
            header("Location: $url");
            exit;            
        } else {
            $user = $_SESSION['usernameC'];
            $psw = $_SESSION['passwordC'];
            $html = <<<COD
            <p>Hai effettuato l'accesso con successo <b>$user</b> usando la sessione<br><br>
            Se vuoi effettuare il logout, <a href="ES_C-Logout.php"><button id="button">PREMI QUI</button></a></p>
            COD;  
            return $html;
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