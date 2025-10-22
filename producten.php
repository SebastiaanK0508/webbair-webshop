<?php
    // Zorg ervoor dat de helper-functie bestaat om een product-afbeelding op te halen.
    // De huidige implementatie heeft een fout in de loop met $afbeelding:
    /*
    $afbeelding = !empty($product['hoofd_afbeelding_pad']) 
    ? htmlspecialchars($product['hoofd_afbeelding_pad']) 
    : 'afbeeldingen/WEBBAIR_20250812_230805_0000.jpg';
    
    Deze variabele moet BINNEN de foreach-lus worden gedefinieerd om te werken met het huidige product.
    Ik heb dit hieronder in de lus aangepast.
    */
    
    // De rest van de PHP logica is ongewijzigd
    include 'get_products.php'; 
    include 'webshop_beheer.php'; 
    $winkel_data = getShopData($pdo);
    $data = haalGefilterdeProductenOp($pdo);
    $producten = $data['producten'];
    $alle_categorieen = $data['alle_categorieen'];
    $f = $data['filters'];
    $foutmelding = $data['foutmelding'] ?? '';
    $count = 0; // Deze moet normaal gesproken uit de sessie of database komen
    $pdo = null; 
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> - Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary-blue': '#1e40af', 
                        'secondary-gray': '#f3f4f6',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-secondary-gray min-h-screen">
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-extrabold text-primary-blue">
                <?php echo htmlspecialchars($winkel_data['webshop_naam']); ?>
            </h1>
            <nav class="hidden md:flex space-x-6 text-gray-700 font-semibold">
                <a href="index.php" class="hover:text-primary-blue transition duration-150">Home</a>
                <a href="producten.php" class="text-primary-blue border-b-2 border-primary-blue pb-1">Shop</a>
                <a href="over.php" class="hover:text-primary-blue transition duration-150">Over Webbair</a>
                <a href="contact.php" class="hover:text-primary-blue transition duration-150">Contact</a>
                <a href="shopping_cart.php" class="flex items-center hover:text-primary-blue transition duration-150">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    Winkelwagen 
                    <span class="ml-1 px-2 py-0.5 bg-red-500 text-white text-xs rounded-full font-bold">
                        (<?php echo $count;?>)
                    </span>
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <section class="bg-white p-6 md:p-10 rounded-xl shadow-lg mb-8">
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Welkom in de Webshop!</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Ontdek ons uitgebreide assortiment van de beste producten. Gebruik de filters en de zoekbalk om snel te vinden wat u zoekt.</p>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg h-fit sticky top-[6rem]">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Filter Opties</h3>
                <form action="producten.php" method="get">
                    <input type="hidden" name="zoekterm" value="<?php echo htmlspecialchars($f['zoekterm']); ?>">
                    <h4 class="font-semibold text-gray-700 mt-4 mb-2">Categorie</h4>
                    <div class="space-y-1 filter-groep mb-4">
                        <?php foreach ($alle_categorieen as $cat): ?>
                            <label class="flex items-center text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox" name="categorie[]" 
                                    value="<?php echo htmlspecialchars($cat['categorie_id']); ?>" 
                                    <?php echo is_filter_active($cat['categorie_id'], $f['geselecteerde_categorie_ids']); ?>
                                    class="mr-2 rounded text-primary-blue focus:ring-primary-blue"> 
                                <?php echo htmlspecialchars($cat['naam']); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <h4 class="font-semibold text-gray-700 mt-4 mb-2">Prijsbereik</h4>
                    <div class="space-y-2 filter-groep mb-4">
                        <div>
                            <label for="min_prijs" class="block text-sm font-medium text-gray-700">Min. Prijs (€):</label>
                            <input type="number" id="min_prijs" name="min_prijs" min="0" step="1" 
                                value="<?php echo htmlspecialchars($f['min_prijs']); ?>" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-primary-blue focus:ring-primary-blue text-sm">
                        </div>
                        <div>
                            <label for="max_prijs" class="block text-sm font-medium text-gray-700">Max. Prijs (€):</label>
                            <input type="number" id="max_prijs" name="max_prijs" min="0" step="1" 
                                value="<?php echo htmlspecialchars($f['max_prijs']); ?>"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-primary-blue focus:ring-primary-blue text-sm">
                        </div>
                    </div>

                    <h4 class="font-semibold text-gray-700 mt-4 mb-2">Beoordeling</h4>
                    <div class="space-y-1 filter-groep mb-6">
                        <label class="flex items-center text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="radio" name="beoordeling" value="4up" 
                                <?php echo is_filter_active('4up', $f['beoordeling']); ?>
                                class="mr-2 text-primary-blue focus:ring-primary-blue"> 
                            4 sterren & hoger
                        </label>
                        <label class="flex items-center text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="radio" name="beoordeling" value="3up" 
                                <?php echo is_filter_active('3up', $f['beoordeling']); ?>
                                class="mr-2 text-primary-blue focus:ring-primary-blue"> 
                            3 sterren & hoger
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary-blue text-white py-2 rounded-md font-bold hover:bg-blue-800 transition duration-150 filter-knop">
                        Filters Toepassen
                    </button>
                    <a href="producten.php" class="block text-center mt-3 text-sm text-gray-500 hover:text-primary-blue transition duration-150 reset-knop">
                        Filters Wissen
                    </a>
                </form>
            </aside>

            <section class="lg:col-span-3 producten-content">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Alle Producten</h2> 
                    <form action="producten.php" method="get" class="flex w-full sm:w-auto zoek-form">
                        <input type="text" name="zoekterm" placeholder="Zoek naar producten..." 
                            value="<?php echo htmlspecialchars($f['zoekterm']); ?>"
                            class="p-2 border border-gray-300 rounded-l-md w-full focus:border-primary-blue focus:ring-primary-blue text-sm">
                        <button type="submit" class="bg-gray-700 text-white p-2 rounded-r-md hover:bg-gray-800 transition duration-150">
                            Zoeken
                        </button>
                    </form>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 product-grid">
                <?php
                    // Binnen de loop de variabele $afbeelding toewijzen.
                    if (!empty($foutmelding)) {
                        echo "<p class='text-red-600 bg-red-100 p-4 rounded-md'>{$foutmelding}</p>";
                    } elseif (!empty($producten)) {
                        foreach($producten as $product) {
                            $afbeelding = !empty($product['hoofd_afbeelding_pad']) 
                            ? htmlspecialchars($product['hoofd_afbeelding_pad']) 
                            : 'afbeeldingen/WEBBAIR_20250812_230805_0000.jpg';
                    ?>
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow duration-300 hover:shadow-xl product-card" 
                             aria-labelledby="product-naam-<?php echo $product['product_id']; ?>">  
                        <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" 
                           aria-label="Bekijk product: <?php echo htmlspecialchars($product['naam_nl']); ?>"
                           class="block w-full h-48 overflow-hidden">
                            <img src="<?php echo $afbeelding; ?>" 
                                alt="Afbeelding van <?php echo htmlspecialchars($product['naam_nl']); ?>" 
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </a>
                        <div class="p-4 product-content">
                            <h3 id="product-naam-<?php echo $product['product_id']; ?>" class="text-lg font-bold text-gray-900 mb-1 product-naam">
                                <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" class="hover:text-primary-blue transition duration-150">
                                    <?php echo htmlspecialchars($product['naam_nl']); ?>
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2 product-beschrijving">
                                <?php echo htmlspecialchars($product['beschrijving_kort_nl'] ?? 'Nog geen korte beschrijving.'); ?>
                            </p>
                            <div class="flex justify-between items-center mt-4 product-info-bottom">
                                <div class="product-prijs-container">
                                    <p class="text-xl font-extrabold text-primary-blue product-prijs">
                                        &euro; <?php echo number_format($product['prijs_excl_btw'], 2, ',', '.'); ?>
                                    </p>
                                </div>
                                <button class="flex items-center bg-green-600 text-white text-sm font-semibold py-2 px-3 rounded-lg hover:bg-green-700 transition duration-150 koop-nu" 
                                        data-product-id="<?php echo $product['product_id']; ?>" 
                                        aria-label="Voeg <?php echo htmlspecialchars($product['naam_nl']); ?> toe aan winkelwagen">
                                    <i class="fas fa-cart-plus mr-2"></i> In Winkelwagen
                                </button>
                            </div>
                        </div>
                    </article>

                <?php
                    } // einde foreach
                } else {
                    // Geen producten gevonden
                    echo "<p class='text-gray-700 bg-white p-6 rounded-xl shadow-lg'>Er zijn geen producten gevonden die voldoen aan uw zoekcriteria of filters. Probeer andere termen of wis uw filters.</p>";
                }
                ?>
                </div>
            </section>
        </section>

    </main>
    
    <footer class="bg-gray-800 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400">
            <p>&copy; 2025 <?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> | 
                <a href="privacy.php" class="hover:text-white transition duration-150">Privacy</a> | 
                <a href="algemene_voorwaarden.php" class="hover:text-white transition duration-150">Algemene Voorwaarden</a> | 
                <a href="contact.php" class="hover:text-white transition duration-150">Contact</a>
            </p>
        </div>
    </footer>

</body>
</html>