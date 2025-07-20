<template>
  <section :class="['hero', isLanding ? 'landing' : 'compact']">
    <div class="hero-overlay">
      <div class="hero-background">
        <div class="triangle t1"></div>
        <div class="triangle t2"></div>
        <div class="triangle t3"></div>
        <div class="triangle t4"></div>
        <div class="triangle t5"></div>
        <div class="triangle t6"></div>
      </div>
      <slot name="hero" />
    </div>
  </section>
</template>

<script setup>
import '../../css/hero.css'
import { defineProps } from 'vue'

defineProps({
  isLanding: Boolean
})
</script>
