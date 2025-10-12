<?php
// 1. Database-instellingen inladen en verbinding maken
// Zorgt ervoor dat $mysqli en $result beschikbaar zijn
// include 'config.php'; 
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onze Producten - Webshop Voorbeeld</title>
    <link rel="stylesheet" href="stijl.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Mijn Dynamische Webshop</h1>
            <nav>
                <a href="producten.php">Producten</a>
                <a href="winkelwagen.php">Winkelwagen (0)</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Populaire Producten</h2>
        
        <div class="product-grid">

        <?php
        // 2. Controleer of de query resultaten heeft opgeleverd
        if ($result && $result->num_rows > 0) {
            // 3. Loop door alle rijen van de resultaatset
            while($product = $result->fetch_assoc()) {
                // 4. Toon de HTML voor één product, gevuld met database-data
        ?>
            <div class="product-card">
                <img src="<?php echo $product['afbeelding_url']; ?>" alt="<?php echo $product['naam']; ?>">
                
                <h3 class="product-naam"><?php echo $product['naam']; ?></h3>
                
                <p class="product-beschrijving"><?php echo $product['beschrijving']; ?></p>
                
                <p class="product-prijs">€ <?php echo number_format($product['prijs'], 2, ',', '.'); ?></p>
                
                <form action="winkelwagen.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <button type="submit" class="koop-nu">In Winkelwagen</button>
                </form>
            </div>
            
        <?php
            } // Einde van de while-loop
            $result->free(); // Maak de resultaatset vrij
        } else {
            // Wat te tonen als er geen producten zijn
            echo "<p>Er zijn op dit moment geen producten beschikbaar in de winkel.</p>";
        }
        ?>

        </div>
        </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Mijn Dynamische Webshop | Privacy | Contact</p>
        </div>
    </footer>

</body>
</html>

<?php
// 5. Sluit de databaseverbinding (goede praktijk)
// $mysqli->close();
?>