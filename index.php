<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onze Producten - Webshop Voorbeeld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Mijn Dynamische Webshop</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="products.php">Producten</a>
                <a href="shopping_cart.php">Winkelwagen <span class="product-count"><?php echo $product_count;?></span></a>
            </nav>
        </div>
    </header>
    
    <main class="container">
        <h2>Nieuwe Producten</h2>
        <div class="product-grid">

            <div class="product-card">
                <img src="placeholder_mok.jpg" alt="Zwarte Koffiemok">
                <h3 class="product-naam">{{ Productnaam 1 (uit SQL) }}</h3>
                <p class="product-beschrijving">Een elegante, matzwarte mok. Perfect voor uw dagelijkse dosis cafeïne.</p>
                <p class="product-prijs">€ {{ Prijs 1 (uit SQL) }}</p>
                <button class="koop-nu">In Winkelwagen</button>
            </div>

            <div class="product-card">
                <img src="placeholder_thee.jpg" alt="Biologische Theepakket">
                <h3 class="product-naam">{{ Productnaam 2 (uit SQL) }}</h3>
                <p class="product-beschrijving">Set van 5 biologische theesmaken, handgeplukt.</p>
                <p class="product-prijs">€ {{ Prijs 2 (uit SQL) }}</p>
                <button class="koop-nu">In Winkelwagen</button>
            </div>

            </div>
        </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Mijn Dynamische Webshop | Privacy | Contact</p>
        </div>
    </footer>

</body>
</html>