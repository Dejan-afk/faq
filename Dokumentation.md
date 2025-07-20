# Projektdokumentation – FAQ-System (DEKRA Coding Challenge)

## 1. Zielsetzung

Die Aufgabe bestand darin, eine moderne und dynamische FAQ-Seite zu entwickeln – vollständig von Grund auf eingerichtet, inklusive Datenbankstruktur, Admin-Funktionalität und responsivem Frontend. Das Projekt sollte ohne externe Component Libraries und vorzugsweise mit reiner CSS-Umsetzung realisiert werden.  
Im Vordergrund standen klare UX, Design-Treue und ein stabiles technisches Fundament.

## 2. Technologie-Stack

- **Laravel** – Backend, Authentifizierung, Routing, Validierung  
- **Vue.js 3** – Frontend-Logik mit Composition API  
- **Inertia.js** – Bindeglied zwischen Frontend und Backend  
- **MySQL** – Datenhaltung via Migrationen und Seeder  
- **Docker** – Lokale Entwicklungsumgebung  
- **Pure CSS** – Keine Utility- oder Component-Library verwendet  

## 3. Funktionsumfang (Umsetzung)

- ✅ Admin-Bereich mit Login (inkl. Authentifizierung)  
- ✅ Tags: Erstellen, Bearbeiten, Löschen  
- ✅ FAQs: Erstellen, Bearbeiten, Löschen  
- ✅ Reihenfolge der FAQs anpassbar  
- ✅ Kategorie-Tabs & serverseitig vorbereitete Daten  
- ✅ Suche mit Highlighting (clientseitig, inkl. Frage, Antwort, Tags)  
- ✅ Responsive Design für alle Ansichten  
- ✅ SEO: Meta-Tags + strukturierte Daten (FAQPage)  
- ✅ Saubere Git-Historie, .env.example, Setup via Docker  
- ✅ Lazy Loading (FAQs nach Kategorie)  
- ✅ Error Handling (z. B. bei Formularvalidierungen)

## 4. Herausforderungen & Lösungen

### Kategorie-Filterung mit Tabs

Die Startseite ermöglicht die Filterung der FAQs nach Hauptkategorien wie „Allgemeines“ oder „Zahlungen“.  
Die Kategorieauswahl wird über visuelle Tabs gesteuert, wobei die jeweils aktive Kategorie hervorgehoben wird. Der Wechsel lädt die Daten asynchron (Lazy Loading).

### Clientseitige Suche + Highlighting

Die Suche wurde vollständig clientseitig umgesetzt, um Reaktionszeiten zu minimieren. Gleichzeitig wurde ein `highlightMatch`-Mechanismus entwickelt, der bei Mehrwortsuche alle Begriffe markiert – unabhängig von Reihenfolge oder Groß-/Kleinschreibung.

Im Adminbereich wurde ebenfalls eine clientseitige Filterung umgesetzt. Grund dafür ist die aktuell geringe Anzahl an FAQs, wodurch der Aufwand für serverseitige Suchlogik nicht gerechtfertigt war. Bei wachsendem Datenvolumen kann die Logik jedoch problemlos serverseitig ersetzt werden, da die Struktur modular gehalten ist.

### Reine CSS-Nutzung

Trotz fehlender Utility-Klassen (wie Tailwind) wurde ein durchgängiges, semantisch sauberes Styling realisiert. Wiederverwendbare CSS-Dateien wurden pro Komponente ausgelagert.

### Inertia-Vue-Kommunikation

Um globale States wie die Suche zwischen Layout (`AppLayout`) und Page (`Welcome.vue`) zu teilen, kam `provide`/`inject` zum Einsatz – eine elegante Lösung, die zugleich testbar bleibt.

### SEO trotz SPA

Durch Nutzung der `<Head>`-Komponente von Inertia konnten dynamische Meta-Daten direkt in den Seiten-Komponenten gesetzt werden. Die strukturierte FAQ-Auszeichnung (`application/ld+json`) wurde direkt per SSR-freundlicher `<component is="head">`-Syntax eingebunden.

### Lazy Loading + Eager Loading

Die Startseite lädt initial nur die FAQs einer Kategorie (z. B. "Allgemeines") und rendert die restlichen im Hintergrund nach. Gleichzeitig wird auf Backend-Seite `with()` für die Relationen `category` und `tags` verwendet, um N+1-Probleme zu vermeiden.

### Datenbankoptimierung

Um häufige Abfragen performant zu halten, wurde eine zusätzliche Migration mit sinnvollen Indizes eingeführt:

| Tabelle   | Spalte(n)     | Zweck                                                       |
|-----------|---------------|-------------------------------------------------------------|
| `faqs`    | `category_id` | Wird für Filter (`where`) und Joins verwendet              |
|           | `question`    | Wird bei Backend-Suche mit `LIKE` abgefragt                |
|           | `answer`      | MySQL Fulltext-Index für bessere Volltextsuche             |
| `faq_tag` | `faq_id`      | Für Join zu `faqs`                                          |
|           | `tag_id`      | Für Join zu `tags`                                          |
| `tags`    | `name`        | Wird bei Tag-Suche mit `LIKE` genutzt (z. B. im Controller) |

Die Änderungen wurden rückwirkungsfrei in einer separaten Migration umgesetzt.

### Sortierlogik bei `sort_order`

Die Positionierung der Fragen innerhalb einer Kategorie erfolgt dynamisch über das Feld `sort_order`. Dieses Feld ist **nicht eindeutig**, sondern dient der **Reihenfolge innerhalb einer Kategorie**. Zwei Operationen greifen in diese Sortierung ein:

#### 🟢 Beim Erstellen (`store`)

Beim Hinzufügen einer neuen Frage wird geprüft, ob bereits Fragen in der gewählten Kategorie vorhanden sind:

- **Wenn ja:** Die neue Frage wird **an das Ende dieser Kategorie** gesetzt. Alle nachfolgenden globalen `sort_order`-Werte (aus anderen Kategorien) werden um eins erhöht, damit die Reihenfolge konsistent bleibt.
- **Wenn nein:** Die neue Kategorie wird **vor der nächsten existierenden Kategorie** eingefügt. Auch hier werden alle betroffenen `sort_order`-Einträge entsprechend verschoben.

Diese Logik sorgt dafür, dass Fragen **kategorieweise gruppiert und sortiert** bleiben, ohne Lücken oder doppelte Sortierungen.

#### 🔴 Beim Löschen (`destroy`)

Wird eine Frage entfernt, wird die Sortierung ebenfalls angepasst:

- Alle Fragen, deren `sort_order` **größer** ist als die der gelöschten Frage, werden **um eins reduziert**.
- So bleibt die Sortierung durchgängig und es entstehen keine Lücken oder Ungereimtheiten in der Reihenfolge.

Diese saubere Nachpflege vermeidet Inkonsistenzen und sichert eine stabile Sortierung für alle Kategorien.

### Login-Ansicht für Admins

Ein individuell gestalteter Login-Screen ermöglicht autorisierten Nutzern den Zugang zum Admin-Bereich.

### Fallback-Ansicht für fehlende Routen

Ein kleiner Screen, der dem User Feedback und Option zum Umleiten bereitstellt. 

## 5. Verbesserungsmöglichkeiten & Ausblick

Folgende Punkte wurden im Projektumfang geplant, aber bewusst ausgeklammert oder stehen kurz vor Umsetzung:

- Caching von FAQ-Daten (z. B. pro Kategorie via `remember`)  
- Weitere Error Handling Features (z. B. globale Fehlerseite, User-Feedback)  
- Serverseitige Suche als optionales Upgrade bei wachsendem Datenvolumen  
- Deep-Linking von Suchergebnissen  
- Highlighting der Kategorie-Tabs bei aktivem Suchtreffer
- Detailiertere Umsetzung des Designs (Blur-Effekt hinter Navbar, Opacity der Navbar ohne dessen Inhalt zu beeinflussen, anderer Ansatz für Hero-Hintergrund)
- Fragen mit is_active sichtbar machen, ohne entfernen zu müssen. 
- Die Kontaktseite mit der Option freihändig Fragen anzufragen, oder - sofern is_active in der Zukunft implementiert wird - die Möglichkeit zu haben inaktive Fragen auszuwählen.  

Diese Erweiterungen würden die Performance und Resilienz der Anwendung noch weiter verbessern.

## 6. Projektstruktur & Architektur

Die Anwendung ist klar strukturiert und folgt einer modularen Architektur:

### **Frontend (Vue / Inertia)**

Der JavaScript-Ordner unter `resources/js/` gliedert sich wie folgt:

- **assets/**  
  Enthält Design-Ressourcen wie Icons, Logos und andere gestalterische Elemente, aufgeteilt in `design-elements`, `icons` und `logo`.

- **Components/**  
  Unterordner für wiederverwendbare Komponenten:
  - `Admin/Faq/` für Komponenten zur FAQ-Verwaltung  
  - `Admin/Tag/` für Komponenten zur Tag-Verwaltung  
  - `Input/` für allgemeine UI-Komponenten wie Buttons und Dropdowns  
  - `Seo/` für strukturierte Daten und Meta-Tags

- **composables/**  
  Wiederverwendbare Composition Functions wie `useSearch` oder `useFaqModal`.

- **Layouts/**  
  Enthält das globale AppLayout inklusive Navigation und Head-Integration.

- **Pages/**  
  Enthält Seitenansichten:
  - `Admin/` für Verwaltungsseiten wie `Faq.vue` oder `Tag.vue`  
  - `Auth/` für Login-Komponenten

- **Stores/**  
  Globale State-Verwaltung mit Pinia, z. B. für Suche oder Modalsteuerung.

- **app.js**  
  Einstiegspunkt für die Vue/Inertia-Anwendung.

- **bootstrap.js**  
  Initialisierung von Axios, Vue und weiteren Abhängigkeiten.

---

### **Backend (Laravel)**

Die Backend-Struktur befindet sich im `app/`-Verzeichnis und ist folgendermaßen aufgebaut:

- **Http/Controllers/**  
  Enthält die Controller für `Faq`, `Tag` und `Auth`.

- **Http/Middleware/**  
  Zuständig für Zugriffskontrolle, insbesondere für den Admin-Bereich.

- **Models/**  
  Datenmodelle wie `Faq`, `Tag`, `Category` und `User`.

- **Providers/**  
  Service-Provider für globales Verhalten der Anwendung.

---

### Diese Struktur ermöglicht:

- **klare Trennung nach Rolle (Admin vs. Public)**
- **modulare Komponentenstruktur**
- **skalierbare Erweiterung z. B. um weitere Bereiche wie Quizzes, Tutorials oder Dokumentationen**

