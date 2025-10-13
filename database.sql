-- CREATE DATABASE webshop ; 
-- USE webshop ;
-- up to date!
CREATE TABLE btw_tarieven (
    btw_tarief_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tarief_naam VARCHAR(50) NOT NULL,
    percentage DECIMAL(4, 2) NOT NULL 
);
INSERT INTO btw_tarieven (tarief_naam, percentage) VALUES ('Hoog tarief', 21.00);
INSERT INTO btw_tarieven (tarief_naam, percentage) VALUES ('Laag tarief', 9.00);
INSERT INTO btw_tarieven (tarief_naam, percentage) VALUES ('Geen btw', 0.00);
CREATE TABLE categorieen (
    categorie_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100) NOT NULL
);
CREATE TABLE merken (
    merk_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100) NOT NULL
);
INSERT INTO merken (naam) VALUES ('Samsung');
INSERT INTO merken (naam) VALUES ('Apple');
INSERT INTO merken (naam) VALUES ('Sony');
INSERT INTO merken (naam) VALUES ('Dell');
INSERT INTO merken (naam) VALUES ('HP');

INSERT INTO categorieen (naam) VALUES ('Algemeen');
CREATE TABLE producten (
    product_id          INT             NOT NULL AUTO_INCREMENT,
    sku                 VARCHAR(50)     NOT NULL UNIQUE,       
    ean                 VARCHAR(13)     NULL UNIQUE,            
    naam_nl             VARCHAR(255)    NOT NULL,               
    slug_nl             VARCHAR(255)    NOT NULL UNIQUE,        
    beschrijving_kort_nl TEXT           NULL,                   
    beschrijving_lang_nl TEXT           NULL,                   
    prijs_excl_btw      DECIMAL(10, 2)  NOT NULL,               
    btw_tarief_id       INT             NOT NULL,               
    gewicht_gram        INT             NULL,                   
    voorraad_aantal     INT             NOT NULL DEFAULT 0,     
    voorraad_laag_limiet INT            NOT NULL DEFAULT 5,     
    is_zichtbaar        BOOLEAN         NOT NULL DEFAULT TRUE,  
    is_uitverkocht      BOOLEAN         NOT NULL DEFAULT FALSE, 
    datum_laatste_aanvulling DATE       NULL,                   
    hoofd_categorie_id  INT             NULL,                  
    fabrikant_merk_id   INT             NULL,                   
    hoofd_afbeelding_pad VARCHAR(255)   NULL,                   
    video_url           VARCHAR(255)    NULL,                   
    meta_titel_nl       VARCHAR(70)     NULL,                  
    meta_beschrijving_nl VARCHAR(160)   NULL,                   
    datum_toegevoegd    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    datum_gewijzigd     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (product_id),
    FOREIGN KEY (btw_tarief_id) REFERENCES btw_tarieven(btw_tarief_id),
    FOREIGN KEY (hoofd_categorie_id) REFERENCES categorieen(categorie_id),
    FOREIGN KEY (fabrikant_merk_id) REFERENCES merken(merk_id)
);
CREATE TABLE product_opties (
    optie_id            INT             NOT NULL AUTO_INCREMENT,
    product_id          INT             NOT NULL,
    variant_naam        VARCHAR(100)    NOT NULL,               
    variant_sku         VARCHAR(50)     NOT NULL UNIQUE,        
    prijs_toeslag       DECIMAL(10, 2)  NOT NULL DEFAULT 0.00,  
    voorraad_variant    INT             NOT NULL DEFAULT 0,
    
    PRIMARY KEY (optie_id),
    FOREIGN KEY (product_id) REFERENCES producten(product_id) ON DELETE CASCADE
);
CREATE TABLE product_afbeeldingen (
    afbeelding_id       INT             NOT NULL AUTO_INCREMENT,
    product_id          INT             NOT NULL,
    pad                 VARCHAR(255)    NOT NULL,
    volgorde            INT             NOT NULL DEFAULT 0,    
    
    PRIMARY KEY (afbeelding_id),
    FOREIGN KEY (product_id) REFERENCES producten(product_id) ON DELETE CASCADE
);
CREATE TABLE product_attributen (
    attribuut_id        INT             NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id          INT             NOT NULL,
    sleutel_nl          VARCHAR(100)    NOT NULL,
    waarde_nl           VARCHAR(255)    NOT NULL,
    
    FOREIGN KEY (product_id) REFERENCES producten(product_id) ON DELETE CASCADE
); --chromebook moet nog!