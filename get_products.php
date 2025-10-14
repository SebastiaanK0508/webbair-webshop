<?php
require_once 'db_config.php'; 
$producten = [];
$foutmelding = "";

try {
    $sql_select = "SELECT 
                       product_id, naam_nl, sku, prijs_excl_btw, voorraad_aantal, is_zichtbaar 
                   FROM 
                       producten 
                   ORDER BY 
                       naam_nl ASC"; 
    
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute();
    $producten = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $foutmelding = "Fout bij ophalen producten: " . $e->getMessage();
}
?>

<!-- <!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Product Overzicht</title>
</head>
<body>
    <h1>Overzicht van Alle Producten</h1>
    
    <?php if (!empty($foutmelding)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($foutmelding); ?></p>
    <?php elseif (empty($producten)): ?>
        <p>Er zijn nog geen producten in de database gevonden.</p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>SKU</th>
                    <th>Prijs (excl. BTW)</th>
                    <th>Voorraad</th>
                    <th>Zichtbaar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($producten as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['naam_nl']); ?></td>
                    <td><?php echo htmlspecialchars($product['sku']); ?></td>
                    <td>€ <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($product['voorraad_aantal']); ?></td>
                    <td><?php echo ($product['is_zichtbaar'] ? 'Ja' : 'Nee'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <p><a href="product_form.php">Nieuw product toevoegen</a></p>
</body>
</html> -->