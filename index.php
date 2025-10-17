<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // Zorg ervoor dat de gebruiker is ingelogd om naar de beheerderspagina te gaan
        // Op een echte webshop zou je deze check weghalen voor de openbare index.php
        // Voor nu laten we het staan, maar let op!
        header("Location: begin.php");
        exit; 
    }
    
    // Inclusie van bestanden
    include 'get_products.php';
    include 'webshop_beheer.php'; // Verondersteld dat deze getAllSettings of vergelijkbaar bevat
    
    $nieuwe_product_data = haalNieuweProductenOp($pdo);
    $winkel_data = getShopData($pdo); // Haal alle shop-instellingen op
    
    $nieuwe_producten = $nieuwe_product_data['producten'];
    $homepage_fout = $nieuwe_product_data['foutmelding'];
    $product_count = 0; // Totaal aantal items in de winkelwagen, moet nog ingevuld worden
    
    // Bepaal de slogan
    $slogan = htmlspecialchars($winkel_data['slogan'] ?? 'Ontdek ons uitgebreide assortiment van de beste producten.');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> - Home</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <header>
        <div class="container">
            <h1><?php echo htmlspecialchars($winkel_data['webshop_naam']); ?></h1>
            <nav>
                <a href="index.php" class="active">Home</a>
                <a href="producten.php">Shop</a>
                <a href="over.php">Over Webbair</a>
                <a href="contact.php">Contact</a>
                <a href="shopping_cart.php">Winkelwagen <span class="product-count">(<?php echo $product_count;?>)</span></a>
            </nav>
        </div>
    </header>
    
    <main class="container">
        <section class="hero-section">
            <div class="hero-content">
                <h1><?php echo $slogan; ?></h1>
                <p>Kwaliteit, service en de beste deals, direct aan uw deur geleverd.</p>
                <a href="producten.php" class="button primary-button">Bekijk de Shop</a>
            </div>
        </section>
        
        <section class="usp-section">
            <div class="usp-item">
                <span class="usp-icon">📦</span>
                <h3>Snelle Levering</h3>
                <p>Voor 22:00 besteld, morgen in huis.</p>
            </div>
            <div class="usp-item">
                <span class="usp-icon">🛡️</span>
                <h3>Veilig Betalen</h3>
                <p>Betaal veilig met iDEAL, creditcard of PayPal.</p>
            </div>
            <div class="usp-item">
                <span class="usp-icon">⭐️</span>
                <h3>Top Service</h3>
                <p>Onze klanten beoordelen ons met een 9.2/10.</p>
            </div>
        </section>

        <section class="categorie-sectie">
            <h2>Ontdek onze Populaire Categorieën</h2>
            <div class="categorie-grid">
                <a href="producten.php?cat=digitaal" class="categorie-kaart digitale-producten">
                    <h3>Digitale Items</h3>
                    <p>Software, E-books en Downloads.</p>
                </a>
                <a href="producten.php?cat=fysiek" class="categorie-kaart fysieke-producten">
                    <h3>Fysieke Artikelen</h3>
                    <p>Hardware, Gadgets en Meer.</p>
                </a>
                <a href="producten.php?cat=nieuw" class="categorie-kaart aanbiedingen">
                    <h3>Speciale Aanbiedingen</h3>
                    <p>Mis onze tijdelijke deals niet!</p>
                </a>
            </div>
        </section>

        <section class="nieuwe-producten-section">
            <h2 class="section-title">Uitgelicht: Onze Laatste Toevoegingen</h2>
            <div class="product-grid">
                <?php 
                if (!empty($homepage_fout)):
                ?>
                    <p style="color: red; padding: 20px; border: 1px dashed red;"><?php echo htmlspecialchars($homepage_fout); ?></p>
                <?php 
                elseif (empty($nieuwe_producten)):
                ?>
                    <p>Er zijn momenteel geen nieuwe producten beschikbaar. Kom snel terug!</p>
                <?php 
                else: 
                    $limiet = 4; 
                    $producten_getoond = 0;
                    foreach ($nieuwe_producten as $product): 
                        if ($producten_getoond >= $limiet) break;
                        $producten_getoond++;
                ?>
                        <div class="product-card">
                            <?php 
                                $afbeelding = !empty($product['hoofd_afbeelding_pad']) ? htmlspecialchars($product['hoofd_afbeelding_pad']) : 'placeholder_mok.jpg';
                            ?>
                            <img src="<?php echo $afbeelding; ?>" alt="<?php echo htmlspecialchars($product['naam_nl']); ?>">
                            <h3 class="product-naam"><?php echo htmlspecialchars($product['naam_nl']); ?></h3>
                            <p class="product-beschrijving"><?php echo htmlspecialchars($product['beschrijving_kort_nl'] ?? 'Nog geen korte beschrijving.'); ?></p>
                            <p class="product-prijs">€ <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?></p>
                            <button class="koop-nu" data-product-id="<?php echo $product['id']; ?>">In Winkelwagen</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
             <?php if (!empty($nieuwe_producten)): ?>
                 <div class="text-center" style="margin-top: 30px;">
                    <a href="producten.php" class="button secondary-button">Bekijk Alle Producten</a>
                 </div>
            <?php endif; ?>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 <?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> | <a href="privacy.php">Privacy</a> | <a href="algemene_voorwaarden.php">Algemene Voorwaarden</a> | <a href="contact.php">Contact</a></p>
        </div>
    </footer>
</body>
</html>