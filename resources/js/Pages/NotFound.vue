<template>
  <main class="notfound-page">
    <div class="notfound-card">
      <h1>404 – Seite nicht gefunden</h1>
      <p class="notfound-subline">
        Die angeforderte Seite existiert nicht oder wurde verschoben.
      </p>
      <Link href="/" class="home-button">Zurück zur Startseite</Link>
    </div>
  </main>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
.notfound-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  padding: 2rem;
  background-color: var(--clr-darkgreen-800);
}

.notfound-card {
  background-color: white;
  padding: 3rem 2.5rem;
  border-radius: 12px;
  text-align: center;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  max-width: 420px;
  width: 100%;
}

.notfound-card h1 {
  color: var(--clr-darkgreen-800);
  font-size: 1.8rem;
  margin-bottom: 1rem;
}

.notfound-subline {
  font-size: 0.95rem;
  color: #444;
  margin-bottom: 2rem;
}

.home-button {
  background-color: var(--clr-brightgreen-200);
  color: var(--clr-darkgreen-800);
  font-weight: 600;
  padding: 0.7rem 1.4rem;
  border-radius: 6px;
  text-decoration: none;
  transition: background 0.2s ease;
  display: inline-block;
}

.home-button:hover {
  background-color: #b6f3b3;
}
</style>
