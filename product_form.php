<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Product Toevoegen (Uitgebreid)</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 25px; }
        fieldset { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        legend h3 { margin: 0; padding: 0 10px; font-size: 1.1em; font-weight: bold; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .checkbox-group { display: flex; align-items: center; gap: 20px; }
        .checkbox-group div { display: flex; align-items: center; }
        .checkbox-group input[type="checkbox"] { width: auto; margin-right: 5px; }
        .checkbox-group label { margin: 0; font-weight: normal; }
        button { background-color: #5cb85c; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        button:hover { background-color: #4cae4c; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nieuw Product Toevoegen (Uitgebreid)</h1>
        
        <form action="product_process.php" method="POST">
            
            <fieldset>
                <legend><h3>Identificatie & Beschrijving</h3></legend>
                <div class="form-group">
                    <label for="naam_nl">Productnaam (NL):</label>
                    <input type="text" id="naam_nl" name="naam_nl" required>
                </div>
                <div class="form-group">
                    <label for="beschrijving_kort_nl">Korte Beschrijving:</label>
                    <textarea id="beschrijving_kort_nl" name="beschrijving_kort_nl" placeholder="Korte tekst voor productlijsten/overzichten"></textarea>
                </div>
                <div class="form-group">
                    <label for="beschrijving_lang_nl">Uitgebreide Beschrijving:</label>
                    <textarea id="beschrijving_lang_nl" name="beschrijving_lang_nl"></textarea>
                </div>
                </fieldset>

            <fieldset>
                <legend><h3>Prijzen & Logistiek</h3></legend>
                <div class="form-group">
                    <label for="sku">SKU:</label>
                    <input type="text" id="sku" name="sku" required>
                </div>
                <div class="form-group">
                    <label for="ean">EAN:</label>
                    <input type="text" id="ean" name="ean" placeholder="Barcode (optioneel)">
                </div>
                <div class="form-group">
                    <label for="prijs_excl_btw">Prijs (Excl. BTW):</label>
                    <input type="number" id="prijs_excl_btw" name="prijs_excl_btw" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="btw_tarief_id">BTW Tarief ID:</label>
                    <input type="number" id="btw_tarief_id" name="btw_tarief_id" required value="1" min="1">
                </div>
                <div class="form-group">
                    <label for="gewicht_gram">Gewicht (gram):</label>
                    <input type="number" id="gewicht_gram" name="gewicht_gram" placeholder="Voor verzendkosten">
                </div>
            </fieldset>

            <fieldset>
                <legend><h3>Voorraad & Beschikbaarheid</h3></legend>
                <div class="form-group">
                    <label for="voorraad_aantal">Voorraad Aantal:</label>
                    <input type="number" id="voorraad_aantal" name="voorraad_aantal" required>
                </div>
                <div class="form-group">
                    <label for="voorraad_laag_limiet">Lage Voorraad Limiet:</label>
                    <input type="number" id="voorraad_laag_limiet" name="voorraad_laag_limiet" value="5">
                </div>
                
                <div class="form-group checkbox-group">
                    <div>
                        <input type="checkbox" id="is_zichtbaar" name="is_zichtbaar" value="1" checked>
                        <label for="is_zichtbaar">Zichtbaar op Website</label>
                    </div>
                    <div>
                        <input type="checkbox" id="is_uitverkocht" name="is_uitverkocht" value="1">
                        <label for="is_uitverkocht">Handmatig Uitverkocht</label>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend><h3>Categorisatie & Media</h3></legend>
                <div class="form-group">
                    <label for="hoofd_categorie_id">Hoofdcategorie ID:</label>
                    <input type="number" id="hoofd_categorie_id" name="hoofd_categorie_id" placeholder="ID uit categorieen tabel (optioneel)">
                </div>
                <div class="form-group">
                    <label for="fabrikant_merk_id">Merk ID:</label>
                    <input type="number" id="fabrikant_merk_id" name="fabrikant_merk_id" placeholder="ID uit merken tabel (optioneel)">
                </div>
                <div class="form-group">
                    <label for="hoofd_afbeelding_pad">Hoofdafbeelding Pad/URL:</label>
                    <input type="text" id="hoofd_afbeelding_pad" name="hoofd_afbeelding_pad">
                </div>
                <div class="form-group">
                    <label for="video_url">Video URL:</label>
                    <input type="text" id="video_url" name="video_url">
                </div>
            </fieldset>
            
            <fieldset>
                <legend><h3>SEO</h3></legend>
                <div class="form-group">
                    <label for="meta_titel_nl">Meta Titel (max 70):</label>
                    <input type="text" id="meta_titel_nl" name="meta_titel_nl" maxlength="70">
                </div>
                <div class="form-group">
                    <label for="meta_beschrijving_nl">Meta Beschrijving (max 160):</label>
                    <textarea id="meta_beschrijving_nl" name="meta_beschrijving_nl" maxlength="160"></textarea>
                </div>
            </fieldset>

            <button type="submit">Product Opslaan</button>
        </form>
    </div>
</body>
</html>