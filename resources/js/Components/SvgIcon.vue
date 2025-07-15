<template>
  <span v-html="svgContent" :class="wrapperClass" aria-hidden="true" />
</template>

<script setup>
import { ref, watchEffect } from 'vue'
import { useAsset } from '@/composables/useAsset'

const props = defineProps({
  src: { type: String, required: true },
  wrapperClass: { type: String, default: '' },
})

const svgContent = ref('')

watchEffect(async () => {
  const svg = await useAsset(props.src)
  svgContent.value = svg
})
</script>
