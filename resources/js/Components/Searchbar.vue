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
import { ref, defineProps, defineEmits } from 'vue'
import { router } from '@inertiajs/vue3'
import AppButton from './Input/AppButton.vue'

const emit = defineEmits(['search'])
const search = ref('')

const props = defineProps({
  variant: String,
  placeholder: { type: String, default: 'Fragen' },
  client: Boolean
})

const performSearch = () => {
  if (props.client) {
    emit('search', search.value)
  } else {
    router.get(route('faqs.index'), { search: search.value }, {
      preserveScroll: true,
      replace: true,
    })
  }
}
</script>

<style scoped>
.search-group {
  display: flex;
  border: 1px solid var(--clr-gray-200);
  border-radius: 0.4rem; /* todo: one sided more radius than other */
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