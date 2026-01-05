# Biblioteca pentru Toți - WordPress Theme

Un thema WordPress dedicat arhivei digitale a colecției „Biblioteca pentru Toți", cea mai longevivă colecție de carte din România.

![Biblioteca pentru Toți](screenshot.png)

## 🎯 Despre proiect

Această temă WordPress oferă o experiență de navigare elegantă și funcțională pentru arhiva colecției „Biblioteca pentru Toți", permițând utilizatorilor să exploreze:

- **Cărți** - Catalog complet cu informații despre fiecare volum din colecție
- **Autori** - Galerie de autori cu biografii și opere
- **Epoci literare** - Navigare cronologică prin perioade literare
- **Cronologie** - Timeline interactiv al evenimentelor importante
- **Gen literar** - Filtrare după gen (roman, poezie, dramă, etc.)

## ✨ Funcționalități

### Frontend
- Design responsive (mobile-first)
- Filtrare AJAX în timp real
- Autocomplete pentru căutare autori
- Timeline interactiv cu animații GSAP
- Statistici animate
- Mod vizualizare grid/listă
- Navigare cu breadcrumbs
- Căutare avansată cu multiple criterii

### Backend
- Custom Post Types: Carte, Eveniment
- Taxonomii: Epoca, Gen, Limba, Autor, Tip Eveniment
- Integrare ACF Pro pentru câmpuri personalizate
- REST API endpoints pentru integrări externe
- Customizer pentru personalizare temă

## 📋 Cerințe

- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+ sau MariaDB 10.3+
- [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/) (opțional, dar recomandat)

### Dependențe externe (incluse via CDN)
- [GSAP](https://greensock.com/gsap/) - Animații timeline
- [ScrollTrigger](https://greensock.com/scrolltrigger/) - Animații la scroll

## 🚀 Instalare

### Metoda 1: Upload ZIP

1. Descarcă arhiva `.zip` a temei
2. În WordPress, navighează la **Aspect → Teme → Adaugă nou**
3. Click pe **Încarcă temă** și selectează fișierul ZIP
4. Activează tema

### Metoda 2: FTP/SFTP

1. Încarcă folderul `biblioteca-pentru-toti` în `/wp-content/themes/`
2. În WordPress, navighează la **Aspect → Teme**
3. Activează tema „Biblioteca pentru Toți"

### După activare

1. **Instalează ACF Pro** (dacă nu este deja instalat)
   - Câmpurile personalizate se vor sincroniza automat din `/acf-json/`

2. **Configurează Customizer**
   - Navighează la **Aspect → Personalizare**
   - Completează secțiunile: Hero, Statistici, Cronologie, Footer

3. **Creează paginile**
   - Creează o pagină „Acasă" cu template „Homepage"
   - Creează o pagină „Cronologie" cu template „Cronologie"
   - Setează „Acasă" ca pagină principală în **Setări → Citire**

4. **Importă date demo** (opțional)
   - Importă fișierul `sample-data.sql` pentru date de test

## 📁 Structura fișierelor

```
biblioteca-pentru-toti/
├── assets/
│   ├── css/           # CSS compilat
│   ├── scss/          # Surse SCSS
│   ├── js/            # JavaScript
│   │   ├── main.js    # Funcționalități principale
│   │   ├── filters.js # Filtrare AJAX
│   │   └── timeline.js# Animații timeline
│   ├── images/        # Imagini temă
│   └── fonts/         # Fonturi locale
├── inc/
│   ├── custom-post-types.php  # CPT: Carte, Eveniment
│   ├── taxonomies.php         # Taxonomii personalizate
│   ├── enqueue-scripts.php    # Înregistrare assets
│   ├── customizer.php         # Setări Customizer
│   ├── template-functions.php # Funcții helper
│   ├── ajax-handlers.php      # Handlere AJAX
│   └── acf-fields.php         # Definiții câmpuri ACF
├── template-parts/
│   ├── hero.php           # Secțiunea hero
│   ├── card-carte.php     # Card carte
│   ├── card-articol.php   # Card articol
│   ├── filters-carti.php  # Interfața de filtrare
│   ├── timeline-item.php  # Element timeline
│   ├── epoch-grid.php     # Grid epoci
│   └── stats-counter.php  # Contor statistici
├── templates/
│   ├── template-homepage.php   # Template pagină acasă
│   └── template-cronologie.php # Template cronologie
├── acf-json/          # Sincronizare câmpuri ACF
├── languages/         # Fișiere traducere
├── style.css          # Stiluri principale
├── functions.php      # Funcții temă
├── header.php         # Header
├── footer.php         # Footer
├── single-carte.php   # Pagină carte individuală
├── single-eveniment.php # Pagină eveniment individual
├── archive-carte.php  # Arhivă cărți
├── taxonomy-epoca.php # Arhivă epocă
├── taxonomy-autor.php # Arhivă autor
├── search.php         # Rezultate căutare
├── 404.php            # Pagină eroare
└── README.md          # Acest fișier
```

## 🎨 Personalizare

### Customizer

Accesează **Aspect → Personalizare** pentru a modifica:

- **Hero**: Titlu, subtitlu, imagine fundal, CTA
- **Statistici**: Numere și etichete pentru contoare
- **Cronologie**: Titlu secțiune, descriere
- **Footer**: Text copyright, linkuri sociale

### Culori epoci

Fiecare epocă literară poate avea o culoare asociată (setată în taxonomie):
- Epoca Modernă: `#1e3a5f` (albastru închis)
- Interbelică: `#8b4513` (maro)
- Postbelică: `#2f4f4f` (gri închis)
- Contemporană: `#4a5568` (gri)

### CSS personalizat

Adaugă CSS personalizat în **Aspect → Personalizare → CSS adițional** sau creează un child theme.

## 🔌 Hooks și filtre

### Acțiuni

```php
// După header-ul paginii de carte
do_action('bpt_after_carte_header');

// Înainte de footer
do_action('bpt_before_footer');
```

### Filtre

```php
// Modifică numărul de cărți per pagină
add_filter('bpt_books_per_page', function($num) {
    return 24;
});

// Modifică query-ul pentru cărți
add_filter('bpt_books_query_args', function($args) {
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = 'nr_bpt';
    return $args;
});

// Personalizează placeholder-ul pentru copertă lipsă
add_filter('bpt_default_cover_image', function($url) {
    return get_stylesheet_directory_uri() . '/images/my-placeholder.jpg';
});
```

## 🌐 REST API

Tema expune următoarele endpoint-uri:

### GET /wp-json/bpt/v1/books

Returnează lista de cărți cu filtrare.

**Parametri:**
- `epoca` - ID taxonomie epocă
- `gen` - ID taxonomie gen
- `limba` - ID taxonomie limbă
- `autor` - ID taxonomie autor
- `search` - Termen de căutare
- `per_page` - Rezultate per pagină (default: 12)
- `page` - Numărul paginii

### GET /wp-json/bpt/v1/stats

Returnează statistici colecție (număr cărți, autori, etc.)

## 🔧 Dezvoltare

### Compilare SCSS

```bash
# Instalează dependențe
npm install

# Compilează SCSS
npm run build

# Watch mode
npm run watch
```

### Structura SCSS

```
assets/scss/
├── _variables.scss    # Variabile (culori, fonturi, spacing)
├── _mixins.scss       # Mixins (responsive, etc.)
├── _base.scss         # Stiluri de bază
├── _typography.scss   # Tipografie
├── _layout.scss       # Layout general
├── _components.scss   # Componente UI
├── _cards.scss        # Stiluri carduri
├── _timeline.scss     # Stiluri timeline
├── _filters.scss      # Stiluri filtre
└── style.scss         # Fișier principal
```

## 🐛 Depanare

### Cărțile nu apar
- Verifică dacă CPT „carte" este înregistrat corect
- Verifică permalink-urile (**Setări → Permalink** → Salvează)

### Filtrele AJAX nu funcționează
- Verifică consola browser pentru erori JS
- Asigură-te că `bpt_ajax_object` este definit în pagină
- Verifică că nonce-ul este valid

### Câmpurile ACF nu apar
- Verifică dacă ACF Pro este instalat și activat
- Verifică dacă fișierele din `/acf-json/` sunt prezente
- Sincronizează câmpurile din **ACF → Sincronizare**

### Timeline-ul nu se animă
- Verifică dacă GSAP și ScrollTrigger sunt încărcate
- Verifică consola pentru erori JavaScript
- Asigură-te că elementele `.timeline-item` există în pagină

## 📝 Changelog

### 1.0.0 (2026-01-05)
- Lansare inițială
- Custom Post Types: Carte, Eveniment
- Taxonomii: Epoca, Gen, Limba, Autor, Tip Eveniment
- Template-uri complete pentru arhive și single
- Filtrare AJAX cu autocomplete
- Timeline interactiv cu GSAP
- Design responsive
- Integrare ACF Pro

## 📄 Licență

Această temă este licențiată sub [GPL v2 sau mai târziu](https://www.gnu.org/licenses/gpl-2.0.html).

## 👥 Credite

- Design și dezvoltare: [Numele tău]
- Icoane: [Heroicons](https://heroicons.com/)
- Animații: [GSAP](https://greensock.com/)
- Font: [Playfair Display](https://fonts.google.com/specimen/Playfair+Display), [Source Sans Pro](https://fonts.google.com/specimen/Source+Sans+Pro)

## 🤝 Contribuții

Contribuțiile sunt binevenite! Pentru schimbări majore, deschide mai întâi un issue pentru a discuta propunerea.

---

Dezvoltat cu ❤️ pentru cultura română.
