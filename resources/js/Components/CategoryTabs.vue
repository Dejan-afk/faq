<template> <!-- TODO: component for one or all tabs? -->
  <div class="category-tabs">
    <button
      v-for="category in categories"
      :key="category.id"
      :class="['tab', { active: category.id === selectedId }]"
      @click="$emit('select', category.id)"
    >
      <SvgIcon :src="category.icon" wrapper-class="tab-icon" />
      <span class="tab-label">{{ category.name }}</span>
    </button>
  </div>
</template>

<script setup>
import '../../css/category-tab.css'
import SvgIcon from '@/Components/SvgIcon.vue'
defineProps({
  categories: Array,
  selectedId: [String, Number],
})

defineEmits(['select'])
</script>
