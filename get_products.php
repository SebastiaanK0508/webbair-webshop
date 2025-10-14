<?php

require_once 'db_config.php'; 

function haalNieuweProductenOp(PDO $pdo): array 
{
    $producten = [];
    $foutmelding = "";
    try {
        $sql_select = "SELECT 
                           product_id, 
                           naam_nl, 
                           beschrijving_kort_nl, 
                           prijs_excl_btw, 
                           hoofd_afbeelding_pad
                       FROM 
                           producten
                       WHERE
                           is_zichtbaar = 1
                       ORDER BY 
                           product_id DESC
                       LIMIT 3"; 
        
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute();
        $producten = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $foutmelding = "Fout bij ophalen nieuwe producten: " . $e->getMessage();
    }
    
    return [
        'producten' => $producten, 
        'foutmelding' => $foutmelding
    ];
}


/**
 * Haalt categorieën en gefilterde producten op uit de database op basis van GET-parameters.
 *
 * @param PDO $pdo De PDO databaseverbinding.
 * @return array Een associatieve array met 'producten', 'alle_categorieen', en 'filters'.
 */
function haalGefilterdeProductenOp(PDO $pdo): array 
{
    // 1. CATEGORIEËN OPHALEN
    $cat_query = "SELECT categorie_id, naam FROM categorieen ORDER BY naam";
    $cat_stmt = $pdo->query($cat_query);
    $alle_categorieen = $cat_stmt ? $cat_stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    
    // 2. FILTERS EN INPUT OPHALEN
    $zoekterm = $_GET['zoekterm'] ?? '';
    $geselecteerde_categorie_ids = $_GET['categorie'] ?? []; 
    $min_prijs = $_GET['min_prijs'] ?? '';
    $max_prijs = $_GET['max_prijs'] ?? '';
    $beoordeling = $_GET['beoordeling'] ?? '';

    // 3. START SQL EN PARAMETERS
    $sql = "SELECT product_id, naam_nl, beschrijving_kort_nl, prijs_excl_btw, hoofd_afbeelding_pad 
            FROM producten 
            WHERE is_zichtbaar = TRUE";
    $params = []; 
    
    // 4. BOUW DE QUERY
    // Zoekterm
    if (!empty($zoekterm)) {
        $sql .= " AND (naam_nl LIKE :zoekterm_naam OR beschrijving_kort_nl LIKE :zoekterm_beschrijving)";
        $params[':zoekterm_naam'] = '%' . $zoekterm . '%';
        $params[':zoekterm_beschrijving'] = '%' . $zoekterm . '%';
    }
    
    // Categorieën
    if (!empty($geselecteerde_categorie_ids)) {
        $numerieke_ids = array_filter($geselecteerde_categorie_ids, 'is_numeric');
        if (!empty($numerieke_ids)) {
            $in_placeholders = [];
            foreach ($numerieke_ids as $index => $id) {
                $placeholder = ":catid" . $index;
                $in_placeholders[] = $placeholder;
                $params[$placeholder] = (int)$id;
            }
            $sql .= " AND hoofd_categorie_id IN (" . implode(', ', $in_placeholders) . ")";
        }
    }
    
    // Prijsbereik
    if (is_numeric($min_prijs) && $min_prijs !== '') {
        $sql .= " AND prijs_excl_btw >= :min_prijs";
        $params[':min_prijs'] = (float)$min_prijs;
    }
    if (is_numeric($max_prijs) && $max_prijs !== '') {
        $sql .= " AND prijs_excl_btw <= :max_prijs";
        $params[':max_prijs'] = (float)$max_prijs;
    }
    
    // Beoordeling (Placeholder - indien de tabel/kolom niet bestaat, veroorzaakt dit een fout)
    if ($beoordeling === '4up' || $beoordeling === '3up') {
        $min_rating = ($beoordeling === '4up') ? 4 : 3;
        $sql .= " AND (SELECT AVG(rating_waarde) FROM product_ratings WHERE product_ratings.product_id = producten.product_id) >= :min_rating";
        $params[':min_rating'] = $min_rating;
    }

    // 5. VOER DE QUERY UIT
    try {
        $product_stmt = $pdo->prepare($sql);
        $product_stmt->execute($params);
        $producten = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Fout bij gefilterde productquery: " . $e->getMessage());
        return [
            'producten' => [],
            'alle_categorieen' => $alle_categorieen,
            'filters' => compact('zoekterm', 'geselecteerde_categorie_ids', 'min_prijs', 'max_prijs', 'beoordeling'),
            'foutmelding' => "Er is een technische fout opgetreden bij het filteren van de producten."
        ];
    }

    // 6. RETOURNEER ALLE DATA
    return [
        'producten' => $producten,
        'alle_categorieen' => $alle_categorieen,
        'filters' => compact('zoekterm', 'geselecteerde_categorie_ids', 'min_prijs', 'max_prijs', 'beoordeling'),
    ];
}

/**
 * Helper functie om de 'checked' status van filter-elementen te bepalen.
 */
function is_filter_active($value, $huidige_waarden): string 
{
    if (is_array($huidige_waarden) && in_array($value, $huidige_waarden)) {
        return 'checked';
    } elseif (!is_array($huidige_waarden) && $huidige_waarden === $value) {
        return 'checked';
    }
    return '';
}

// Opmerking: we hebben de eerdere, losse code ($producten = [], $count = 0, etc.)
// vervangen door een functie zodat deze niet automatisch wordt uitgevoerd, maar alleen
// wordt aangeroepen op de pagina die hem nodig heeft (bijv. index.php of producten.php).

// Sluit de PHP-tag niet aan het einde