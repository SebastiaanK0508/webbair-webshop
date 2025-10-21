<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: begin.php");
        exit; //deze moet nog weg voor livegang! (Laat ik hier staan voor de duidelijkheid)
    }
    include 'get_products.php';
    include 'webshop_beheer.php'; 
    $nieuwe_product_data = haalNieuweProductenOp($pdo);
    $winkel_data = getShopData($pdo);
    $nieuwe_producten = $nieuwe_product_data['producten'];
    $homepage_fout = $nieuwe_product_data['foutmelding'];
    $product_count = $_SESSION['product_count'] ?? 0;
    $slogan = htmlspecialchars($winkel_data['slogan'] ?? 'Ontdek ons uitgebreide assortiment van de beste producten.');
    $webshop_naam = htmlspecialchars($winkel_data['webshop_naam'] ?? 'Mijn Webshop'); 
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $webshop_naam; ?> - Home</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJd/rOWm9gZqfKqXofgU9f2eGkGjQd8dE/Yf8nI8IqLgG2x6w/6B0z8f3j4Gg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header role="banner">
        <div class="container">
            <h1><?php echo $webshop_naam; ?></h1>
            <nav role="navigation" aria-label="Hoofdnavigatie">
                <a href="index.php" class="active">Home</a>
                <a href="producten.php">Shop</a>
                <a href="over.php">Over Webbair</a>
                <a href="contact.php">Contact</a>
                <a href="shopping_cart.php" aria-label="Winkelwagen met <?php echo $product_count;?> artikelen">
                    <i class="fas fa-shopping-cart"></i> Winkelwagen <span class="product-count" aria-live="polite">(<?php echo $product_count;?>)</span>
                </a>
            </nav>
        </div>
    </header>
    
    <main role="main" class="container">
        <section class="hero-section" aria-label="Belangrijkste aankondiging">
            <div class="hero-content">
                <h1><?php echo $slogan; ?></h1>
                <p>Kwaliteit, service en de beste deals, direct aan uw deur geleverd.</p>
                <a href="producten.php" class="button primary-button hero-cta" role="button">
                    Nu Shoppen! <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>
        
        <ul class="usp-section" aria-label="Onze unieke verkooppunten">
            <li class="usp-item">
                <i class="usp-icon fas fa-shipping-fast" aria-hidden="true"></i>
                <h3>Snelle Levering</h3>
                <p>Vóór 22:00 besteld, morgen in huis.</p>
            </li>
            <li class="usp-item">
                <i class="usp-icon fas fa-lock" aria-hidden="true"></i>
                <h3>Veilig Betalen</h3>
                <p>Betaal veilig met iDEAL, creditcard of PayPal.</p>
            </li>
            <li class="usp-item">
                <i class="usp-icon fas fa-star" aria-hidden="true"></i>
                <h3>Top Service</h3>
                <p>Onze klanten beoordelen ons met een 9.2/10.</p>
            </li>
        </ul>

        <section class="categorie-sectie" aria-labelledby="categorie-titel">
            <h2 id="categorie-titel">Ontdek onze Populaire Categorieën</h2>
            <div class="categorie-grid">
                <a href="producten.php?cat=digitaal" class="categorie-kaart digitale-producten" role="link" aria-label="Digitale Items">
                    <h3><i class="fas fa-desktop"></i> Digitale Items</h3>
                    <p>Software, E-books en Downloads.</p>
                </a>
                <a href="producten.php?cat=fysiek" class="categorie-kaart fysieke-producten" role="link" aria-label="Fysieke Artikelen">
                    <h3><i class="fas fa-box-open"></i> Fysieke Artikelen</h3>
                    <p>Hardware, Gadgets en Meer.</p>
                </a>
                <a href="producten.php?cat=nieuw" class="categorie-kaart aanbiedingen" role="link" aria-label="Speciale Aanbiedingen">
                    <h3><i class="fas fa-tags"></i> Speciale Aanbiedingen</h3>
                    <p>Mis onze tijdelijke deals niet!</p>
                </a>
            </div>
        </section>

        <section class="nieuwe-producten-section" aria-labelledby="nieuw-titel">
            <h2 id="nieuw-titel" class="section-title">Uitgelicht: Onze Laatste Toevoegingen</h2>
            <div class="product-grid">
                <?php 
                if (!empty($homepage_fout)):
                ?>
                    <p class="error-message" role="alert"><?php echo htmlspecialchars($homepage_fout); ?></p>
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
                        <article class="product-card" aria-labelledby="product-naam-<?php echo $product['product_id']; ?>">
                            <?php 
                                $afbeelding = !empty($product['hoofd_afbeelding_pad']) ? htmlspecialchars($product['hoofd_afbeelding_pad']) : 'placeholder_mok.jpg';
                            ?>
                            <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" aria-label="Bekijk product: <?php echo htmlspecialchars($product['naam_nl']); ?>">
                                <img src="<?php echo $afbeelding; ?>" alt="Afbeelding van <?php echo htmlspecialchars($product['naam_nl']); ?>" loading="lazy">
                            </a>
                            <h3 id="product-naam-<?php echo $product['product_id']; ?>" class="product-naam">
                                <a href="product_detail.php?id=<?php echo $product['product_id']; ?>"><?php echo htmlspecialchars($product['naam_nl']); ?></a>
                            </h3>
                            <p class="product-beschrijving"><?php echo htmlspecialchars($product['beschrijving_kort_nl'] ?? 'Nog geen korte beschrijving.'); ?></p>
                            <div class="product-prijs-container">
                                <p class="product-prijs">€ <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?></p>
                            </div>
                            <button class="koop-nu" data-product-id="<?php echo $product['product_id']; ?>" aria-label="Voeg <?php echo htmlspecialchars($product['naam_nl']); ?> toe aan winkelwagen">
                                <i class="fas fa-cart-plus"></i> In Winkelwagen
                            </button>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
             <?php if (!empty($nieuwe_producten)): ?>
                 <div class="text-center" style="margin-top: 30px;">
                    <a href="producten.php" class="button secondary-button" role="button">
                        Bekijk Alle Producten <i class="fas fa-chevron-right"></i>
                    </a>
                 </div>
            <?php endif; ?>
        </section>
    </main>
    
    <footer role="contentinfo">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> <?php echo $webshop_naam; ?> | 
                <a href="privacy.php">Privacy</a> | 
                <a href="algemene_voorwaarden.php">Algemene Voorwaarden</a> | 
                <a href="contact.php">Contact</a>
            </p>
        </div>
    </footer>
</body>
</html>