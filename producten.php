<?php
    include 'get_products.php'; 
    include 'webshop_beheer.php'; 
    $winkel_data = getShopData($pdo);
    $data = haalGefilterdeProductenOp($pdo);
    $producten = $data['producten'];
    $alle_categorieen = $data['alle_categorieen'];
    $f = $data['filters'];
    $foutmelding = $data['foutmelding'] ?? '';
    $count = 0; 
    $pdo = null; 
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> - Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo htmlspecialchars($winkel_data['webshop_naam']); ?></h1>
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
                <h2>Welkom in de Webshop!</h2>
                <p>Ontdek ons uitgebreide assortiment van de beste producten. Gebruik de filters en de zoekbalk om snel te vinden wat u zoekt.</p>
            </div>
        </section>
        <section class="container main-webshop-layout">
            <aside class="filter-sidebar">
                <h3>Filter Opties</h3>
                <form action="producten.php" method="get">
                    <input type="hidden" name="zoekterm" value="<?php echo htmlspecialchars($f['zoekterm']); ?>">

                    <h4>Categorie</h4>
                    <div class="filter-groep">
                        <?php foreach ($alle_categorieen as $cat): ?>
                            <label>
                                <input type="checkbox" name="categorie[]" 
                                    value="<?php echo htmlspecialchars($cat['categorie_id']); ?>" 
                                    <?php echo is_filter_active($cat['categorie_id'], $f['geselecteerde_categorie_ids']); ?>> 
                                <?php echo htmlspecialchars($cat['naam']); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>

                    <h4>Prijsbereik</h4>
                    <div class="filter-groep">
                        <label for="min_prijs">Min. Prijs (€):</label>
                        <input type="number" id="min_prijs" name="min_prijs" min="0" step="1" value="<?php echo htmlspecialchars($f['min_prijs']); ?>">
                        <label for="max_prijs">Max. Prijs (€):</label>
                        <input type="number" id="max_prijs" name="max_prijs" min="0" step="1" value="<?php echo htmlspecialchars($f['max_prijs']); ?>">
                    </div>

                    <h4>Beoordeling</h4>
                    <div class="filter-groep">
                        <label><input type="radio" name="beoordeling" value="4up" <?php echo is_filter_active('4up', $f['beoordeling']); ?>> 4 sterren & hoger</label><br>
                        <label><input type="radio" name="beoordeling" value="3up" <?php echo is_filter_active('3up', $f['beoordeling']); ?>> 3 sterren & hoger</label>
                    </div>

                    <button type="submit" class="filter-knop">Filters Toepassen</button>
                    <a href="producten.php" class="reset-knop">Filters Wissen</a>
                </form>
            </aside>
        <section class="producten-content">
            <h2>Alle Producten</h2> 
            <form action="producten.php" method="get" class="zoek-form">
                <input type="text" name="zoekterm" placeholder="Zoek naar producten..." value="<?php echo htmlspecialchars($f['zoekterm']); ?>">
                <button type="submit">Zoeken</button>
            </form>
            <div class="product-grid">
            <?php
            $afbeelding = !empty($product['hoofd_afbeelding_pad']) 
            ? htmlspecialchars($product['hoofd_afbeelding_pad']) 
            : 'afbeeldingen/WEBBAIR_20250812_230805_0000.jpg';
            if (!empty($foutmelding)) {
                echo "<p class='foutmelding'>{$foutmelding}</p>";
            } elseif (!empty($producten)) {
                foreach($producten as $product) {
            ?>
                <article class="product-card" aria-labelledby="product-naam-<?php echo $product['product_id']; ?>">  
                    <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" 
                    aria-label="Bekijk product: <?php echo htmlspecialchars($product['naam_nl']); ?>">
                        <img src="<?php echo $afbeelding; ?>" 
                            alt="Afbeelding van <?php echo htmlspecialchars($product['naam_nl']); ?>" 
                            loading="lazy">
                    </a>
                    <div class="product-content">
                        <h3 id="product-naam-<?php echo $product['product_id']; ?>" class="product-naam">
                            <a href="product_detail.php?id=<?php echo $product['product_id']; ?>">
                                <?php echo htmlspecialchars($product['naam_nl']); ?>
                            </a>
                        </h3>
                        <p class="product-beschrijving">
                            <?php echo htmlspecialchars($product['beschrijving_kort_nl'] ?? 'Nog geen korte beschrijving.'); ?>
                        </p>
                        <div class="product-info-bottom">
                            <div class="product-prijs-container">
                                <p class="product-prijs">
                                    &euro; <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?>
                                </p>
                            </div>
                            <button class="koop-nu" 
                                    data-product-id="<?php echo $product['product_id']; ?>" 
                                    aria-label="Voeg <?php echo htmlspecialchars($product['naam_nl']); ?> toe aan winkelwagen">
                                <i class="fas fa-cart-plus"></i> In Winkelwagen
                            </button>
                        </div>
                    </div>
                </article>

            <?php
                }
            } else {
                echo "<p>Er zijn geen producten gevonden die voldoen aan uw zoekcriteria of filters. Probeer andere termen of wis uw filters.</p>";
            }
            ?>

            </div>
        </section>
        </section>

    </main>
    <footer>
        <div class="container">
            <p>&copy; 2025 <?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> | <a href="privacy.php">Privacy</a> | <a href="algemene_voorwaarden.php">Algemene Voorwaarden</a> | <a href="contact.php">Contact</a></p>
        </div>
    </footer>

</body>
</html>