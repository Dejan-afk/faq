<template>
  <div>
    <nav>
      <div v-if="isAdmin">
        <!-- Admin-Navbar -->
        <Link href="/faqs">Admin: FAQs verwalten</Link>
        <Link href="/logout" method="post">Logout</Link>
      </div>
      <div v-else>
        <!-- Besucher-Navbar -->
        <Link href="/">Startseite</Link>
        <Link href="/login">Admin-Login</Link>
      </div>
    </nav>

    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const isAdmin = page.props.auth?.user?.role === 'admin'
</script>
