-- ============================================================================
-- Biblioteca pentru Toți - Sample Data
-- Date demo pentru testare și demonstrație
-- ============================================================================

-- IMPORTANT: Rulați acest script DUPĂ ce tema este activată și CPT-urile sunt înregistrate
-- Înlocuiți 'wp_' cu prefixul tabelelor din instalarea dumneavoastră WordPress

-- ============================================================================
-- TAXONOMII - Epoci Literare
-- ============================================================================

INSERT INTO wp_terms (name, slug) VALUES
('Epoca Modernă', 'epoca-moderna'),
('Perioada Interbelică', 'perioada-interbelica'),
('Perioada Postbelică', 'perioada-postbelica'),
('Literatura Contemporană', 'literatura-contemporana'),
('Clasicism', 'clasicism'),
('Romantism', 'romantism'),
('Realism', 'realism');

-- Term taxonomy pentru Epoca
INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
SELECT term_id, 'epoca', 
    CASE slug
        WHEN 'epoca-moderna' THEN 'Perioada de formare a literaturii române moderne (1830-1918)'
        WHEN 'perioada-interbelica' THEN 'Epoca de aur a literaturii române (1918-1945)'
        WHEN 'perioada-postbelica' THEN 'Literatura în perioada comunistă (1945-1989)'
        WHEN 'literatura-contemporana' THEN 'Literatura română după 1989'
        WHEN 'clasicism' THEN 'Curentul clasic în literatura universală'
        WHEN 'romantism' THEN 'Curentul romantic european'
        WHEN 'realism' THEN 'Curentul realist în literatură'
    END,
    0, 0
FROM wp_terms 
WHERE slug IN ('epoca-moderna', 'perioada-interbelica', 'perioada-postbelica', 
               'literatura-contemporana', 'clasicism', 'romantism', 'realism');

-- ============================================================================
-- TAXONOMII - Genuri Literare
-- ============================================================================

INSERT INTO wp_terms (name, slug) VALUES
('Roman', 'roman'),
('Nuvelă', 'nuvela'),
('Poezie', 'poezie'),
('Dramaturgie', 'dramaturgie'),
('Eseu', 'eseu'),
('Memorialistică', 'memorialistica'),
('Basm', 'basm'),
('Filozofie', 'filozofie'),
('Critică Literară', 'critica-literara');

-- Term taxonomy pentru Gen
INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
SELECT term_id, 'gen', '', 0, 0
FROM wp_terms 
WHERE slug IN ('roman', 'nuvela', 'poezie', 'dramaturgie', 'eseu', 
               'memorialistica', 'basm', 'filozofie', 'critica-literara');

-- ============================================================================
-- TAXONOMII - Limbi
-- ============================================================================

INSERT INTO wp_terms (name, slug) VALUES
('Română', 'romana'),
('Franceză', 'franceza'),
('Engleză', 'engleza'),
('Germană', 'germana'),
('Rusă', 'rusa'),
('Italiană', 'italiana'),
('Spaniolă', 'spaniola'),
('Latină', 'latina'),
('Greacă', 'greaca');

-- Term taxonomy pentru Limba
INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
SELECT term_id, 'limba', '', 0, 0
FROM wp_terms 
WHERE slug IN ('romana', 'franceza', 'engleza', 'germana', 'rusa', 
               'italiana', 'spaniola', 'latina', 'greaca');

-- ============================================================================
-- TAXONOMII - Autori
-- ============================================================================

INSERT INTO wp_terms (name, slug) VALUES
('Mihai Eminescu', 'mihai-eminescu'),
('Ion Creangă', 'ion-creanga'),
('Ion Luca Caragiale', 'ion-luca-caragiale'),
('Mihail Sadoveanu', 'mihail-sadoveanu'),
('Liviu Rebreanu', 'liviu-rebreanu'),
('George Călinescu', 'george-calinescu'),
('Marin Preda', 'marin-preda'),
('Honoré de Balzac', 'honore-de-balzac'),
('Lev Tolstoi', 'lev-tolstoi'),
('William Shakespeare', 'william-shakespeare'),
('Johann Wolfgang von Goethe', 'johann-wolfgang-von-goethe'),
('Victor Hugo', 'victor-hugo'),
('Charles Dickens', 'charles-dickens'),
('Fiodor Dostoievski', 'fiodor-dostoievski'),
('Anton Cehov', 'anton-cehov'),
('Platon', 'platon'),
('Homer', 'homer'),
('Miguel de Cervantes', 'miguel-de-cervantes'),
('Tudor Arghezi', 'tudor-arghezi'),
('Lucian Blaga', 'lucian-blaga');

-- Term taxonomy pentru Autor
INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
SELECT term_id, 'autor', '', 0, 0
FROM wp_terms 
WHERE slug IN ('mihai-eminescu', 'ion-creanga', 'ion-luca-caragiale', 'mihail-sadoveanu',
               'liviu-rebreanu', 'george-calinescu', 'marin-preda', 'honore-de-balzac',
               'lev-tolstoi', 'william-shakespeare', 'johann-wolfgang-von-goethe',
               'victor-hugo', 'charles-dickens', 'fiodor-dostoievski', 'anton-cehov',
               'platon', 'homer', 'miguel-de-cervantes', 'tudor-arghezi', 'lucian-blaga');

-- ============================================================================
-- TAXONOMII - Tip Eveniment
-- ============================================================================

INSERT INTO wp_terms (name, slug) VALUES
('Apariție Ediție', 'aparitie-editie'),
('Eveniment Istoric', 'eveniment-istoric'),
('Biografie Autor', 'biografie-autor'),
('Premiu Literar', 'premiu-literar'),
('Aniversare', 'aniversare');

-- Term taxonomy pentru Tip Eveniment
INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
SELECT term_id, 'tip_eveniment', '', 0, 0
FROM wp_terms 
WHERE slug IN ('aparitie-editie', 'eveniment-istoric', 'biografie-autor', 
               'premiu-literar', 'aniversare');

-- ============================================================================
-- CĂRȚI - Post entries
-- ============================================================================

-- Inserăm cărțile ca posturi de tip 'carte'
INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, 
                      post_excerpt, post_status, comment_status, ping_status, post_name, 
                      post_type, post_modified, post_modified_gmt) VALUES

-- Carte 1: Poezii - Eminescu
(1, NOW(), UTC_TIMESTAMP(), 
'<p>Volumul cuprinde cele mai reprezentative creații ale celui mai mare poet român, Mihai Eminescu. De la „Luceafărul" la „Scrisoarea III", de la „Floare albastră" la „Mai am un singur dor", această antologie reprezintă esența lirismului românesc.</p>
<p>Eminescu rămâne poetul absolut al limbii române, cel care a dat expresie definitivă sufletului și aspirațiilor naționale, ridicând poezia românească la nivel universal.</p>',
'Poezii', 
'Antologie de poezii reprezentative ale celui mai mare poet român.',
'publish', 'closed', 'closed', 'poezii-eminescu', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 2: Amintiri din copilărie - Creangă
(1, NOW(), UTC_TIMESTAMP(),
'<p>Capodoperă a literaturii române, „Amintiri din copilărie" reconstituie cu un farmec irezistibil universul copilăriei în satul moldovenesc de la mijlocul secolului al XIX-lea.</p>
<p>Humuleștiul natal, școala din Broșteni, Fălticenii, Iașii – toate aceste locuri prind viață în povestirea lui Ion Creangă, devenind simboluri ale unei lumi dispărute dar mereu vii în conștiința românească.</p>',
'Amintiri din copilărie',
'Capodoperă a literaturii române despre copilăria în satul moldovenesc.',
'publish', 'closed', 'closed', 'amintiri-din-copilarie', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 3: O scrisoare pierdută - Caragiale
(1, NOW(), UTC_TIMESTAMP(),
'<p>Comedie în patru acte, „O scrisoare pierdută" este cea mai cunoscută și mai jucată piesă a lui I.L. Caragiale. Satira politică și de moravuri rămâne de o actualitate surprinzătoare.</p>
<p>Personajele – Tipătescu, Zoe, Cațavencu, Dandanache – au devenit arhetipuri ale politicianismului și ale mentalității românești, depășind cu mult cadrul epocii în care au fost create.</p>',
'O scrisoare pierdută',
'Comedie în patru acte, capodoperă a dramaturgiei românești.',
'publish', 'closed', 'closed', 'o-scrisoare-pierduta', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 4: Baltagul - Sadoveanu
(1, NOW(), UTC_TIMESTAMP(),
'<p>Roman de o frumusețe aspră, „Baltagul" este povestea Vitoriei Lipan, care pornește în căutarea soțului ei, Nechifor, plecat cu oile în munți și nepomenit de luni de zile.</p>
<p>Dincolo de intriga polițistă, romanul este o meditație despre iubire, credință și justiție arhaică, despre legile nescrise ale munților și ale sufletului omenesc.</p>',
'Baltagul',
'Roman despre căutarea dreptății în lumea păstorilor montani.',
'publish', 'closed', 'closed', 'baltagul', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 5: Ion - Rebreanu
(1, NOW(), UTC_TIMESTAMP(),
'<p>Primul mare roman realist românesc, „Ion" prezintă drama țăranului ardelean obsedat de pământ, gata să-și sacrifice totul – iubirea, onoarea, viața – pentru a-l dobândi.</p>
<p>Destinul tragic al lui Ion, prins între două femei și două lumi, reprezintă unul dintre cele mai puternice portrete ale sufletului țărănesc din literatura română.</p>',
'Ion',
'Primul mare roman realist românesc despre obsesia pământului.',
'publish', 'closed', 'closed', 'ion', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 6: Enigma Otiliei - Călinescu
(1, NOW(), UTC_TIMESTAMP(),
'<p>Romanul lui George Călinescu portretizează societatea bucureșteană de la începutul secolului XX prin prisma unei povești de dragoste și moștenire.</p>
<p>Felix Sima și Otilia Mărculescu, Costache Giurgiuveanu și Simion Tulea – personaje memorabile care populează un București dispărut dar mereu actual în problemele sale umane fundamentale.</p>',
'Enigma Otiliei',
'Roman balzacian despre societatea bucureșteană de la începutul secolului XX.',
'publish', 'closed', 'closed', 'enigma-otiliei', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 7: Moromeții - Preda
(1, NOW(), UTC_TIMESTAMP(),
'<p>Saga familiei Moromete din Câmpia Dunării reprezintă unul dintre cele mai importante romane ale literaturii române postbelice.</p>
<p>Ilie Moromete, țăranul filozof, și lumea sa – copiii, vecinii, satul Siliștea-Gumești – compun un tablou memorabil al satului românesc în pragul marilor transformări ale secolului XX.</p>',
'Moromeții',
'Saga familiei Moromete, capodoperă a literaturii române postbelice.',
'publish', 'closed', 'closed', 'morometii', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 8: Moș Goriot - Balzac
(1, NOW(), UTC_TIMESTAMP(),
'<p>Unul dintre cele mai cunoscute romane ale lui Balzac, „Moș Goriot" prezintă drama unui bătrân ruinat de dragostea pentru fiicele sale ingrate.</p>
<p>Pensiunea doamnei Vauquer, cu galeria sa de personaje – Rastignac, Vautrin, Victorine – este un microcosmos al societății pariziene din epoca Restaurației.</p>',
'Moș Goriot',
'Roman clasic despre dragostea paternă și corupția societății.',
'publish', 'closed', 'closed', 'mos-goriot', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 9: Război și pace - Tolstoi
(1, NOW(), UTC_TIMESTAMP(),
'<p>Epopeea tolstoiană urmărește destinele mai multor familii aristocratice rusești pe fundalul războaielor napoleoniene.</p>
<p>Prințul Andrei, Natașa Rostova, Pierre Bezuhov – personaje care caută sensul vieții în mijlocul istoriei, într-o frescă grandioasă a societății rusești de la începutul secolului XIX.</p>',
'Război și pace',
'Epopeea lui Tolstoi despre războaiele napoleoniene și căutarea sensului vieții.',
'publish', 'closed', 'closed', 'razboi-si-pace', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 10: Hamlet - Shakespeare
(1, NOW(), UTC_TIMESTAMP(),
'<p>Cea mai celebră tragedie shakespeareană, „Hamlet" explorează temele răzbunării, îndoielii și mortalității prin prisma prințului Danemarcei.</p>
<p>„A fi sau a nu fi" – monologul lui Hamlet a devenit simbolul întrebărilor existențiale fundamentale ale omenirii.</p>',
'Hamlet',
'Cea mai celebră tragedie a lui Shakespeare despre răzbunare și îndoială.',
'publish', 'closed', 'closed', 'hamlet', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 11: Faust - Goethe
(1, NOW(), UTC_TIMESTAMP(),
'<p>Drama filosofică a lui Goethe prezintă povestea doctorului Faust care își vinde sufletul diavolului Mefistofel în schimbul cunoașterii și experienței.</p>
<p>Opera de o viață a lui Goethe, „Faust" reprezintă una dintre cele mai profunde meditații asupra condiției umane din literatura universală.</p>',
'Faust',
'Drama filosofică despre pactul cu diavolul și căutarea cunoașterii.',
'publish', 'closed', 'closed', 'faust', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 12: Mizerabilii - Hugo
(1, NOW(), UTC_TIMESTAMP(),
'<p>Romanul monumental al lui Victor Hugo urmărește destinul lui Jean Valjean, fost ocnaș care luptă pentru răscumpărare într-o societate nedreaptă.</p>
<p>Cosette, Marius, Javert, Gavroche – personaje care au devenit simboluri ale luptei pentru dreptate și demnitate umană.</p>',
'Mizerabilii',
'Romanul monumental al lui Hugo despre răscumpărare și dreptate socială.',
'publish', 'closed', 'closed', 'mizerabilii', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 13: Oliver Twist - Dickens
(1, NOW(), UTC_TIMESTAMP(),
'<p>Romanul lui Dickens prezintă peripețiile micului orfan Oliver în lumea criminală a Londrei victoriene.</p>
<p>Fagin, Bill Sikes, Artful Dodger – o galerie de personaje memorabile în critica socială a condițiilor de viață din Anglia industrială.</p>',
'Oliver Twist',
'Roman despre orfanul Oliver și lumea criminală a Londrei victoriene.',
'publish', 'closed', 'closed', 'oliver-twist', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 14: Crimă și pedeapsă - Dostoievski
(1, NOW(), UTC_TIMESTAMP(),
'<p>Romanul psihologic al lui Dostoievski urmărește chinurile lui Raskolnikov după ce comite o crimă pe care o considera justificată filosofic.</p>
<p>O explorare profundă a conștiinței vinovate și a posibilității răscumpărării prin suferință și iubire.</p>',
'Crimă și pedeapsă',
'Roman psihologic despre crimă, vinovăție și răscumpărare.',
'publish', 'closed', 'closed', 'crima-si-pedeapsa', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 15: Livada de vișini - Cehov
(1, NOW(), UTC_TIMESTAMP(),
'<p>Ultima piesă a lui Cehov prezintă declinul unei familii aristocratice rusești care pierde moșia strămoșească.</p>
<p>O meditație elegiacă despre trecerea timpului, schimbarea socială și incapacitatea de adaptare la o lume nouă.</p>',
'Livada de vișini',
'Piesă despre declinul aristocrației rusești și trecerea timpului.',
'publish', 'closed', 'closed', 'livada-de-visini', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 16: Republica - Platon
(1, NOW(), UTC_TIMESTAMP(),
'<p>Dialogul fundamental al lui Platon explorează natura dreptății și organizarea statului ideal.</p>
<p>Celebra alegorie a peșterii, teoria formelor, concepția despre suflet – idei care au modelat gândirea occidentală timp de două milenii.</p>',
'Republica',
'Dialogul lui Platon despre dreptate și statul ideal.',
'publish', 'closed', 'closed', 'republica', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 17: Iliada - Homer
(1, NOW(), UTC_TIMESTAMP(),
'<p>Epopeea homerică prezintă episoade din ultimul an al războiului troian, cu Ahile și Hector în centrul acțiunii.</p>
<p>Primul mare text al literaturii occidentale, „Iliada" a devenit modelul absolut al poeziei epice.</p>',
'Iliada',
'Epopeea homerică despre războiul troian.',
'publish', 'closed', 'closed', 'iliada', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 18: Don Quijote - Cervantes
(1, NOW(), UTC_TIMESTAMP(),
'<p>Primul roman modern european, „Don Quijote" prezintă aventurile cavalerului din La Mancha și ale credinciosului său scutier Sancho Panza.</p>
<p>O satiră a romanelor cavalerești care a devenit o meditație profundă asupra realității, iluziei și naturii umane.</p>',
'Don Quijote',
'Primul roman modern european despre cavalerul idealist.',
'publish', 'closed', 'closed', 'don-quijote', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 19: Cuvinte potrivite - Arghezi
(1, NOW(), UTC_TIMESTAMP(),
'<p>Volumul de debut al lui Tudor Arghezi a revoluționat poezia românească prin introducerea unei noi estetici și a unui nou limbaj poetic.</p>
<p>De la „Testament" la „Flori de mucigai", poezia argheziană explorează frumusețea urâtului și transformă limba română într-un instrument artistic de o expresivitate inegalată.</p>',
'Cuvinte potrivite',
'Volumul de debut care a revoluționat poezia românească.',
'publish', 'closed', 'closed', 'cuvinte-potrivite', 'carte', NOW(), UTC_TIMESTAMP()),

-- Carte 20: Poemele luminii - Blaga
(1, NOW(), UTC_TIMESTAMP(),
'<p>Volumul de debut al lui Lucian Blaga marchează intrarea expresionismului în poezia românească.</p>
<p>Poezia metafizică a lui Blaga, cu misterele ei despre cunoaștere, iubire și transcendență, a deschis noi orizonturi în lirica românească.</p>',
'Poemele luminii',
'Volumul de debut expresionist al lui Lucian Blaga.',
'publish', 'closed', 'closed', 'poemele-luminii', 'carte', NOW(), UTC_TIMESTAMP());

-- ============================================================================
-- POST META - Detalii cărți (ACF fields)
-- ============================================================================

-- Obținem ID-urile posturilor pentru a adăuga meta
-- (În practică, acestea trebuie obținute dinamic după inserare)

-- Exemplu de structură pentru meta:
-- INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
-- (POST_ID, 'nr_bpt', '1'),
-- (POST_ID, 'an_scriere', '1883'),
-- (POST_ID, 'an_publicare_bpt', '1896'),
-- (POST_ID, 'traducator', ''),
-- (POST_ID, 'carte_featured', '1'),
-- (POST_ID, 'in_domeniu_public', '1'),
-- (POST_ID, 'citat_reprezentativ', 'Citatul reprezentativ...');

-- ============================================================================
-- EVENIMENTE
-- ============================================================================

INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title,
                      post_excerpt, post_status, comment_status, ping_status, post_name,
                      post_type, post_modified, post_modified_gmt) VALUES

-- Eveniment 1: Înființarea colecției
(1, NOW(), UTC_TIMESTAMP(),
'<p>În anul 1895, editura Minerva din București lansează colecția „Biblioteca pentru Toți", care va deveni cea mai longevivă și importantă colecție de carte din România.</p>
<p>Ideea aparține lui Vasile G. Morțun, care visa la o bibliotecă accesibilă tuturor cititorilor români, cu volume ieftine dar de calitate.</p>',
'Înființarea colecției „Biblioteca pentru Toți"',
'Lansarea celei mai importante colecții de carte din România.',
'publish', 'closed', 'closed', 'infiintarea-colectiei-bpt', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 2: Primul volum
(1, NOW(), UTC_TIMESTAMP(),
'<p>Volumul cu numărul 1 al colecției „Biblioteca pentru Toți" apare în 1895, marcând începutul unei aventuri editoriale care va dura peste un secol.</p>',
'Apariția primului volum BPT',
'Primul volum al colecției vede lumina tiparului.',
'publish', 'closed', 'closed', 'primul-volum-bpt', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 3: Trecerea la Editura pentru Literatură
(1, NOW(), UTC_TIMESTAMP(),
'<p>În perioada comunistă, colecția „Biblioteca pentru Toți" trece în patrimoniul Editurii pentru Literatură, continuând să apară în tiraje impresionante.</p>',
'BPT la Editura pentru Literatură',
'Colecția continuă sub noua editură de stat.',
'publish', 'closed', 'closed', 'bpt-editura-literatura', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 4: Volumul 1000
(1, NOW(), UTC_TIMESTAMP(),
'<p>Colecția „Biblioteca pentru Toți" atinge borna simbolică de 1000 de volume, confirmându-și statutul de cea mai importantă colecție de carte din România.</p>',
'BPT atinge volumul 1000',
'O bornă istorică pentru colecția românească.',
'publish', 'closed', 'closed', 'bpt-volumul-1000', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 5: Reluarea colecției post-1989
(1, NOW(), UTC_TIMESTAMP(),
'<p>După 1989, colecția „Biblioteca pentru Toți" continuă să apară, adaptându-se noilor realități ale pieței de carte din România.</p>',
'BPT după Revoluție',
'Colecția se adaptează noilor vremuri.',
'publish', 'closed', 'closed', 'bpt-dupa-revolutie', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 6: Nașterea lui Eminescu
(1, NOW(), UTC_TIMESTAMP(),
'<p>La 15 ianuarie 1850, la Botoșani, se naște Mihail Eminescu, cel care va deveni cel mai mare poet al limbii române.</p>',
'Nașterea lui Mihai Eminescu',
'Nașterea poetului național al României.',
'publish', 'closed', 'closed', 'nasterea-eminescu', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 7: Publicarea Luceafărului
(1, NOW(), UTC_TIMESTAMP(),
'<p>În 1883, în revista „Convorbiri literare", apare „Luceafărul", capodopera lui Eminescu și vârful poeziei românești.</p>',
'Publicarea „Luceafărului"',
'Apariția capodoperei eminesciene.',
'publish', 'closed', 'closed', 'publicarea-luceafarul', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 8: Premiera Scrisorii pierdute
(1, NOW(), UTC_TIMESTAMP(),
'<p>În 1884, la Teatrul Național din București, are loc premiera comediei „O scrisoare pierdută" de I.L. Caragiale.</p>',
'Premiera „O scrisoare pierdută"',
'Prima reprezentație a capodoperei lui Caragiale.',
'publish', 'closed', 'closed', 'premiera-scrisoare-pierduta', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 9: Publicarea lui Ion
(1, NOW(), UTC_TIMESTAMP(),
'<p>În 1920 apare romanul „Ion" de Liviu Rebreanu, primul mare roman realist al literaturii române.</p>',
'Apariția romanului „Ion"',
'Publicarea primului mare roman realist românesc.',
'publish', 'closed', 'closed', 'aparitia-ion', 'eveniment', NOW(), UTC_TIMESTAMP()),

-- Eveniment 10: Premiul Nobel pentru Literatură - declarat în România
(1, NOW(), UTC_TIMESTAMP(),
'<p>România așteaptă încă Premiul Nobel pentru Literatură, deși scriitori precum Mircea Eliade, Emil Cioran sau Eugen Ionescu au fost considerați candidați serioși.</p>',
'Scriitori români și Nobelul',
'Aspirații românești la prestigiosul premiu literar.',
'publish', 'closed', 'closed', 'scriitori-romani-nobel', 'eveniment', NOW(), UTC_TIMESTAMP());

-- ============================================================================
-- ATRIBUIRI TAXONOMII (term_relationships)
-- ============================================================================

-- Notă: Aceste inserări necesită ID-urile efective ale posturilor și termenilor
-- care trebuie obținute dinamic după inserarea datelor de mai sus

-- Exemplu de structură:
-- INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES
-- (POST_ID, TERM_TAXONOMY_ID, 0);

-- ============================================================================
-- ACTUALIZARE CONTOARE TAXONOMII
-- ============================================================================

-- După inserarea relațiilor, actualizați contoarele:
-- UPDATE wp_term_taxonomy tt
-- SET count = (
--     SELECT COUNT(*) FROM wp_term_relationships tr
--     WHERE tr.term_taxonomy_id = tt.term_taxonomy_id
-- );

-- ============================================================================
-- NOTE PENTRU IMPLEMENTARE
-- ============================================================================

-- 1. Acest script este un template. În practică, trebuie:
--    - Să înlocuiți 'wp_' cu prefixul tabelelor din instalarea dumneavoastră
--    - Să obțineți ID-urile posturilor și termenilor după inserare pentru relații
--    - Să adăugați meta pentru câmpurile ACF

-- 2. Pentru import complet, recomandăm:
--    - Folosiți WordPress Importer sau WP All Import
--    - Sau creați un script PHP personalizat care folosește funcțiile WP:
--      wp_insert_post(), wp_set_post_terms(), update_post_meta()

-- 3. Imagini:
--    - Coperțile cărților trebuie încărcate separat în Media Library
--    - Apoi setate ca Featured Image pentru fiecare carte

-- 4. ACF:
--    - Asigurați-vă că ACF Pro este activ
--    - Câmpurile se vor sincroniza automat din /acf-json/

-- ============================================================================
-- END OF SAMPLE DATA
-- ============================================================================
