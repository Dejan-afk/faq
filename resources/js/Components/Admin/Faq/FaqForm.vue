<template>
  <div v-if="show" class="modal-backdrop">
    <div class="modal">
      <h2>{{ faq ? 'FAQ bearbeiten' : 'FAQ erstellen' }}</h2>

      <form @submit.prevent="submit">
        <label>
          Frage:
          <input v-model="form.question" required />
        </label>

        <label>
          Antwort:
          <textarea v-model="form.answer" required></textarea>
        </label>

        <div class="dropdowns">
          <DropdownMultiple
            id="tags"
            label="Tags"
            :options="tags"
            v-model="form.tags"
          />

          <Dropdown 
            id="categories"
            label="Kategorie"
            :options="categories"
            v-model="form.category"
          />
        </div>

        <div class="modal-actions">
          <button type="button" @click="close">Abbrechen</button>
          <button type="submit" :disabled="form.processing">
            {{ form.processing ? 'Speichern...' : 'Speichern' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import '../../../../css/faq-form.css'
import Dropdown from '../../Input/Dropdown.vue'
import DropdownMultiple from '../../Input/DropdownMultiple.vue'

const props = defineProps({
  show: Boolean,
  faq: Object,
  tags: Array,
  categories: Array,
})
const emit = defineEmits(['close'])

const form = useForm({
  question: '',
  answer: '',
  tags: [],
  category: null,
})

watch(
  () => props.faq,
  (faq) => {
    if (faq) {
      form.question = faq.question
      form.answer = faq.answer
      form.tags = faq.tags ? faq.tags.map(tag => tag.id) : []
      form.category = faq.category ? faq.category.id : null
    } else {
      form.reset() // leere Felder beim Erstellen
      form.clearErrors() // Fehler zurücksetzen
    }
  },
  { immediate: true }
)

const submit = () => {
  props.faq
    ? form.put(route('faqs.update', props.faq.id), { onSuccess: () => emit('close') })
    : form.post(route('faqs.store'), { onSuccess: () => emit('close') })
}

const close = () => emit('close')
</script>
