# 💡 DEKRA FAQ-Page – Coding Challenge

Willkommen zum DEKRA FAQ-Projekt! Diese Webanwendung ist Teil einer Full-Stack-Coding-Challenge und zeigt die Integration von Laravel, Inertia.js, Vue 3 und MySQL in einer modernen, responsiven FAQ-Verwaltung.

---

## 🚀 Tech-Stack

- **Laravel** (aktuelle Version)
- **Vue.js 3** + Composition API (via Inertia.js)
- **Inertia.js** (Bridge zwischen Backend und Frontend)
- **MySQL** (strukturierte Datenhaltung)
- **Authentication** via Laravel Breeze
- **Docker** (für Datenbank & phpMyAdmin)

---

## ⚙️ Setup-Anleitung

### 📦 Voraussetzungen

- PHP ≥ 8.1
- Composer
- Node.js + npm
- Git
- Docker + Docker Compose

---

## ⚠️ Hinweis zur Sicherheit

Die verwendeten **Datenbank-Zugangsdaten** (`faq_user` / `neo`) sind ausschließlich für die **lokale Entwicklung** gedacht.

Diese werden beim Start des Projekts **automatisch im Docker-Netzwerk erzeugt** und besitzen **keine externe Reichweite**.

> 🧪 Dieses Setup dient der **Demonstration** und dem **einfachen Einstieg** – **nicht** für den produktiven Einsatz geeignet!

---

### 🔧 Installation & Start

```bash
git clone https://github.com/Dejan-afk/faq.git
cd faq

# Vorbereitung der Anwendung
cp .env.example .env
composer install
npm install
php artisan key:generate

# Start der Datenbank und phpMyAdmin (Docker)
docker-compose up -d
```