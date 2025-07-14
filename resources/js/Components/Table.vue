<template>
  <table class="data-table">
    <thead>
      <tr>
        <th v-for="header in headers" :key="header.key">
          {{ header.label }}
        </th>
        <th v-if="hasActions">Aktionen</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in items" :key="item.id">
        <td v-for="header in headers" :key="header.key">
          <slot
            :name="`cell-${header.key}`"
            :item="item"
            :value="item[header.key]"
          >
            {{ item[header.key] }}
          </slot>
        </td>
        <td v-if="hasActions">
          <slot name="actions" :item="item" />
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
defineProps({
  headers: {
    type: Array,
    required: true,
    // z.B. [{ key: 'question', label: 'Frage' }, { key: 'category', label: 'Kategorie' }]
  },
  items: {
    type: Array,
    required: true,
  },
  hasActions: {
    type: Boolean,
    default: true,
  },
})
</script>

<style scoped src="../../css/table.css"></style>
