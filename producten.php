<?php
    include 'get_products.php'; 
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
    <title>Onze Producten - Webshop Voorbeeld</title>
    <link rel="stylesheet" href="webshop.css">
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

    <section class="webshop-banner">
        <div class="container">
            <h2>Welkom in de Webshop!</h2>
            <p>Ontdek ons uitgebreide assortiment van de beste producten. Gebruik de filters en de zoekbalk om snel te vinden wat u zoekt.</p>
            <form action="producten.php" method="get" class="zoek-form">
                <input type="text" name="zoekterm" placeholder="Zoek naar producten..." value="<?php echo htmlspecialchars($f['zoekterm']); ?>">
                <button type="submit">Zoeken</button>
            </form>
        </div>
    </section>

    <main class="container main-webshop-layout">
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
            <div class="product-grid">
            <?php
            // Toon foutmelding als die er is
            if (!empty($foutmelding)) {
                echo "<p class='foutmelding'>{$foutmelding}</p>";
            } elseif (!empty($producten)) {
                foreach($producten as $product) {
            ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product['hoofd_afbeelding_pad'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($product['naam_nl']); ?>">

                    <h3 class="product-naam"><?php echo htmlspecialchars($product['naam_nl']); ?></h3>

                    <p class="product-beschrijving"><?php echo htmlspecialchars($product['beschrijving_kort_nl']); ?></p>

                    <p class="product-prijs">€ <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?> Excl BTW</p>

                    <form action="winkelwagen.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                        <button type="submit" class="koop-nu">In Winkelwagen</button>
                    </form>
                </div>

            <?php
                }
            } else {
                echo "<p>Er zijn geen producten gevonden die voldoen aan uw zoekcriteria of filters. Probeer andere termen of wis uw filters.</p>";
            }
            ?>

            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Mijn Dynamische Webshop | Privacy | Contact</p>
        </div>
    </footer>

</body>
</html>