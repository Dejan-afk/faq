<template>
  <div v-if="show" class="modal-backdrop">
    <div class="modal">
      <h2>Sind Sie sicher, dass Sie {{ item.question ? 'folgende Frage' : 'folgenden Tag' }} löschen wollen?</h2>
      <p>{{ item.question ?? item.name }}</p>

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
  item: Object,
})
const emit = defineEmits(['close'])

const confirmDelete = () => {
  router.delete(route('faqs.destroy', props.item.id), {
    onSuccess: () => emit('close'),
  })
}
const close = () => emit('close')
</script>
