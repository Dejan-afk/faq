<template>
  <div>
    <!-- Header -->
    <PageHeader
      title="Fragen Verwaltung"
      :subtitle="`${filtered.length} Fragen insgesamt`"
      v-model="searchTerm"
      :client="true"
      search-placeholder="Fragen"
      action-label="Neue Frage erstellen"
      action-icon="icon-close.svg"
      @action="create"
    />
    <!-- Table -->
    <Table :columns="columns" :items="filtered">
      <template #actions="{ item }">
        <SvgIcon name="edit" @click="edit(item)" class="action-btn" src="icon-edit.svg" />
        <SvgIcon name="delete" @click="destroy(item)" class="action-btn" src="icon-delete.svg" />
        <SvgIcon name="sort-up" @click="sort(item, 'up')" class="action-btn" src="icon-sort-up.svg" />
        <SvgIcon name="sort-down" @click="sort(item, 'down')" class="action-btn" src="icon-sort-down.svg" />
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
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import FaqForm from '@/Components/Admin/Faq/FaqForm.vue'
import DeleteModal from '@/Components/Admin/DeleteModal.vue'
import Table from '@/Components/Table.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import '../../../css/faq.css'
import SvgIcon from '@/Components/SvgIcon.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({ 
    faqs: Array,
    tags: Array,
    categories: Array,
    //remove warns for now
    errors: Object,
    auth: Object,
    flash: Object,
    title: String,
    description: String
})

const columns = [
  { key: 'question', label: 'Frage' },
  { key: 'category', label: 'Kategorie' },
  { key: 'created_at', label: 'Erstellt am' },
]

const showModal = ref(false)
const showDeleteModal = ref(false)
const editingFaq = ref(null)
const searchTerm = ref('')

const create = () => {
  editingFaq.value = null
  showModal.value = true
}

const edit = (faq) => {
  editingFaq.value = { ...faq }
  showModal.value = true
}

const destroy = (faq) => {
  editingFaq.value = faq
  showDeleteModal.value = true
}

const sort = (item, direction) => {
  router.post(route('faqs.sort', item.id), {
    direction,
  }, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
  })
}

const closeModal = () => {
  showModal.value = false
  showDeleteModal.value = false
  editingFaq.value = null
}

/**
 * Filtert Fragen und Antworten im Akkordion clientseitig.
 * Über Funktionalität kann man diskutieren. 
 */
const filtered = computed(() => {
  const search = searchTerm.value.toLowerCase().trim()
  if (!search) return props.faqs

  const words = search.split(/\s+/)

  return props.faqs.filter(faq => {
    const text = [faq.question, faq.answer, ...(faq.tags || [])].join(' ').toLowerCase()
    return words.every(word => text.includes(word))
  })
})
</script>