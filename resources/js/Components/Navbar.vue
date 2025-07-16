<template>
  <div class="navbar-wrapper">
    <div class="container dekra-navbar">
      <!-- Logo & Hamburger‑Schalter -->
      <a href="/" class="brand">
        <!-- Logo -->
        <SvgIcon src="dekra-logo-white.svg" wrapper-class="icon-logo" />
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
        <AppButton
          label="Login"
          icon="icon-arrow-circle-right.svg"
          href="/login"
          variant="primary"
          as="a"
        />
      </nav>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import SvgIcon from './SvgIcon.vue'
import '../../css/navbar.css'
import AppButton from './Input/AppButton.vue'
const page = usePage()
const isAdmin = page.props.auth?.user?.role === 'admin'
</script>
