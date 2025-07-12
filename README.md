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