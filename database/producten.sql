USE webshop; 
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id, hoofd_afbeelding_pad, meta_titel_nl, meta_beschrijving_nl
) VALUES (
    'LT-D-XPS13', NULL, 'Dell XPS 13 Ultrabook', 'dell-xps-13-ultrabook', 
    'Krachtige en compacte 13-inch laptop met lange batterijduur.', 
    'De Dell XPS 13 is de perfecte balans tussen draagbaarheid en prestaties. Uitgerust met de nieuwste Intel-processor en een InfinityEdge-display.', 
    1199.99, 1, 1200, 45, 1, 4, '/assets/images/dell-xps13.jpg', 
    'Koop Dell XPS 13 - Snelle levering', 'De beste prijs voor de Dell XPS 13. Bekijk specificaties en bestel direct online.'
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id, hoofd_afbeelding_pad
) VALUES (
    'SM-A-P15PRO', '8710000000001', 'Apple iPhone 15 Pro', 'apple-iphone-15-pro', 
    'Flagship smartphone met titanium behuizing en A17 Bionic chip.', 
    'Ervaar de revolutie van mobiele fotografie en gaming met de Apple iPhone 15 Pro. Voorzien van ProMotion-display en geavanceerd camerasysteem.', 
    1099.00, 1, 187, 80, 1, 2, '/assets/images/iphone-15-pro.jpg'
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id, hoofd_afbeelding_pad, is_uitverkocht
) VALUES (
    'AC-S-WH1000', NULL, 'Sony WH-1000XM5 Noise Cancelling', 'sony-wh-1000xm5-koptelefoon', 
    'Industrie-leidende noise cancelling koptelefoon met superieur comfort.', 
    'De Sony WH-1000XM5 biedt de ultieme luisterervaring met HD Noise Cancelling Processor QN1. 30 uur batterijduur en snelladen.', 
    289.25, 1, 250, 0, 1, 3, '/assets/images/sony-xm5.jpg', TRUE
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id, hoofd_afbeelding_pad
) VALUES (
    'PC-SM-324KUHD', '8710000000004', 'Samsung 32 inch 4K UHD Monitor', 'samsung-32-inch-4k-monitor', 
    'Scherm met haarscherpe 4K resolutie en slank design.', 
    'Perfect voor grafisch werk en gaming. Met HDR10-ondersteuning en USB-C connectiviteit.', 
    420.00, 1, 6500, 22, 1, 1, '/assets/images/samsung-4k-monitor.jpg'
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id, voorraad_laag_limiet
) VALUES (
    'ACC-HP-WBC720', NULL, 'HP Essential Webcam 720p', 'hp-essential-webcam-720p', 
    'Eenvoudige plug-and-play webcam voor dagelijks gebruik.', 
    '720p resolutie, ingebouwde microfoon en universele clip.', 
    24.75, 1, 150, 4, 1, 5, 5
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id
) VALUES (
    'ACC-UBC30W', '8710000000006', 'Universele USB-C Oplader 30W', 'universele-usb-c-oplader-30w', 
    'Snellader voor al uw USB-C apparaten, Power Delivery.', 
    'Compacte en krachtige 30W oplader. Geschikt voor smartphones, tablets en kleine laptops.', 
    16.50, 1, 100, 150, 1
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id
) VALUES (
    'TAB-SM-T900', NULL, 'Samsung Galaxy Tab S9', 'samsung-galaxy-tab-s9', 
    'Premium Android tablet met AMOLED-scherm en S Pen.', 
    'De perfecte metgezel voor werk en entertainment. Water- en stofbestendig.', 
    649.00, 1, 499, 30, 1, 1
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id
) VALUES (
    'E-R-BASIC', '8710000000008', 'Basis E-reader 6 inch', 'basis-e-reader-6-inch', 
    'Comfortabel lezen met ingebouwde verlichting.', 
    'Ontspiegelde schermtechnologie, wekenlange batterijduur.', 
    82.64, 2, 170, 60, 1
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id
) VALUES (
    'ACC-D-GM901', NULL, 'Dell Alienware Gaming Muis', 'dell-alienware-gaming-muis', 
    'Ergonomische gaming muis met programmeerbare knoppen.', 
    'Hoge precisie sensor, verstelbaar gewichtssysteem en RGB-verlichting.', 
    41.32, 1, 130, 90, 1, 4
);
INSERT INTO producten (
    sku, ean, naam_nl, slug_nl, beschrijving_kort_nl, beschrijving_lang_nl, 
    prijs_excl_btw, btw_tarief_id, gewicht_gram, voorraad_aantal, hoofd_categorie_id, 
    fabrikant_merk_id
) VALUES (
    'TV-S-STICK', '8710000000010', 'Sony 4K Streaming Stick', 'sony-4k-streaming-stick', 
    'Maak van elke tv een smart-tv met 4K HDR ondersteuning.', 
    'Eenvoudige installatie, toegang tot alle populaire streamingdiensten.', 
    57.85, 1, 50, 110, 1, 3
);