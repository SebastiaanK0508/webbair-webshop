<?php
include 'webshop_beheer.php'; 
$winkel_data = getShopData($pdo);
include 'get_products.php';
$producten = haalNieuweProductenOp($pdo)['producten'];
$count = 0; 
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($winkel_data['webshop_naam']); ?> - Over</title>
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
    <main>
        <section class="over-section">
            
            <div class="container">
                <h2>Over <?php echo htmlspecialchars($winkel_data['webshop_naam']); ?></h2>
                <p><?php echo htmlspecialchars($winkel_data['slogan']); ?></p>
            </div>
            <div class="container">
                <p><?php echo htmlspecialchars($winkel_data['over_webshop']); ?></p>
            </div>    
        </section>
    </main>
</body>
</html>