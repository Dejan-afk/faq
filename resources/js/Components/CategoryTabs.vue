<template>
<div class="category-tabs-wrapper">
  <div class="category-tabs">
    <button
      v-for="category in categories"
      :key="category.id"
      :class="['tab', { active: category.id === selectedId }]"
      @click="$emit('select', category.id)"
    >
      <div class="tab-icon-wrapper">
        <SvgIcon
          :src="'icon-categorie-' + category.name.toLowerCase() + '.svg'"
          wrapper-class="tab-icon"
        />
      </div>
      <span class="tab-label">{{ category.name }}</span>
    </button>
  </div>
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
