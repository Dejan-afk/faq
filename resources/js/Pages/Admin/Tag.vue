<template>
    <!-- Header -->
    <PageHeader
      title="Tag Verwaltung"
      :subtitle="`${tags.length} Tags insgesamt`"
      search-placeholder="Tags"
      action-label="Neuen Tag erstellen"
      action-icon="icon-close.svg"
      @action="create"
    />
    <!-- Table -->
    <Table :columns="columns" :items="tags">
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
import AppLayout from '@/Layouts/AppLayout.vue'
import TagForm from '@/Components/Admin/Tag/TagForm.vue'
import DeleteModal from '@/Components/Admin/DeleteModal.vue'
import { ref } from 'vue'
import '../../../css/tag.css'
defineOptions({ layout: AppLayout })
defineProps({
    tags: Array,
})
const columns = [
  { key: 'name', label: 'Name' },
  { key: 'created_at', label: 'Erstellt am' },
]
const showModal = ref(false)
const showDeleteModal = ref(false)
const editingTag = ref(null)

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
</script>