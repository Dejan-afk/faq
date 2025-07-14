<template>
  <div class="dropdown-wrapper">
    <label :for="id">{{ label }}</label>
    <select :id="id" v-model="internalValue" @change="onChange" class="select">
      <option value="" disabled selected>Bitte auswählen</option>
      <option
        v-for="option in options"
        :key="option.id"
        :value="option.id"
      >
        {{ option.name }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import '../../../css/dropdown.css'

const props = defineProps({
  id: String,
  label: String,
  options: Array,
  modelValue: [String, Number, null],
})
const emit = defineEmits(['update:modelValue'])

const internalValue = ref(props.modelValue)
watch(() => props.modelValue, v => (internalValue.value = v))
function onChange() {
  emit('update:modelValue', internalValue.value)
}
</script>
