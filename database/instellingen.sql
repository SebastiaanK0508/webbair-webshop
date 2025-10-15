CREATE TABLE webshop_instellingen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sleutel VARCHAR(100) NOT NULL UNIQUE, 
    waarde TEXT,                           
    type_data VARCHAR(50) DEFAULT 'tekst', 
    beschrijving VARCHAR(255)              
);

--data hieronder

INSERT INTO webshop_instellingen (sleutel, waarde, type_data, beschrijving) VALUES
('webshop_naam', 'webbair_webshop', 'tekst', 'Officiële naam van de winkel, getoond in headers en titels'),
('slogan', 'Kwaliteit en snelle levering!', 'tekst', 'De korte ondertitel of USP'),
('hoofd_emailadres', 'info@decoolewebshop.nl', 'email', 'Algemeen e-mailadres voor contact'),
('telefoonnummer', '+31 123 456 789', 'tekst', 'Klantenservice telefoonnummer'),
('kvk_nummer', '12345678', 'tekst', 'Kamer van Koophandel nummer voor de footer'),
('btw_nummer', 'NL123456789B01', 'tekst', 'BTW-identificatienummer'),
('verzendkosten_standaard', '6.95', 'decimaal', 'Kosten voor standaard verzending'),
('verzend_gratis_vanaf', '50.00', 'decimaal', 'Vanaf welk bedrag is verzending gratis'),
('kleur_primair', '#007bff', 'kleur', 'De primaire kleur voor knoppen en links (HEX-code)'),
('onderhoudsmodus_aan', '0', 'boolean', 'Zet de webshop in onderhoudsmodus (0=uit, 1=aan)');