<template>
  <div>
    <header class="app-header">
      <Navbar/>
    </header>

    <section class="app-hero">
        <Hero heroImage="">
          <template #hero>
            <h1>{{ page.props.title }}</h1>
            <p>{{ page.props.description }}</p>
            <div v-if="isLandingPage" class="hero-search">
              <input v-model="query" placeholder="Suche nach etwas …" />
              <button @click="search">Suchen</button>
            </div>
          </template>
        </Hero>
    </section>

    <main class="container page-content">
      <div v-if="flashMessage?.success" class="flash success">
        {{ flashMessage.success }}
      </div>
      <div v-if="flashMessage?.error" class="flash error">
        {{ flashMessage.error }}
      </div>

      <slot />
    </main>

    <footer class="container footer-content">
        &copy; 2025 | DEKRA Neo GmbH
    </footer>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import '../../css/app.css'
import Navbar from '@/Components/Navbar.vue'
import Hero from './Hero.vue'

const page = usePage()
const flashMessage = ref('')
const query = ref('')
const isLandingPage = page.url === '/'

watch(() => page.props.flash, (newFlashMessage) => {
  if (newFlashMessage?.success || newFlashMessage?.error) {
    flashMessage.value = newFlashMessage

    setTimeout(() => {
      flashMessage.value = ''
    }, 3000)
  }
}, { immediate: true })
</script>
