<template>
  <div>
    <header class="app-header">
      <Navbar/>
    </header>

    <section class="app-hero">
        <Hero :is-landing="isLandingPage">
          <template #hero>
            <div class="hero-container">
              <h1>{{ page.props.title }}</h1>
            </div>
            <p>{{ page.props.description }}</p>
            <div v-if="isLandingPage" class="hero-container">
              <Searchbar variant="primary" client @search="searchTerm = $event"/>
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
import { ref, watch, provide } from 'vue'
import { usePage } from '@inertiajs/vue3'
import '../../css/app.css'
import Navbar from '@/Components/Navbar.vue'
import Hero from './Hero.vue'
import Searchbar from '@/Components/Searchbar.vue'

const page = usePage()
const flashMessage = ref('')
const isLandingPage = page.url === '/'
const searchTerm = ref('')
provide('searchTerm', searchTerm)

watch(() => page.props.flash, (newFlashMessage) => {
  if (newFlashMessage?.success || newFlashMessage?.error) {
    flashMessage.value = newFlashMessage

    setTimeout(() => {
      flashMessage.value = ''
    }, 3000)
  }
}, { immediate: true })
</script>
