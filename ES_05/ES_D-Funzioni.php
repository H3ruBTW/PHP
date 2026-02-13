<?php
define("HOST", "localhost");
define("USER", "USERS");
define("PASS", "123");
define("DB", "es05");

function Login($usr, $psw, $cookies){

    $conn = mysqli_connect(HOST, USER, PASS, DB);

    //ERRORE CONNESSIONE
    if(!$conn){
        header("Location: ES_D-Login.php?error=Errore di connessione al DB. Riprovare più tardi.");
        exit;
    } 

    $query = "select * from utente where Username = \"$usr\"";
    try {
        $ris = mysqli_query($conn, $query);

        if($ris){
            if(mysqli_num_rows($ris)>0){
                $acc = mysqli_fetch_assoc($ris);
                
                //Se gli errori sono 5 e non sono passati 30 min dall'ultimo errore
                //non continua se sono passati 30 min annulla gli errori
                if($acc['Errori'] == 5){
                    $ultimo_errore = strtotime($acc['Ultimo_Errore']);

                    if((time()-$ultimo_errore)/60 < 30){
                        header("Location: ES_D-Login.php?error=Troppi accessi riprova fra circa 30 minuti");
                        exit;
                    } else {
                        $user = $acc['Username'];
                        $query = "update utente set Errori = 0 where Username = '$user'";
                        mysqli_query($conn, $query);
                    }
                }

                if($acc['Password'] == $psw){
                    $_SESSION['username'] = $usr;

                    //cookies ma viene mantenuto solo per la prossima ora
                    if($cookies)
                        setcookie("user", $usr , time() + 3600, "/");

                    $user = $acc['Username'];
                    $query = "update utente set Errori = 0, Ultimo_Accesso = CURRENT_TIMESTAMP() where Username = '$user'";
                    mysqli_query($conn, $query);

                    header("Location: ES_D-Riservata.php");
                    exit;
                } else {
                    //ERRORE CREDENZIALI ERRATE
                    setError($conn, $acc);
                    header("Location: ES_D-Login.php?error=Credenziali Errate");
                    exit;
                }

            } else {
                //ERRORE CREDENZIALI ERRATE
                header("Location: ES_D-Login.php?error=Credenziali Errate");
                exit;
            }
        } else {
            //ERRORE QUERY
            header("Location: ES_D-Login.php?error=Errore di ricerca dell'account. Riprovare più tardi.");
            exit;
        }
    } catch (\Throwable $th) {
        header("Location: ES_D-Login.php?error=Errore DB: " . mysqli_error($conn));
    }  
}

function setError($conn, $acc){
    $user = $acc['Username'];
    $error = $acc['Errori']+1;
    $query = "update utente set Errori = $error, Ultimo_Errore = CURRENT_TIMESTAMP() where Username = '$user'";
    mysqli_query($conn, $query);
}

function CheckSessionRis(){
    if(!isset($_SESSION['username'])){
        header("Location: ES_D-Login.php?error=Entrata in pagina riservata non autorizzata");
        exit;
    } 

    return true;
}

function CheckSession(){
    if(isset($_SESSION['username'])){
        setUltimoAccesso();
        header("Location: ES_D-Riservata.php");
        exit;
    }    
}

function DisplayError(){
    if($_SERVER['REQUEST_METHOD']=="GET"){
        if(isset($_GET['error'])){
            $err = "<p style=\"color:red\">" . $_GET['error'] . "</p>";
            return $err;
        }       
    }

    return "<br>";
}

function getUltimoAccesso(){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    //ERRORE CONNESSIONE
    if(!$conn){
        return "ERROR";
    }

    $query = "select * from utente where Username = \"$usr\"";
    try {
        $ris = mysqli_query($conn, $query);

        if($ris){
            if(mysqli_num_rows($ris)>0){
                $acc = mysqli_fetch_assoc($ris);

                return $acc['Ultimo_Accesso'];

            } 
        } 
    } catch (\Throwable $th) {
        header("Location: ES_D-Login.php?error=Errore DB: " . mysqli_error($conn));
    }  
}

function setUltimoAccesso(){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    //ERRORE CONNESSIONE
    if(!$conn){
        exit;
    }

    $query = "select * from utente where Username = \"$usr\"";
    try {
        $ris = mysqli_query($conn, $query);

        if($ris){
            if(mysqli_num_rows($ris)>0){
                $query = "update utente set Ultimo_Accesso = CURRENT_TIMESTAMP() where Username = '$usr'";
                mysqli_query($conn, $query);

            } 
        } 
    } catch (\Throwable $th) {
        header("Location: ES_D-Login.php?error=Errore DB: " . mysqli_error($conn));
    }  
}
?>