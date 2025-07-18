<template>
  <div class="navbar-wrapper">
    <div class="container dekra-navbar">
      <!-- Logo & Hamburger‑Schalter -->
      <a href="/" class="brand">
        <!-- Logo -->
        <SvgIcon src="dekra-logo-white.svg" wrapper-class="icon-logo" />
      </a>

      <!-- Hamburger -->
      <input type="checkbox" id="nav-toggle" class="nav-toggle" v-model="navOpen" />
      <label for="nav-toggle" class="hamburger-icon" :class="{ open: navOpen }" aria-label="Menü öffnen/schließen">
        <SvgIcon
          src="icon-bars.svg"
          wrapper-class="icon-bars"
          :class="{ open: navOpen }"
        />
      </label>

      <!-- Navigation -->
      <nav>
              <ul class="nav-links">
        <li>
          <a
            href="/"
            :class="{ active: currentUrl === '/' }"
          >FAQ</a>
        </li>
        <li v-if="isAdmin">
          <a
            href="/tags"
            :class="{ active: currentUrl.startsWith('/tags') }"
          >Tags</a>
        </li>
        <li v-if="isAdmin">
          <a
            href="/faqs"
            :class="{ active: currentUrl.startsWith('/faqs') }"
          >Fragen</a>
        </li>
      </ul>

        <!-- Logout -->
        <AppButton
          v-if="isLoggedIn"
          label="Logout"
          icon="icon-arrow-circle-left.svg"
          @click="logout"
          variant="primary"
        />
        <!-- Login -->
        <AppButton
          v-else
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
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SvgIcon from './SvgIcon.vue'
import '../../css/navbar.css'
import AppButton from './Input/AppButton.vue'
import { router } from '@inertiajs/vue3'

const logout = () => {
  router.visit('/logout', {
    method: 'post'
  })
}

const navOpen = ref(false)
const page = usePage()

const isLoggedIn = computed(() => !!page.props.auth?.user)
const isAdmin = computed(() => page.props.auth?.user?.role === 'admin')
const currentUrl = computed(() => page.url)
</script>
