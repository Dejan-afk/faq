<template>
  <form class="search-group" @submit.prevent="performSearch">
    <input
      v-model="search"
      type="text"
      :placeholder="`Suche nach ${placeholder}`"
    />
    <AppButton
      label="Suchen"
      icon="icon-search.svg"
      :variant="variant"
      type="submit"
    />
  </form>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AppButton from './Input/AppButton.vue'

const emit = defineEmits(['search', 'update:modelValue'])
const search = ref('')

const props = defineProps({
  variant: String,
  placeholder: { type: String, default: 'Fragen' },
  client: Boolean,
  modelValue: String
})

watch(() => props.modelValue, (val) => {
  search.value = val || ''
}, { immediate: true })

watch(search, (val) => {
  emit('update:modelValue', val)
})
</script>

<style scoped>
.search-group {
  display: flex;
  border: 1px solid var(--clr-gray-100);
  border-radius: 0.6rem;
  overflow: hidden;
  background: var(--clr-gray-50); /* leicht abgesetzter Hintergrund */
  flex: 1;
  align-items: stretch;
}

.search-group input {
  padding: 0.45rem 1rem;
  border: none !important;
  background: transparent;
  outline: none;
  font-size: 1.1rem;
  flex: 1;
  color: var(--clr-gray-800);
  border-top-left-radius: 0.6rem;
  border-bottom-left-radius: 0.6rem;
}

@media (max-width: 365px) {
  .search-group {
    flex-wrap: nowrap;
  }

  .search-group input {
    font-size: 0.9rem;
    padding: 0.4rem 1rem;
  }

  .app-button {
    font-size: 0.8rem;
    padding: 0.4rem 0.9rem;
    white-space: nowrap;
  }

  .app-button svg {
    width: 0.8rem;
    height: 0.8rem;
  }
}
</style>