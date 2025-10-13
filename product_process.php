<?php

require 'db_config.php';

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ----------------------------------------------------------------------------------
    // 1. DATA OPHALEN & SANITIZEN
    // ----------------------------------------------------------------------------------
    
    // Tekstvelden (String)
    $naam_nl                = trim($_POST['naam_nl'] ?? '');
    $sku                    = trim($_POST['sku'] ?? '');
    $ean                    = trim($_POST['ean'] ?? NULL);
    $beschrijving_lang_nl   = trim($_POST['beschrijving_lang_nl'] ?? NULL);
    $beschrijving_kort_nl   = trim($_POST['beschrijving_kort_nl'] ?? NULL); // NIEUW
    $meta_titel_nl          = trim($_POST['meta_titel_nl'] ?? NULL);
    $meta_beschrijving_nl   = trim($_POST['meta_beschrijving_nl'] ?? NULL); // NIEUW
    $hoofd_afbeelding_pad   = trim($_POST['hoofd_afbeelding_pad'] ?? NULL); // NIEUW
    $video_url              = trim($_POST['video_url'] ?? NULL); // NIEUW
    
    // Slug: Creëer een slug uit de naam voor de URL. Dit moet uniek zijn!
    // **OPMERKING:** Voor een robuust systeem moet je een functie gebruiken die slugs genereert.
    // Voor nu gebruiken we de naam.
    $slug_nl = strtolower(str_replace(' ', '-', $naam_nl)); 
    
    // Numerieke velden (Float/Int)
    $prijs_excl_btw         = filter_var($_POST['prijs_excl_btw'] ?? 0, FILTER_VALIDATE_FLOAT);
    $btw_tarief_id          = filter_var($_POST['btw_tarief_id'] ?? 0, FILTER_VALIDATE_INT);
    $gewicht_gram           = filter_var($_POST['gewicht_gram'] ?? NULL, FILTER_VALIDATE_INT);
    $voorraad_aantal        = filter_var($_POST['voorraad_aantal'] ?? 0, FILTER_VALIDATE_INT);
    $voorraad_laag_limiet   = filter_var($_POST['voorraad_laag_limiet'] ?? 5, FILTER_VALIDATE_INT); // NIEUW
    $hoofd_categorie_id     = filter_var($_POST['hoofd_categorie_id'] ?? NULL, FILTER_VALIDATE_INT);
    $fabrikant_merk_id      = filter_var($_POST['fabrikant_merk_id'] ?? NULL, FILTER_VALIDATE_INT);
    
    // Boolean velden
    $is_zichtbaar           = isset($_POST['is_zichtbaar']) ? 1 : 0;
    $is_uitverkocht         = isset($_POST['is_uitverkocht']) ? 1 : 0; // NIEUW

    // ----------------------------------------------------------------------------------
    // 2. CONVERTEREN NAAR NULL (Voor optionele velden in de DB)
    // ----------------------------------------------------------------------------------
    $gewicht_gram           = ($gewicht_gram === false || $gewicht_gram === null) ? NULL : $gewicht_gram;
    $voorraad_laag_limiet   = ($voorraad_laag_limiet === false || $voorraad_laag_limiet === null) ? 5 : $voorraad_laag_limiet;
    $hoofd_categorie_id     = ($hoofd_categorie_id === false) ? NULL : $hoofd_categorie_id;
    $fabrikant_merk_id      = ($fabrikant_merk_id === false) ? NULL : $fabrikant_merk_id;
    $ean                    = ($ean == '') ? NULL : $ean;
    
    // Lege strings omzetten naar NULL
    $meta_titel_nl = ($meta_titel_nl == '') ? NULL : $meta_titel_nl;
    $meta_beschrijving_nl = ($meta_beschrijving_nl == '') ? NULL : $meta_beschrijving_nl;
    $beschrijving_kort_nl = ($beschrijving_kort_nl == '') ? NULL : $beschrijving_kort_nl;
    $hoofd_afbeelding_pad = ($hoofd_afbeelding_pad == '') ? NULL : $hoofd_afbeelding_pad;
    $video_url = ($video_url == '') ? NULL : $video_url;

    // ----------------------------------------------------------------------------------
    // 3. VALIDATIE & OPSLAAN
    // ----------------------------------------------------------------------------------
    if (empty($naam_nl) || empty($sku) || $prijs_excl_btw === false || $btw_tarief_id === false || $voorraad_aantal === false) {
        $message = "Fout: Vul alle verplichte velden in (Naam, SKU, Prijs, BTW ID, Voorraad).";
        $type = "error";
    } else {
        try {
            // SQL INSERT STATEMENT - NU MET ALLE 17 VELDEN
            $sql = "INSERT INTO producten (
                        naam_nl, sku, ean, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
                        prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, voorraad_laag_limiet,
                        is_zichtbaar, is_uitverkocht, hoofd_categorie_id, fabrikant_merk_id, 
                        hoofd_afbeelding_pad, video_url, meta_titel_nl, meta_beschrijving_nl
                    ) VALUES (
                        :naam, :sku, :ean, :slug, :beschrijving_kort, :beschrijving_lang, 
                        :prijs, :btw_id, :gewicht, :voorraad, :laag_limiet, 
                        :zichtbaar, :uitverkocht, :categorie_id, :merk_id, 
                        :afbeelding_pad, :video, :meta_titel, :meta_beschrijving
                    )";
            
            $stmt = $pdo->prepare($sql);
            
            // Bind ALLE 17 waarden
            $stmt->bindParam(':naam', $naam_nl);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':ean', $ean);
            $stmt->bindParam(':slug', $slug_nl);
            $stmt->bindParam(':beschrijving_kort', $beschrijving_kort_nl);
            $stmt->bindParam(':beschrijving_lang', $beschrijving_lang_nl);
            $stmt->bindParam(':prijs', $prijs_excl_btw);
            $stmt->bindParam(':btw_id', $btw_tarief_id);
            $stmt->bindParam(':gewicht', $gewicht_gram);
            $stmt->bindParam(':voorraad', $voorraad_aantal);
            $stmt->bindParam(':laag_limiet', $voorraad_laag_limiet);
            $stmt->bindParam(':zichtbaar', $is_zichtbaar);
            $stmt->bindParam(':uitverkocht', $is_uitverkocht);
            $stmt->bindParam(':categorie_id', $hoofd_categorie_id);
            $stmt->bindParam(':merk_id', $fabrikant_merk_id);
            $stmt->bindParam(':afbeelding_pad', $hoofd_afbeelding_pad);
            $stmt->bindParam(':video', $video_url);
            $stmt->bindParam(':meta_titel', $meta_titel_nl);
            $stmt->bindParam(':meta_beschrijving', $meta_beschrijving_nl);
            
            if ($stmt->execute()) {
                $lastId = $pdo->lastInsertId();
                $message = "Succes! Product **" . htmlspecialchars($naam_nl) . "** is toegevoegd (ID: {$lastId}).";
                $type = "success";
            } else {
                $message = "Fout bij opslaan: De database-executie is mislukt.";
                $type = "error";
            }
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                // Kan door SKU, EAN of SLUG komen
                $message = "Fout: SKU, EAN of SLUG bestaat al, of een van de opgegeven ID's (BTW, Categorie, Merk) bestaat niet.";
            } else {
                $message = "PDO Fout: " . $e->getMessage();
            }
            $type = "error";
        }
    }
} else {
    $message = "Geen formuliergegevens ontvangen (alleen POST toegestaan).";
    $type = "error";
}

// ----------------------------------------------------------------------
// 4. TOON STATUSBERICHT (HTML/CSS is ongewijzigd)
// ----------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Status</title>
    <link rel="stylesheet" href="product_form.html" type="text/css"> 
    <style> 
        .message-box { 
            padding: 20px; 
            margin: 20px auto; 
            max-width: 600px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="message-box <?php echo $type; ?>">
        <?php echo nl2br(htmlspecialchars($message)); ?>
        <p><a href="product_form.html">Terug naar formulier</a></p>
    </div>
</body>
</html>