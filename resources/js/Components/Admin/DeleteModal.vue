<template>
  <div v-if="show" class="delete-modal-backdrop">
    <div class="delete-modal">
      <div class="delete-modal-header">
        <h2>
          Sind Sie sicher, dass Sie
          {{ item.question ? 'die folgende Frage' : 'den folgenden Tag' }} löschen wollen?
        </h2>
        <AppButton
          icon="icon-close.svg"
          class="btn close"
          @click="close"
          as="button"
        />
      </div>

      <div class="delete-modal-body">
        <p class="delete-modal-label">{{ item.question ? 'Frage' : 'Tag' }}</p>
        <p class="delete-modal-value">{{ item.question ?? item.name }}</p>
      </div>

      <div class="delete-modal-actions">
        <AppButton
          label="Abbrechen"
          icon="icon-close.svg"
          @click="close"
          class="btn cancel"
          as="button"
        />
        <AppButton
          label="Löschen"
          icon="icon-delete.svg"
          @click="confirmDelete"
          class="btn danger"
          as="button"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import '../../../css/delete-modal.css'
import AppButton from '../Input/AppButton.vue'

const props = defineProps({
  show: Boolean,
  item: Object,
})
const emit = defineEmits(['close'])

const form = useForm({})

const confirmDelete = () => {
  const routeName = props.item.question ? 'faqs.destroy' : 'tags.destroy'
  form.delete(route(routeName, props.item.id), {
    preserveScroll: true,
    onSuccess: () => emit('close'),
  })
}

const close = () => emit('close')
</script>
