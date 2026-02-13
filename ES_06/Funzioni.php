<?php
require "config.php";
require __DIR__ . '/Mail/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define("HOST", "localhost");
define("USER", "root");
define("PASS", "1234");
define("DB", "es06");

/**
 * @brief Effettua il login di un utente.
 * Questa funzione verifica le credenziali dell'utente e gestisce il processo di login.
 * Se le credenziali sono corrette, l'utente viene reindirizzato alla pagina riservata.
 * In caso di errori, vengono gestiti i tentativi di accesso falliti e l'utente viene avvisato.
 * @param usr Il nome utente.
 * @param psw La password dell'utente.
 * @param cookies Indica se salvare l'username nei cookie.
 */
function Login($usr, $psw, $cookies) {
    $conn = mysqli_connect(HOST, USER, PASS, DB);

    // ERRORE CONNESSIONE
    if (!$conn) {
        header("Location: Login.php?error=Errore di connessione al DB. Riprovare più tardi.");
        exit;
    }

    // STATEMENT PER EVITARE SQL INJECTION
    $query = "SELECT * FROM utente WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $usr);
    mysqli_stmt_execute($stmt);
    $ris = mysqli_stmt_get_result($stmt);

    if ($ris && mysqli_num_rows($ris) > 0) {
        $acc = mysqli_fetch_assoc($ris);

        // Controllo errori login
        if ($acc['Errori'] >= 5) {
            $ultimo_errore = strtotime($acc['Ultimo_Errore']);

            if ((time() - $ultimo_errore) / 60 < 30) {
                header("Location: Login.php?error=Troppi accessi, riprova tra 30 minuti.");
                exit;
            } else {
                // Resetta il contatore errori dopo 30 minuti
                $query = "UPDATE utente SET Errori = 0 WHERE Username = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "s", $usr);
                mysqli_stmt_execute($stmt);
            }
        }

        // Controllo password con password_verify()
        if (password_verify($psw, $acc['Password'])) {
            $_SESSION['username'] = $usr;

            // Se l'utente vuole salvare l'username
            if ($cookies) {
                setcookie("user", $usr, time() + 3600, "/");
            }

            // Aggiorna dati login
            $query = "UPDATE utente SET Errori = 0, Ultimo_Accesso = CURRENT_TIMESTAMP WHERE Username = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $usr);
            mysqli_stmt_execute($stmt);

            mysqli_close($conn);
            header("Location: Riservata.php");
            exit;
        } else {
            // PASSWORD ERRATA
            setError($conn, $acc);
            header("Location: Login.php?error=Credenziali errate.");
            exit;
        }
    } else {
        // Utente non trovato
        header("Location: Login.php?error=Credenziali errate.");
        exit;
    }
    
    mysqli_close($conn);
}

/**
 * @brief Registra un nuovo utente.
 * Questa funzione gestisce la registrazione di un nuovo utente.
 * Verifica se l'email e lo username sono già registrati e, in caso contrario, crea un nuovo account.
 */
function Registration(){
    $conn = mysqli_connect(HOST, USER, PASS, DB);

    //ERRORE CONNESSIONE
    if(!$conn){
        header("Location: Login.php?error=Non è stato possibile creare l'account. Riprovare più tardi.");
        exit;
    } 
    
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $date = $_POST['date'];
    $email = strtolower($_POST['mail']);
    $user = $_POST['username'];
    $psw = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    //STATEMENT PER EVITARE SQL INJECTION - Verifica se l'email esiste già
    $query = "SELECT COUNT(*) FROM utente WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        header("Location: Register.php?error=Email già registrata!");
        exit;
    }

    //STATEMENT PER EVITARE SQL INJECTION - Verifica se lo username esiste già
    $query = "SELECT COUNT(*) FROM utente WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        header("Location: Register.php?error=Username già in uso!");
        exit;
    }

    //CREO UNO STATEMENT PER EVITARE LA SQL INJECTION
    $query = "INSERT INTO utente (Nome, Cognome, Data_Nascita, Email, Username, Password) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $surname, $date, $email, $user, $psw);

    if(mysqli_stmt_execute($stmt)){
        header("Location: Login.php?succ=Account creato con successo");
        exit;
    } else {
        header("Location: Registrazione.php?error=Non è stato possibile creare l'account. Riprovare più tardi.");
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

/**
 * @brief Incrementa il contatore di errori di login per un utente.
 * Questa funzione aggiorna il contatore di errori di login per un utente specifico.
 * Viene chiamata quando un tentativo di login fallisce.
 * @param conn La connessione al database.
 * @param acc I dati dell'account dell'utente.
 */
function setError($conn, $acc){
    $user = $acc['Username'];
    $error = $acc['Errori']+1;
    $query = "update utente set Errori = $error, Ultimo_Errore = CURRENT_TIMESTAMP() where Username = '$user'";
    mysqli_query($conn, $query);
}

/**
 * @brief Controlla se la sessione è valida per accedere alla pagina riservata.
 * Questa funzione verifica se l'utente ha una sessione valida per accedere a una pagina riservata.
 * Se la sessione non è valida, l'utente viene reindirizzato alla pagina di login.
 * @return true se la sessione è valida, altrimenti reindirizza alla pagina di login.
 */
function CheckSessionRis(){
    if(!isset($_SESSION['username'])){
        header("Location: Login.php?error=Entrata in pagina riservata non autorizzata");
        exit;
    } 

    return true;
}

/**
 * @brief Controlla se la sessione è valida.
 * Questa funzione verifica se l'utente ha una sessione valida.
 * Se la sessione è valida, l'utente viene reindirizzato alla pagina riservata.
 */
function CheckSession(){
    if(isset($_SESSION['username'])){
        setUltimoAccesso();
        header("Location: Riservata.php");
        exit;
    }    
}

/**
 * @brief Visualizza un messaggio di errore.
 * Questa funzione restituisce un messaggio di errore se presente nella richiesta GET.
 * @return Il messaggio di errore se presente, altrimenti null.
 */
function DisplayError(){
    if($_SERVER['REQUEST_METHOD']=="GET"){
        if(isset($_GET['error'])){
            $err = "<p style=\"color:red\">" . $_GET['error'] . "</p>";
            return $err;
        }       
    }

    return null;
}

/**
 * @brief Visualizza un messaggio di successo.
 * Questa funzione restituisce un messaggio di successo se presente nella richiesta GET.
 * @return Il messaggio di successo se presente, altrimenti null.
 */
function DisplaySuccess(){
    if($_SERVER['REQUEST_METHOD']=="GET"){
        if(isset($_GET['succ'])){
            $succ = "<p style=\"color:#4CAF50\">" . $_GET['succ'] . "</p>";
            return $succ;
        }       
    }

    return null;
}

/**
 * @brief Ottiene l'ultimo accesso dell'utente.
 * Questa funzione restituisce la data e l'ora dell'ultimo accesso dell'utente.
 * @return La data e l'ora dell'ultimo accesso.
 */
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
        header("Location: Login.php?error=Errore DB: " . mysqli_error($conn));
    }  
}

/**
 * @brief Imposta l'ultimo accesso dell'utente all'ora corrente.
 * Questa funzione aggiorna l'ultimo accesso dell'utente all'ora corrente nel database.
 */
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
        header("Location: Login.php?error=Errore DB: " . mysqli_error($conn));
    }  
}

/**
 * @brief Cambia il nome utente.
 * Questa funzione aggiorna il nome utente nel database.
 * Verifica se il nuovo nome utente è già in uso e, in caso contrario, lo aggiorna.
 * @param new_usr Il nuovo nome utente.
 */
function ChangeUser($new_usr){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    //STATEMENT PER EVITARE SQL INJECTION - Verifica se lo username esiste già
    $query = "SELECT COUNT(*) FROM utente WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $new_usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        header("Location: C_User.php?error=Username già in uso!");
        exit;
    }

    $query = "UPDATE utente SET Username = ? WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $new_usr, $usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['username'] = $new_usr;

    header("Location: Riservata.php?succ=Username cambiato con successo");
    exit;
}

/**
 * @brief Cambia la password dell'utente.
 * Questa funzione aggiorna la password dell'utente nel database.
 * Verifica se la vecchia password è corretta e, in caso affermativo, la aggiorna con la nuova password.
 * @param old_psw La vecchia password.
 * @param new_psw La nuova password.
 */
function ChangePsw($old_psw, $new_psw){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];
    $new_psw = password_hash(trim($new_psw), PASSWORD_BCRYPT);

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }
    $pass = "";

    $query = "SELECT Password FROM utente WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pass);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if(!password_verify($old_psw, $pass)){
        header("Location: C_Psw.php?error=Password errata");
        exit;
    }

    $query = "UPDATE utente SET Password = ? WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $new_psw, $usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: Riservata.php?succ=Password cambiata con successo");
    exit;
}

/**
 * @brief Cambia l'email dell'utente.
 * Questa funzione aggiorna l'email dell'utente nel database.
 * Verifica se la nuova email è già registrata e, in caso contrario, la aggiorna.
 * @param mail La nuova email.
 */
function ChangeMail($mail){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    //STATEMENT PER EVITARE SQL INJECTION - Verifica se l'email esiste già
    $query = "SELECT COUNT(*) FROM utente WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        header("Location: C_Mail.php?error=Email già registrata!");
        exit;
    }

    $query = "UPDATE utente SET Email = ? WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", strtolower($mail), $usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: Riservata.php?succ=E-mail cambiata con successo");
    exit;
}

/**
 * @brief Cambia i dati personali dell'utente.
 * Questa funzione aggiorna i dati personali dell'utente nel database.
 * @param nome Il nuovo nome.
 * @param cog Il nuovo cognome.
 * @param dob La nuova data di nascita.
 */
function ChangePData($nome, $cog, $dob){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    $query = "UPDATE utente SET Nome = ?, Cognome = ?, Data_Nascita = ? WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $cog, $dob, $usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: Riservata.php?succ=Dati cambiati con successo");
    exit;
}

/**
 * @brief Cancella l'account dell'utente.
 * Questa funzione elimina l'account dell'utente dal database.
 * Dopo l'eliminazione, la sessione viene distrutta e l'utente viene reindirizzato alla pagina di login.
 */
function Cancel(){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile eliminare l'account");
        exit;
    }

    $query = "DELETE FROM utente WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $usr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    session_destroy();

    header("Location: Login.php?succ=Cancellazione avvenuta con successo");
    exit;
}

/**
 * @brief Recupera tutti i dati dell'utente.
 * Questa funzione restituisce tutti i dati dell'utente come un array associativo.
 * @return Un array associativo con i dati dell'utente.
 */
function fetch_all(){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $usr = $_SESSION['username'];

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    $query = "SELECT * FROM utente WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $usr);
    mysqli_stmt_execute($stmt);
    $ris = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_fetch_assoc($ris);
}

/**
 * @brief Recupera tutti i dati dell'utente tramite email.
 * Questa funzione restituisce tutti i dati dell'utente come un array associativo utilizzando l'email.
 * @return Un array associativo con i dati dell'utente.
 */
function fetch_all_mail(){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $mail = $_SESSION['mail'];

    if(!$conn){
        header("Location: Login.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    $query = "SELECT * FROM utente WHERE EMAIL = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);
    $ris = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_fetch_assoc($ris);
}

/**
 * @brief Controlla se l'email esiste nel database.
 * Questa funzione verifica se un'email esiste nel database.
 * @param mail L'email da controllare.
 * @return true se l'email esiste, altrimenti false.
 */
function CheckMail($mail){
    $conn = mysqli_connect(HOST, USER, PASS, DB);

    if(!$conn){
        header("Location: Forgot_password.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    $query = "SELECT COUNT(*) FROM utente WHERE EMAIL = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if($count > 0)
        return true;
    else
        return false;
}

/**
 * @brief Imposta un token di verifica per l'utente.
 * Questa funzione genera e imposta un token di verifica per l'utente nel database.
 */
function SetToken(){
    $mail = $_SESSION['mail'];
    $conn = mysqli_connect(HOST, USER, PASS, DB);

    if(!$conn){
        header("Location: Forgot_password.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    $token = rand(100000, 999999);

    $query = "UPDATE utente SET Token = ?, Token_Creation = CURRENT_TIMESTAMP() WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $token, $mail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/**
 * @brief Invia un'email con il token di verifica.
 * Questa funzione invia un'email contenente il token di verifica all'utente.
 */
function SendTokenMail(){  
    $mail = new PHPMailer(true);

    $acc = fetch_all_mail();
    
    try {
        // Configura SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP del provider
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_SMTP; // Tua email
        $mail->Password = PASS_SMTP;  // Password per le app (se usi Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        // Configura mittente e destinatario
        $mail->setFrom(EMAIL_SMTP, 'Buongallino da PHP');
        $mail->addAddress($_SESSION['mail'], 'Destinatario');
    
        // Oggetto dell'email
        $mail->Subject = 'Il tuo codice di verifica';
    
        // Contenuto HTML dell'email
        $mail->isHTML(true);
        $mail->Body = <<<COD
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Codice di Verifica</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #333;
                    color: white;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .container {
                    width: 90%;
                    max-width: 500px;
                    background: white;
                    color: black;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
                    text-align: center;
                }
                .header {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 20px;
                }
                .content {
                    font-size: 16px;
                    margin-bottom: 20px;
                }
                .code-box {
                    display: inline-block;
                    font-size: 20px;
                    font-weight: bold;
                    background: #ddd;
                    padding: 10px 15px;
                    border: 2px dashed #000;
                    border-radius: 5px;
                    margin-top: 10px;
                }
                .footer {
                    font-size: 12px;
                    text-align: center;
                    margin-top: 20px;
                }
                a {
                    color: blue;
                    text-decoration: none;
                }
                a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>Codice di Verifica</div>
                <div class='content'>
                    <p>Ciao {$acc['Nome']},</p>
                    <p>Utilizza il codice qui sotto per confermare la tua identità:</p>
                    <div class='code-box'>{$acc['Token']}</div>
                    <p>Se non hai richiesto questo codice, ignora questa email.</p>
                </div>
                <div class='footer'>
                    &copy; 2025 Buongallino Alessandro. Tutti i diritti riservati.
                </div>
            </div>
        </body>
        </html>"
        COD;
    
        // Invia l'email
        $mail->send();
    } catch (Exception $e) {
        header("Location: Forgot_password.php?error=Non è stato possibile recapitare la mail, riprovare più tardi");
        exit;
    }
}

/**
 * @brief Verifica il token di autenticazione.
 * Questa funzione verifica se il token di autenticazione fornito è valido (combinazione e scadenza).
 * @param token Il token di autenticazione da verificare.
 */
function verify_token($token){
    $acc = fetch_all_mail();

    if($token == $acc['Token']){
        $token_creation = strtotime($acc['Token_Creation']);

        if((time() - $token_creation) / 60 < 5){
            return true;
        } else {
            header("Location: Forgot_password.php?error=Il codice d'autenticazione è scaduto");
            exit;
        }
    } else {
        header("Location: Token.php?error=Il codice d'autenticazione è errato");
        exit;
    }
}

/**
 * @brief Imposta una nuova password per l'utente.
 * Questa funzione aggiorna la password dell'utente nel database.
 * @param pass La nuova password da impostare.
 */
function setPassword($pass){
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    $mail = $_SESSION['mail'];
    $new_psw = password_hash(trim($pass), PASSWORD_BCRYPT);

    if(!$conn){
        header("Location: Riservata.php?error=Non è stato possibile collegarsi, riprovare più tardi");
        exit;
    }

    $query = "UPDATE utente SET Password = ? WHERE EMAIL = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $new_psw, $mail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    session_destroy();

    header("Location: Login.php?succ=Password cambiata con successo");
    exit;
}
?>