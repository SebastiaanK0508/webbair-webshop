<?php
require_once 'db_config.php';

function getShopData($pdo) {
    $webshop_instellingen = [];
    try {
        $stmt = $pdo->query("SELECT `sleutel`, `waarde` FROM webshop_instellingen");
        $webshop_instellingen = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); 
    } catch (\PDOException $e) {
        error_log("Databasefout in getShopData: " . $e->getMessage());
    }
    $winkel_data = [
        'webshop_naam'          => $webshop_instellingen['webshop_naam'] ?? 'Webbair Webshop', 
        'hoofd_emailadres'      => $webshop_instellingen['hoofd_emailadres'] ?? 'Onbekend Adres',
        'telefoonnummer'        => $webshop_instellingen['telefoonnummer'] ?? '06-12345678',
        'slogan'                => $webshop_instellingen['slogan'] ?? 'Ontdek ons uitgebreide assortiment van de beste producten.'
    ];
    return $winkel_data;
}
?>