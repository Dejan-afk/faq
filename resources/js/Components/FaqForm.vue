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

        <div class="modal-actions">
          <button type="button" @click="close">Abbrechen</button>
          <button type="submit">Speichern</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import '../../css/faqForm.css'

const props = defineProps({
  show: Boolean,
  faq: Object,
})
const emit = defineEmits(['close'])

const form = useForm({
  question: props.faq?.question || '',
  answer: props.faq?.answer || '',
})

const submit = () => {
  props.faq
    ? form.put(route('faqs.update', props.faq.id), { onSuccess: () => emit('close') })
    : form.post(route('faqs.store'), { onSuccess: () => emit('close') })
}
const close = () => emit('close')
</script>
