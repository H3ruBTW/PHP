<?php
function Login($usr, $psw){
    define("HOST", "localhost");
    define("USER", "USERS");
    define("PASS", "123");
    define("DB", "es05");

    $conn = mysqli_connect(HOST, USER, PASS, DB);

    //ERRORE CONNESSIONE
    if(!$conn){
        header("Location: ES_C-Login.php?error=Errore di connessione al DB. Riprovare più tardi.");
        exit;
    } 

    $query = "select Username, Password from utente where Username = \"$usr\"";
    try {
        $ris = mysqli_query($conn, $query);

        if($ris){
            if(mysqli_num_rows($ris)>0){
                $acc = mysqli_fetch_assoc($ris);

                if($acc['Password'] == $psw){
                    $_SESSION['username'] = $usr;
                    header("Location: ES_C-Riservata.php");
                    exit;
                } else {
                    //ERRORE CREDENZIALI ERRATE
                    header("Location: ES_C-Login.php?error=Credenziali Errate");
                    exit;
                }

            } else {
                //ERRORE CREDENZIALI ERRATE
                header("Location: ES_C-Login.php?error=Credenziali Errate");
                exit;
            }
        } else {
            //ERRORE QUERY
            header("Location: ES_C-Login.php?error=Errore di ricerca dell'account. Riprovare più tardi.");
            exit;
        }
    } catch (\Throwable $th) {
        header("Location: ES_C-Login.php?error=Errore DB: " . mysqli_error($conn));
    }
    
}

function CheckSessionRis(){
    if(!isset($_SESSION['username'])){
        header("Location: ES_C-Login.php?error=Entrata in pagina riservata non autorizzata");
        exit;
    } 

    return true;
}

function CheckSession(){
    if(isset($_SESSION['username'])){
        header("Location: ES_C-Riservata.php");
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
?>