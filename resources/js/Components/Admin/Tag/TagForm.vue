<template>
  <div v-if="show" class="tag-modal-backdrop">
    <div class="tag-modal">
      <div class="tag-modal-header">
        <h2>{{ tag ? 'Tag bearbeiten' : 'Neuen Tag erstellen' }}</h2>
        <button class="tag-modal-close" @click="close" aria-label="Schließen">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <p class="tag-modal-subline">Vergeben Sie einen aussagekräftigen Namen für den neuen Tag</p>

      <form @submit.prevent="submit">
        <label for="tag-name" class="sr-only">Tag Name</label>
        <input
          class="tag-input"
          id="tag-name"
          v-model="form.name"
          placeholder="Tag Namen eingeben"
          required
        />
        <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>
        <div class="tag-modal-actions">
          <AppButton
            label="Abbrechen"
            icon="icon-close.svg"
            class="btn btn-cancel"
            @click="close"
            as="button"
          />
          <AppButton
            :label="form.processing ? 'Speichern...' : 'Speichern'"
            icon="icon-check.svg"
            class="btn save"
            type="submit"
            :disabled="form.processing"
            as="button"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import AppButton from '@/Components/Input/AppButton.vue'
import '../../../../css/tag-form.css'

const props = defineProps({
  tag: Object,
  show: Boolean,
})
const emit = defineEmits(['close'])

const form = useForm({
  name: props.tag?.name || '',
})

const submit = () => {
  if (props.tag) {
    return form.put(route('tags.update', props.tag.id), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset()
        form.clearErrors()
        emit('close')
      }
    })
  }

  return form.post(route('tags.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      form.clearErrors()
      emit('close')
    }
  })
}

const close = () => {
  form.reset()
  form.clearErrors()
  emit('close')
}

watch(
  () => props.tag,
  (tag) => {
    if (tag) {
      form.name = tag.name
    } else {
      form.reset()
      form.clearErrors()
    }
  },
  { immediate: true }
)
</script>