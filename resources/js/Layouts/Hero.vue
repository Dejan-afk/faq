<template>
  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-background">
        <div class="triangle t1" :style="{ backgroundImage: `url(${TriangleBright})` }"></div>
        <div class="triangle t2" :style="{ backgroundImage: `url(${TriangleBright})` }"></div>
        <div class="triangle t3" :style="{ backgroundImage: `url(${TriangleBright})` }"></div>
        <div class="triangle t4" :style="{ backgroundImage: `url(${TriangleDark})` }"></div>
        <div class="triangle t5" :style="{ backgroundImage: `url(${TriangleDark})` }"></div>
        <div class="triangle t6" :style="{ backgroundImage: `url(${TriangleDark})` }"></div>
      </div>
      <slot name="hero" />
    </div>
  </section>
</template>

<script setup>
import '../../css/hero.css'
import TriangleBright from '@/assets/design-elements/triangle-bright-green.svg'
import TriangleDark from '@/assets/design-elements/triangle-dark-green.svg'  
</script>
