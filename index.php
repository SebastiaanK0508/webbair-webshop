<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: begin.php");
        exit; 
    }
    include 'get_products.php';
    include 'webshop_beheer.php'; 
    $nieuwe_product_data = haalNieuweProductenOp($pdo);
    $winkel_data = getShopData($pdo);
    $nieuwe_producten = $nieuwe_product_data['producten'];
    $homepage_fout = $nieuwe_product_data['foutmelding'];
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
            <h1><?php echo htmlspecialchars($winkelnaam); ?></h1>
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
        <section class="hero-section">
            <div class="hero-content">
                <h1>Webbair Webshop</h1>
                <p>Ontdek ons uitgebreide assortiment van de beste producten.</p>
            </div>
        </section>
        <section class="nieuwe-producten-section">
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
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2025 Webbair Webshop | <a>Privacy</a> | <a>Contact</a></p>
        </div>
    </footer>
</body>
</html>