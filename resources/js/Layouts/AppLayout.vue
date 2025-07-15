<template>
  <div>
    <Navbar />

    <main>
      <div v-if="flashMessage?.success" class="flash success">
        {{ flashMessage.success }}
      </div>
      <div v-if="flashMessage?.error" class="flash error">
        {{ flashMessage.error }}
      </div>

      <slot />
    </main>

    <footer>
      <div class="footer-content">
        &copy; 2025 | DEKRA Neo GmbH
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import '../../css/app.css'
import Navbar from '@/Components/Navbar.vue'

const page = usePage()
const flashMessage = ref('')
const isAdmin = page.props.auth?.user?.role === 'admin'

watch(() => page.props.flash, (newFlashMessage) => {
  if (newFlashMessage?.success || newFlashMessage?.error) {
    flashMessage.value = newFlashMessage

    setTimeout(() => {
      flashMessage.value = ''
    }, 3000)
  }
}, { immediate: true })
</script>
