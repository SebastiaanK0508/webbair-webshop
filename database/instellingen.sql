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

INSERT INTO webshop_instellingen (sleutel, waarde, type_data, beschrijving) VALUES
('over_webshop', 'Welkom bij Webbair Webshop, uw specialist in hoogwaardige digitale en fysieke producten. Onze missie is simpel: de beste kwaliteit producten leveren met een service die u nergens anders vindt. Wij geloven dat winkelen online niet onpersoonlijk hoeft te zijn. Daarom staan wij klaar om u persoonlijk te adviseren en te helpen bij het maken van de perfecte keuze. Bij Webbair combineren we innovatie met betrouwbaarheid, zodat u altijd de beste koopervaring heeft. Waarom kiezen voor Webbair Webshop? 1. Geselecteerde Kwaliteit: Al onze producten worden zorgvuldig geselecteerd op duurzaamheid, functionaliteit en een eerlijke prijs. 2. Klantgerichte Service: Wij streven naar 100% tevredenheid. Heeft u een vraag? Ons team staat binnen 24 uur voor u klaar. 3. Innovatie & Betrouwbaarheid: We houden de nieuwste trends bij, zodat u altijd toegang heeft tot de meest moderne en betrouwbare artikelen. Wij nodigen u van harte uit om onze collectie te ontdekken en deel uit te maken van de Webbair Webshop familie!', 'tekst', 'Uitgebreide tekst die bezoekers informeert over de geschiedenis, missie en visie van de Webbair Webshop.');
