<template>
  <div>
    <h1>FAQ-Verwaltung</h1>

    <button @click="create">Neue FAQ erstellen</button>

    <Table
      :headers="[
        { key: 'question', label: 'Frage' },
        { key: 'category', label: 'Kategorie' },
        { key: 'created_at', label: 'Erstellt am' },
      ]"
      :items="faqs"
    >
        <template #cell-category="{ item }">
            {{ item.category?.name ?? '-' }}
        </template>

        <template #cell-created_at="{ value }">
            {{ formatDate(value) }}
        </template>

        <template #actions="{ item }">
            <button @click="edit(item)">Bearbeiten</button>
            <button @click="destroy(item)">Löschen</button>
        </template>
    </Table>

    <!-- MODAL TODO: change fallback elegantly -->
    <FaqForm
      :show="showModal"
      :faq="editingFaq"
      :tags="tags ?? []"
      :categories="categories ?? []"
      @close="closeModal"
    />

    <!-- Delete Confirmation Modal -->
    <DeleteModal
      :show="showDeleteModal"
      :item="editingFaq"
      @close="closeModal"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import FaqForm from '@/Components/FaqForm.vue'
import DeleteModal from '@/Components/DeleteModal.vue'
import Table from '@/Components/Table.vue'

defineOptions({ layout: AppLayout })
defineProps({ 
    faqs: Array,
    tags: Array,
    categories: Array
})

// MODAL-Zustände
const showModal = ref(false)
const showDeleteModal = ref(false)
const editingFaq = ref(null)

const create = () => {
  editingFaq.value = null
  showModal.value = true
}

const edit = (faq) => {
  editingFaq.value = { ...faq } // Kopie zur Sicherheit
  showModal.value = true
}

const destroy = (faq) => {
  editingFaq.value = faq
  showDeleteModal.value = true
}

const closeModal = () => {
  showModal.value = false
  showDeleteModal.value = false
  editingFaq.value = null
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('de-DE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}
</script>