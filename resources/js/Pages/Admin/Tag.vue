<template>
    <div class="tag-admin">
        <h1>Tag Administration</h1>
    </div>

    <button @click="create">Neuen Tag erstellen</button>

    <TableComponent
        :headers="[
            { key: 'name', label: 'Tag-Name' },
            { key: 'created_at', label: 'Erstellt am' },
        ]"
        :items="tags"
        >
        <template #cell-created_at="{ value }">
            {{ formatDate(value) }}
        </template>

        <template #actions="{ item }">
            <button @click="edit(item)">Bearbeiten</button>
            <button @click="destroy(item)">Löschen</button>
        </template>
    </TableComponent>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
defineOptions({ layout: AppLayout })
defineProps({
    tags: Array,
})
// MODAL-Zustände
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

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('de-DE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}
</script>

<style scoped>
.tag-admin {
    padding: 1rem;
}
</style>