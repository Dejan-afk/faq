<template>
  <div v-if="show" class="modal-backdrop">
    <div class="modal">
      <h2>Wirklich löschen?</h2>
      <p>{{ faq.question }}</p>

      <div class="modal-actions">
        <button @click="close">Abbrechen</button>
        <button class="danger" @click="confirmDelete">Löschen</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import '../../css/deleteModal.css'

const props = defineProps({
  show: Boolean,
  faq: Object,
})
const emit = defineEmits(['close'])

const confirmDelete = () => {
  router.delete(route('faqs.destroy', props.faq.id), {
    onSuccess: () => emit('close'),
  })
}
const close = () => emit('close')
</script>
