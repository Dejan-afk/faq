<template>
    <section class="hero" :style="{ backgroundImage: `url(${heroImage})` }">
        <div class="hero-overlay">
            <slot name="hero" />
        </div>
    </section>
</template>

<script setup>
import '../../css/hero.css'

const props = defineProps({
  heroImage: { type: String, required: true },
})
const heroImage = props.heroImage
</script>