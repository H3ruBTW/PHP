<?php
/**
 * Script per generare 100 utenti con hash bcrypt REALI
 * Esegui: php genera_utenti.php
 * Output: utenti_100_bcrypt.sql
 */

$nomi = ["Marco", "Luca", "Andrea", "Francesco", "Alessandro", "Matteo", "Lorenzo", "Davide", "Riccardo", "Simone", "Giulia", "Francesca", "Chiara", "Sara", "Martina", "Alessia", "Elena", "Sofia", "Valentina", "Federica", "Giovanni", "Paolo", "Stefano", "Antonio", "Giuseppe", "Roberto", "Michele", "Fabio", "Daniele", "Cristian"];

$cognomi = ["Rossi", "Ferrari", "Russo", "Bianchi", "Romano", "Gallo", "Costa", "Fontana", "Ricci", "Marino", "Greco", "Bruno", "Gatti", "Conti", "De Luca", "Mancini", "Leone", "Lombardi", "Moretti", "Barbieri", "Colombo", "Rizzo", "Esposito", "Barone", "Vitale", "Giordano", "Santoro", "Serra", "Ferrara", "Caruso"];

// Imposta seed per avere dati riproducibili (opzionale)
// mt_srand(12345);

$output = "-- Script SQL con 100 utenti e hash bcrypt REALI\n";
$output .= "-- Generato con PHP password_hash() con salt automatico\n";
$output .= "-- Username: utente1...utente100\n";
$output .= "-- Password: password1...password100\n\n";

for ($i = 1; $i <= 200; $i++) {
    $username = "utente" . $i;
    $password = "password" . $i;

    // Genera hash bcrypt REALE con salt automatico
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Genera dati casuali
    $nome = $nomi[array_rand($nomi)];
    $cognome = $cognomi[array_rand($cognomi)];
    $email = $username . "@example.com";

    // Data di nascita casuale
    $anno = rand(1970, 2005);
    $mese = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
    $giorno = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
    $dataNascita = "$anno-$mese-$giorno";

    // Genera INSERT statement
    $output .= "INSERT INTO `utente` (`Nome`, `Cognome`, `Email`, `Data_Nascita`, `Username`, `Password`, `Errori`) ";
    $output .= "VALUES ('$nome', '$cognome', '$email', '$dataNascita', '$username', '$passwordHash', 0);\n";
}

// Salva il file SQL
file_put_contents('utenti_100_bcrypt.sql', $output);

echo "✅ File generato con successo: utenti_100_bcrypt.sql\n";
echo "📊 100 utenti con hash bcrypt reali creati\n";
echo "\n🔑 Credenziali di test:\n";
echo "   utente1 : password1\n";
echo "   utente2 : password2\n";
echo "   ...\n";
echo "   utente100 : password100\n";
?>
