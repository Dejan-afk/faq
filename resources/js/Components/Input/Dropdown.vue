<template>
  <div class="dropdown-wrapper">
    <select :id="id" v-model="internalValue" @change="onChange" class="select">
      <option value="" selected>{{ label }}</option>
      <option
        v-for="option in options"
        :key="option.id"
        :value="option.id"
      >
        {{ option.name }}
      </option>
    </select>
    <p v-if="error" class="form-error">{{ error }}</p>
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
  error: String,
})
const emit = defineEmits(['update:modelValue'])

const internalValue = ref(props.modelValue ?? '')
watch(() => props.modelValue, v => (internalValue.value = v))
function onChange() {
  emit('update:modelValue', internalValue.value)
}
</script>
