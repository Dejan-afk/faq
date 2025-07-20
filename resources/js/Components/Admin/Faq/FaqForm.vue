<template>
  <div v-if="show" class="faq-modal-backdrop">
    <div class="faq-modal">
      <div class="faq-modal-header">
        <h2>{{ faq ? 'Frage bearbeiten' : 'Neue Frage erstellen' }}</h2>
        <button class="faq-modal-close" @click="close" aria-label="Schließen">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <p class="faq-modal-subline">
        Füllen Sie die Felder für Frage und Antwort aus, wählen Sie eine Kategorie,
        vergeben Sie passende Schlagwörter und klicken Sie auf "Speichern".
      </p>

      <form @submit.prevent="submit">
        <input
          id="question"
          v-model="form.question"
          placeholder="Frage eingeben"
          required
        />
        <p v-if="form.errors.question" class="form-error">{{ form.errors.question }}</p>
        <div class="highlight-toggle">
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.highlighted" />
            <span>Frage hervorheben</span>
          </label>
          <small>
            Wenn diese Option aktiviert ist, wird die Frage in die Top-Fragen der jeweiligen Kategorie mit aufgenommen
          </small>
        </div>
        <label for="answer" class="sr-only">Antwort</label>
        <textarea
          id="answer"
          ref="answerTextarea"
          v-model="form.answer"
          placeholder="Antwort eingeben"
          required
          rows="6"
        />
        <p v-if="form.errors.answer" class="form-error">{{ form.errors.answer }}</p>
        <div class="dropdowns">
          <DropdownMultiple
            id="tags"
            label="Tags auswählen"
            :options="tags"
            v-model="form.tags"
            :error="form.errors.tags"
          />

          <Dropdown
            id="categories"
            label="Kategorie auswählen"
            :options="categories"
            v-model="form.category"
            :error="form.errors.category"
          />
        </div>

        <div class="faq-modal-actions">
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
import { ref, watch, onMounted, nextTick } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppButton from '@/Components/Input/AppButton.vue'
import Dropdown from '../../Input/Dropdown.vue'
import DropdownMultiple from '../../Input/DropdownMultiple.vue'
import '../../../../css/faq-form.css'

const props = defineProps({
  show: Boolean,
  faq: Object,
  tags: Array,
  categories: Array,
})

const emit = defineEmits(['close'])
const answerTextarea = ref(null)

const form = useForm({
  question: '',
  answer: '',
  tags: [],
  category: null,
  highlighted: false
})

watch(
  () => props.faq,
  (faq) => {
    if (faq) {
      form.question = faq.question
      form.answer = faq.answer
      form.tags = faq.tags ? faq.tags.map(tag => tag.id) : []
      form.category = faq.category ? faq.category.id : null
      form.highlighted = !!faq.highlighted /* todo: backend */
    } else {
      form.reset()
      form.clearErrors()
    }
  },
  { immediate: true }
)

watch(() => form.answer, () => {
  nextTick(() => {
    if (answerTextarea.value) {
      answerTextarea.value.style.height = 'auto'
      answerTextarea.value.style.height = answerTextarea.value.scrollHeight + 'px'
    }
  })
})

const submit = () => {
  if (props.faq) {
    form.put(route('faqs.update', props.faq.id), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset()
        form.clearErrors()
        emit('close')
      }
    })
  }
  form.post(route('faqs.store'), {
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
</script>