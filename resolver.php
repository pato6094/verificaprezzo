<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if (isset($_GET['code'])) {
    $shortCode = $_GET['code']; // Recupera il codice dalla URL
    $url = "https://amzn.eu/d/{$shortCode}"; // Formatta l'URL di Amazon con il codice corto
    $headers = get_headers($url, true); // Recupera gli headers dell'URL
    
    // Controlla se il link è stato rediretto (ovvero ha un header 'Location')
    if ($headers !== false && isset($headers['Location'])) {
        // Se è un array di URL, prendi l'ultimo URL della lista
        $longUrl = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
        
        // Pulizia del link per rimuovere parametri extra
        $cleanUrl = preg_replace('/(\?|\&)(ref|social_share|starsLeft|skipTwisterOG|.*)=[^&]*/', '', $longUrl);
        
        // Costruisci il nuovo link con il referral tag
        $asin = extractASIN($cleanUrl); // Funzione per estrarre l'ASIN dal link
        $referralTag = 'pato666-21'; // Modifica con il tuo tag di affiliazione
        $finalUrl = "https://www.amazon.it/gp/offer-listing/{$asin}/?tag={$referralTag}";
        
        // Restituisci l'URL lungo e pulito come JSON
        header('Content-Type: application/json');
        echo json_encode(["longUrl" => $finalUrl]);
    } else {
        // In caso di errore, invia un messaggio JSON di errore
        header('Content-Type: application/json');
        echo json_encode(["error" => "Link non trovato o errore di redirezione"]);
    }
} else {
    // Se il parametro 'code' non è presente nella URL
    header('Content-Type: application/json');
    echo json_encode(["error" => "Codice non fornito"]);
}

// Funzione per estrarre l'ASIN dal link
function extractASIN($url) {
    if (preg_match('/\/dp\/([A-Z0-9]{10})/', $url, $matches)) {
        return $matches[1]; // Restituisce l'ASIN
    }
    return null; // Restituisce null se l'ASIN non è trovato
}
?>
