# Vetrina — Sito vetrina per casa vacanze

Applicazione web full-stack che fa da **vetrina online per una casa vacanze**: presenta l'immobile ai potenziali ospiti (gallery fotografica, descrizione, recensioni, mappa) e raccoglie richieste di prenotazione, il tutto gestibile da un **pannello di amministrazione** completo.

Il progetto nasce come sito vetrina multilingua pensato per chi affitta una casa per soggiorni brevi: il visitatore consulta foto e disponibilità, invia una richiesta di prenotazione (via form, email o WhatsApp) e può lasciare una recensione verificata. Il proprietario, dal backoffice, gestisce foto, calendario delle disponibilità, recensioni, lead e campagne email.

---

## Funzionalità principali

### Area pubblica
- **Home / landing** con gallery fotografica, descrizione dell'immobile, sezione recensioni e call-to-action di prenotazione.
- **Richiesta di prenotazione (booking lead)**: form con selezione date arrivo/partenza, controllo delle date già occupate e invio della richiesta via email + WhatsApp.
- **Recensioni con verifica OTP**: il visitatore lascia una recensione che viene confermata tramite codice OTP inviato per email, con eventuale consenso marketing. Le recensioni compaiono solo dopo approvazione dell'admin.
- **Pagina recensioni** dedicata con l'elenco completo.
- **Multilingua**: italiano, inglese, francese, spagnolo e tedesco, con switch lingua e file di traduzione dedicati.
- **Gestione consenso e privacy**: pagina termini e condizioni, e link di disiscrizione (unsubscribe) dalle email senza necessità di login.

### Pannello di amministrazione (`/admin`)
Accesso protetto da autenticazione con workflow di approvazione utenti e cambio password obbligatorio al primo accesso.

- **Dashboard** con panoramica e statistiche.
- **Lead / richieste di prenotazione**: elenco, aggiornamento stato ed eliminazione.
- **Gestione foto**: upload, riordino drag&drop, attivazione/disattivazione, modifica del testo alternativo (alt).
- **Calendario disponibilità**: blocco/sblocco di singole date o intervalli per indicare i periodi non disponibili.
- **Recensioni**: moderazione con approvazione ed eliminazione.
- **Statistiche visitatori**: tracciamento delle visite alle pagine.
- **Gestione utenti**: creazione, modifica, approvazione, reset password, gestione super admin ed eliminazione.
- **Email marketing**: composizione e invio di campagne, gestione iscritti con importazione massiva e disiscrizione.

---

## Stack tecnologico

| Ambito | Tecnologia |
|--------|-----------|
| Framework backend | [Laravel 13](https://laravel.com) (PHP 8.3+) |
| Autenticazione | [Laravel Fortify](https://laravel.com/docs/fortify) (incl. supporto 2FA) |
| Frontend / build | [Vite](https://vitejs.dev), [Tailwind CSS 4](https://tailwindcss.com) |
| Template | Blade |
| Date picker | [Flatpickr](https://flatpickr.js.org) |
| Database | MySQL / SQLite (configurabile) |
| Testing | [Pest 4](https://pestphp.com) |
| Code style | [Laravel Pint](https://laravel.com/docs/pint) |

---

## Architettura

Struttura tipica Laravel, organizzata per dominio:

```
app/
├── Http/Controllers/
│   ├── HomeController.php          # landing + elenco recensioni
│   ├── BookingLeadController.php   # raccolta richieste di prenotazione
│   ├── ReviewController.php        # invio recensioni + verifica OTP
│   ├── UnsubscribeController.php   # disiscrizione email
│   └── Admin/                      # backoffice
│       ├── DashboardController.php
│       ├── LeadsController.php
│       ├── PhotosController.php
│       ├── CalendarController.php
│       ├── ReviewsController.php
│       ├── UsersController.php
│       ├── EmailController.php
│       └── ProfileController.php
└── Models/
    ├── BookingLead.php       # richieste di prenotazione
    ├── Photo.php             # foto della gallery
    ├── BlockedDate.php       # date non disponibili
    ├── Review.php            # recensioni
    ├── EmailSubscriber.php   # iscritti newsletter
    ├── EmailCampaign.php     # campagne email
    ├── PageView.php          # tracciamento visite
    └── User.php              # utenti admin

resources/views/
├── welcome.blade.php   # home page pubblica
├── recensioni.blade.php
├── terms.blade.php
├── unsubscribe.blade.php
├── components/         # navbar, footer, ecc.
├── layouts/
├── admin/             # viste del backoffice
└── emails/            # template email (OTP, campagne)

lang/                  # traduzioni it / en / fr / es / de
```

### Middleware personalizzati del backoffice
Le rotte admin sono protette da una catena di middleware:
- `auth` — utente autenticato;
- `approved` — l'account deve essere stato approvato da un super admin;
- `password.changed` — la password di default deve essere stata cambiata.

---

## Requisiti

- PHP **8.3+**
- Composer
- Node.js + npm
- Un database (MySQL consigliato, SQLite supportato)

---

## Installazione

```bash
# 1. Clona il repository
git clone https://github.com/MikeGiglio/Vetrina_Project.git
cd Vetrina_Project

# 2. Installa le dipendenze PHP
composer install

# 3. Crea il file di ambiente e genera la chiave
cp .env.example .env
php artisan key:generate

# 4. Configura il database nel file .env, poi esegui le migrazioni
php artisan migrate

# 5. Installa le dipendenze frontend e compila gli asset
npm install
npm run build
```

In alternativa, lo script di setup fa tutto in un colpo solo:

```bash
composer run setup
```

---

## Avvio in sviluppo

Per avviare contemporaneamente server, code (queue) e Vite:

```bash
composer run dev
```

Oppure separatamente:

```bash
php artisan serve      # backend su http://localhost:8000
npm run dev            # frontend con hot reload
```

---

## Configurazione

Le variabili principali da impostare nel file `.env`:

```dotenv
APP_NAME="Casa Vacanze"
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_DATABASE=vetrina
DB_USERNAME=
DB_PASSWORD=

# Email (per OTP recensioni, campagne, notifiche lead)
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=

# Contatti per le richieste di prenotazione
WHATSAPP_NUMBER=
BOOKING_EMAIL=
```

> Alcuni dati di business (contatti, riferimenti dell'immobile, ecc.) sono centralizzati in `config/business.php`.

---

## Test

```bash
composer run test
# oppure
php artisan test
```

---

## Comandi utili

```bash
php artisan migrate:fresh --seed   # ricrea il DB con i dati di esempio
./vendor/bin/pint                  # formatta il codice secondo lo standard Laravel
php artisan queue:listen           # processa le code (invio email, ecc.)
```

---

## Licenza

Progetto basato sul framework Laravel, rilasciato sotto licenza [MIT](https://opensource.org/licenses/MIT).
