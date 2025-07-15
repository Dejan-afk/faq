<template>
  <header class="dekra-navbar">
    <!-- Logo & Hamburger‑Schalter -->
    <a href="/" class="brand">
      <!-- Logo -->
      <img class="icon-logo" src="/logo/dekra-logo-white.svg" alt="DEKRA" />
    </a>

    <!-- Hamburger -->
    <input type="checkbox" id="nav-toggle" class="nav-toggle" />
    <label for="nav-toggle" class="hamburger" aria-label="Menü öffnen/schließen">
      <span></span><span></span><span></span>
    </label>

    <!-- Navigation -->
    <nav>
      <ul class="nav-links">
        <li><a href="/faq">FAQ</a></li>
        <!-- Tags & Fragen nur für Admin -->
        <li v-if="isAdmin"><a href="/tags">Tags</a></li>
        <li v-if="isAdmin"><a href="/questions">Fragen</a></li>
      </ul>

      <!-- Login -->
      <a href="/login" class="btn-login">
        <img class="icon-login" src="/icons/icon-arrow-circle-right.svg" alt="Login" />
        Login
      </a>
    </nav>
  </header>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import '../../css/navbar.css'
const page = usePage()
const isAdmin = page.props.auth?.user?.role === 'admin'
</script>
