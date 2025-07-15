<template>
    <form class="search-group" @submit.prevent="search">
        <input
            v-model="search"
            type="text"
            :placeholder="`Suche nach ${placeholder}`"
            @keyup.enter="performSearch"
        />
        <button @click="performSearch">Suchen</button>
    </form>
</template>

<script setup>
import { ref, defineProps } from 'vue'
import { router } from '@inertiajs/vue3'

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
  border-radius: 6px;
  overflow: hidden;
  background: var(--clr-gray-50);
}

.search-group input {
  padding: 0.5rem 1rem;
  border: none;
  background: transparent;
  outline: none;
  min-width: 220px;
}

.search-group button {
  background: var(--clr-darkgreen-700);
  color: var(--clr-brightgreen-100);
  padding: 0 1rem;
  border: none;
  cursor: pointer;
}
.search-group button:hover {
  background: var(--clr-darkgreen-800);
}
</style>