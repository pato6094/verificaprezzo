<?php
// Cancella tutti i cookie
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 3600, '/'); // Imposta la scadenza a un'ora nel passato
}

// Disabilita la cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none';");

// Opzionale: rimuovere variabili di sessione
session_start();
session_unset();
session_destroy();
?>
