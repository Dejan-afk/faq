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
      variant="secondary"
      type="submit"
    />
  </form>
</template>

<script setup>
import { ref, defineProps } from 'vue'
import { router } from '@inertiajs/vue3'
import AppButton from './Input/AppButton.vue'

const { placeholder = 'Fragen' } = defineProps({
  placeholder: {
    type: String,
    default: 'Fragen',
  },
})

const search = ref('')

const performSearch = () => {
  router.get(route('faqs.index'), { search: search.value }, {
    preserveScroll: true,
    replace: true,
  })
}
</script>

<style scoped>
.search-group {
  display: flex;
  border: 1px solid var(--clr-gray-200);
  border-radius: 0.4rem;
  overflow: hidden;
  background: white;
  flex: 1;
  align-items: stretch;
}

.search-group input {
  padding: 0.5rem 1.25rem;
  border: none;
  background: transparent;
  outline: none;
  font-size: 0.95rem;
  flex: 1;
}

.search-group :deep(.app-button--secondary) {
  border-radius: 0; /* entfernt doppelte Rundung rechts */
  border-left: 1px solid var(--clr-gray-200); /* klare Trennung */
}
</style>