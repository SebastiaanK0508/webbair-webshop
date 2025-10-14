<?php
    session_start();
    // Zorg ervoor dat de header() call stopt met de uitvoering
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: begin.php");
        exit; // BELANGRIJK: Voeg exit toe na header()
    }
    
    // get_products.php bevat nu de functies en de $pdo verbinding
    include 'get_products.php'; 
    
    // Haal de data op
    $nieuwe_product_data = haalNieuweProductenOp($pdo);
    
    // Wijs de correcte variabelen toe
    $nieuwe_producten = $nieuwe_product_data['producten'];
    $homepage_fout = $nieuwe_product_data['foutmelding'];

    // Tijdelijke $count, vul dit later aan met de echte winkelwagenlogica
    $count = 0; 
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webbair Webshop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Webbair Webshop</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="producten.php">Shop</a>
                <a href="over.php">Over Webbair</a>
                <a href="contact.php">Contact</a>
                <a href="shopping_cart.php">Winkelwagen <span class="product-count">(<?php echo $count;?>)</a>
            </nav>
        </div>
    </header>
    
    <main class="container">
        <h2>Nieuwe Producten</h2>
        <div class="product-grid">
            <?php 
            if (!empty($homepage_fout)):
            ?>
                <p style="color: red;"><?php echo htmlspecialchars($homepage_fout); ?></p>
            <?php 
            elseif (empty($nieuwe_producten)):
            ?>
                <p>Er zijn momenteel geen nieuwe producten beschikbaar.</p>
            <?php 
            else: 
            ?>
                <?php foreach ($nieuwe_producten as $product): ?>
                    <div class="product-card">
                        <?php 
                            $afbeelding = !empty($product['hoofd_afbeelding_pad']) ? htmlspecialchars($product['hoofd_afbeelding_pad']) : 'placeholder_mok.jpg';
                        ?>
                        <img src="<?php echo $afbeelding; ?>" alt="<?php echo htmlspecialchars($product['naam_nl']); ?>">
                        <h3 class="product-naam"><?php echo htmlspecialchars($product['naam_nl']); ?></h3>
                        <p class="product-beschrijving"><?php echo htmlspecialchars($product['beschrijving_kort_nl'] ?? 'Geen beschrijving beschikbaar.'); ?></p>
                        <p class="product-prijs">€ <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?></p>
                        <button class="koop-nu">In Winkelwagen</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2025 Webbair Webshop | <a>Privacy</a> | <a>Contact</a></p>
        </div>
    </footer>

</body>
</html>