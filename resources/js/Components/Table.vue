<template>
  <div class="admin-table-wrapper">
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th
              v-for="column in columns"
              :key="column.key"
              :class="`col-${column.key}`"
            >
              {{ column.label }}
            </th>
            <th v-if="$slots.actions">Aktionen</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in paginatedItems" :key="item.id">
            <td
              v-for="column in columns"
              :key="column.key"
              :class="`col-${column.key}`"
            >
              {{ formatCell(item[column.key], column.key) }}
            </td>
            <td v-if="$slots.actions" class="col-actions">
              <slot name="actions" :item="item" />
            </td>
          </tr>
          <!-- Fallback for empty items -->
          <tr v-if="paginatedItems.length === 0">
            <td :colspan="columns.length + ($slots.actions ? 1 : 0)" class="empty">Keine Einträge gefunden</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button @click="prevPage" :disabled="currentPage === 1">‹</button>
      <button
        v-for="page in totalPages"
        :key="page"
        @click="currentPage = page"
        :class="{ active: currentPage === page }"
      >
        {{ page }}
      </button>
      <button @click="nextPage" :disabled="currentPage === totalPages">›</button>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  columns: Array,
  items: Array,
  perPage: {
    type: Number,
    default: 8,
  },
})

const currentPage = ref(1)

const totalPages = computed(() =>
  Math.ceil(props.items.length / props.perPage)
)

const paginatedItems = computed(() =>
  props.items.slice(
    (currentPage.value - 1) * props.perPage,
    currentPage.value * props.perPage
  )
)

const prevPage = () => currentPage.value > 1 && currentPage.value--

const nextPage = () =>
  currentPage.value < totalPages.value && currentPage.value++

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('de-DE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}

const formatCell = (value, key) => {
  if (key === 'category' && typeof value === 'object') {
    return value.name
  }
  if (key === 'created_at') {
    return formatDate(value)
  }
  return value
}
</script>

<style scoped src="../../css/table.css"></style>
