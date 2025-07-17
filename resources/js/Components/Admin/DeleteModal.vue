<template>
  <div v-if="show" class="modal-backdrop">
    <div class="modal">
      <h2>Sind Sie sicher, dass Sie {{ item.question ? 'folgende Frage' : 'folgenden Tag' }} löschen wollen?</h2>
      <p>{{ item.question ?? item.name }}</p>

      <div class="modal-actions">
        <button @click="close">Abbrechen</button>
        <button :disabled="form.processing" @click="confirmDelete">
          {{ form.processing ? 'Löschen...' : 'Löschen' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import '../../../css/delete-modal.css'

const props = defineProps({
  show: Boolean,
  item: Object,
})
const emit = defineEmits(['close'])

const form = useForm({})

const confirmDelete = () => {
  form.delete(route('faqs.destroy', props.item.id), {
    preserveScroll: true,
    onSuccess: () => emit('close'),
  })
}

const close = () => emit('close')
</script>
