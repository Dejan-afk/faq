<template>
    <!-- Header -->
    <PageHeader
      title="Tag Verwaltung"
      :subtitle="`${filteredTags.length} Tags insgesamt`"
      v-model="searchTerm"
      :client="true"
      search-placeholder="Tags"
      action-label="Neuen Tag erstellen"
      action-icon="icon-close.svg"
      @action="create"
    />
    <!-- Table -->
    <Table :columns="columns" :items="filteredTags">
      <template #actions="{ item }">
        <SvgIcon name="edit" @click="edit(item)" class="action-btn" src="icon-edit.svg" />
        <SvgIcon name="delete" @click="destroy(item)" class="action-btn" src="icon-delete.svg" />
      </template>
    </Table>

    <!-- MODAL -->
    <TagForm
      :show="showModal"
      :tag="editingTag"
      :tags="tags ?? []"
      @close="closeModal"
    />

    <!-- Delete Confirmation Modal -->
    <DeleteModal
      :show="showDeleteModal"
      :item="editingTag"
      @close="closeModal"
    />
</template>

<script setup>
import SvgIcon from '@/Components/SvgIcon.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import Table from '@/Components/Table.vue'
import TagForm from '@/Components/Admin/Tag/TagForm.vue'
import DeleteModal from '@/Components/Admin/DeleteModal.vue'
import { ref, computed } from 'vue'
import '../../../css/tag.css'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
    tags: Array,
    //remove warns for now
    errors: Object,
    auth: Object,
    flash: Object,
    title: String,
    description: String
})

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'created_at', label: 'Erstellt am' },
]

const showModal = ref(false)
const showDeleteModal = ref(false)
const editingTag = ref(null)
const searchTerm = ref('')


const create = () => {
  editingTag.value = null
  showModal.value = true
}

const edit = (tag) => {
  console.log("edit with tag: ", tag)
  editingTag.value = { ...tag } // Kopie zur Sicherheit
  showModal.value = true
}
const destroy = (tag) => {
  editingTag.value = tag
  showDeleteModal.value = true
}

const closeModal = () => {
  showModal.value = false
  showDeleteModal.value = false
  editingTag.value = null
}

/**
 * Filtert Fragen und Antworten im Akkordion clientseitig.
 * Über Funktionalität kann man diskutieren. 
 */
const filteredTags = computed(() => {
  const search = searchTerm.value.toLowerCase().trim()
  if (!search) return props.tags

  const words = search.split(/\s+/)

  return props.tags.filter(tag => {
    return words.every(word => tag.name.toLowerCase().includes(word))
  })
})
</script>