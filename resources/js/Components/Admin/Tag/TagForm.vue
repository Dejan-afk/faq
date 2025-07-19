<template>
  <div v-if="show" class="tag-modal-backdrop">
    <div class="tag-modal">
      <div class="tag-modal-header">
        <h2>{{ tag ? 'Tag bearbeiten' : 'Neuen Tag erstellen' }}</h2>
        <AppButton
          icon="icon-close.svg"
          class="btn close"
          @click="close"
          as="button"
        />
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
  const request = props.tag
    ? form.put(route('tags.update', props.tag.id))
    : form.post(route('tags.store'))

  request.then(() => emit('close'))
}

const close = () => emit('close')

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