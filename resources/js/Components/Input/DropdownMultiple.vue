<template>
  <div class="dropdown-wrapper" style="width: 100%;">
    <label :for="id">{{ label }}</label>
    <select :id="id" @change="addOption($event)" class="select">
      <option value="">Bitte auswählen</option>
      <option
        v-for="option in availableOptions"
        :key="option.id"
        :value="option.id"
      >
        {{ option.name }}
      </option>
    </select>

    <div class="chips">
      <span class="chip" v-for="id in modelValue" :key="id">
        {{ findName(id) }}
        <button type="button" @click="remove(id)">×</button>
      </span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import '../../../css/dropdown.css'
const { id, label, options, modelValue } = defineProps({
  id: String,
  label: String,
  options: Array,
  modelValue: Array,
})
const emit = defineEmits(['update:modelValue'])

function addOption(event) {
  const id = event.target.value
  if (!id || modelValue.includes(id)) return

  emit('update:modelValue', [...modelValue, id])

  // Reset Auswahl zurück auf "Bitte auswählen"
  event.target.value = ''
}

function remove(id) {
  emit('update:modelValue', modelValue.filter((i) => i !== id))
}

function findName(id) {
  const match = options.find((o) => o.id == id)
  return match?.name ?? id
}

const availableOptions = computed(() =>
  options.filter((o) => !modelValue.includes(o.id))
)
</script>