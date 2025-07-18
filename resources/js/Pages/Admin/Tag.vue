<template>
    <div class="tag-admin">
        <h1>Tag Administration</h1>
    </div>

    <button @click="create">Neuen Tag erstellen</button>

    <Table :columns="columns" :items="tags">
      <template #actions="{ item }">
        <SvgIcon name="edit" @click="edit(item)" class="action-btn" src="icon-edit.svg" />
        <SvgIcon name="delete" @click="destroy(item)" class="action-btn" src="icon-delete.svg" />
      </template>
    </Table>
</template>

<script setup>
import SvgIcon from '@/Components/SvgIcon.vue'
import Table from '@/Components/Table.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
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
const editingTag = ref(null)

const create = () => {
  editingTag.value = null
  showModal.value = true
}

const edit = (tag) => {
  editingTag.value = { ...tag } // Kopie zur Sicherheit
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingTag.value = null
}
</script>

<style scoped>
.tag-admin {
    padding: 1rem;
}
</style>