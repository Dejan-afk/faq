<template>
  <div class="search-and-create">
    <div class="page-context">
      <h2>{{ title }}</h2>
      <p>{{ subtitle }}</p>
    </div>

    <div class="page-actions">
      <Searchbar
        v-model="searchModel"
        :placeholder="searchPlaceholder"
        :client="true"
        @search="$emit('search', searchModel)"
      />
      <AppButton
        :label="actionLabel"
        :icon="actionIcon"
        variant="dark-icon"
        class="create-button"
        rotate-icon="45"
        @click="$emit('action')"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Searchbar from '@/Components/Searchbar.vue'
import AppButton from '@/Components/Input/AppButton.vue'
import '../../../css/page-header.css'

const props = defineProps({
  title: String,
  subtitle: String,
  searchPlaceholder: { type: String, default: 'Suche ...' },
  actionLabel: String,
  actionIcon: String,
  modelValue: String,
})

const emit = defineEmits(['update:modelValue', 'search', 'action'])

const searchModel = ref(props.modelValue || '')

watch(searchModel, val => emit('update:modelValue', val))
</script>
