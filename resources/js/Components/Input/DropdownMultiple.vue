<template>
  <div class="dropdown-wrapper" style="width: 100%;">
    <select :id="id" @change="addOption($event)" class="select">
      <option value="">{{ label }}</option>
      <option
        v-for="option in availableOptions"
        :key="option.id"
        :value="option.id"
      >
        {{ option.name }}
      </option>
    </select>

    <div class="chips">
      <AppButton
        v-for="id in modelValue"
        :key="id"
        :label="findName(id)"
        icon="icon-remove.svg"
        @click="remove(id)"
        class="chip-button"
        reverse
      />
    </div>
    <p v-if="error" class="form-error">{{ error }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import '../../../css/dropdown.css'
import AppButton from './AppButton.vue'

const { id, label, options, modelValue } = defineProps({
  id: String,
  label: String,
  options: Array,
  modelValue: Array,
  error: String,
})

const emit = defineEmits(['update:modelValue'])

function addOption(event) {
  const id = event.target.value
  if (!id || modelValue.includes(id)) return

  emit('update:modelValue', [...modelValue, id])

  // Reset
  event.target.value = ''
}

const remove = (id) => {
  emit('update:modelValue', modelValue.filter((i) => i !== id))
}

const findName = (id) => {
  const match = options.find((o) => o.id == id)
  return match?.name ?? id
}

const availableOptions = computed(() =>
  options.filter((o) => !modelValue.includes(o.id))
)
</script>