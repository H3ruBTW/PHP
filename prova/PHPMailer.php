<?php
require "config.php";
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

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
    $mail->addAddress(MAIL_BASE, 'Destinatario');

    // Oggetto dell'email
    $mail->Subject = 'Il tuo codice di verifica';

    // Genera un codice di verifica a 6 cifre
    $codice_verifica = rand(100000, 999999);

    // Contenuto HTML dell'email
    $mail->isHTML(true);
    $mail->Body = "
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
                <p>Ciao $user,</p>
                <p>Utilizza il codice qui sotto per confermare la tua identità:</p>
                <div class='code-box'>$codice_verifica</div>
                <p>Se non hai richiesto questo codice, ignora questa email.</p>
            </div>
            <div class='footer'>
                &copy; 2025 Esercizi PHP. Tutti i diritti riservati.
            </div>
        </div>
    </body>
    </html>";

    // Invia l'email
    $mail->send();

    // Messaggio di conferma da mostrare nella pagina
    $html = 'Email inviata con successo!';
} catch (Exception $e) {
    $html = "Errore nell'invio dell'email: {$mail->ErrorInfo}";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">
    <title>Esercizi</title>
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
                    <li><a href="index.php"><u>HomePage prova</u></a></li>
                    <hr>
                    <li><a href="APCu.php"><u>Prova APCu</u></a></li>
                    <hr>
                    <li><a href="PHPMailer.php"><u>PHPMailer</u></a></li>
                    <hr>
                </ul>
            </nav>
        </div>
        <div class="content">
            <?php echo $html; ?>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 Buongallino Alessandro</p>
    </footer>
</body>
</html>



