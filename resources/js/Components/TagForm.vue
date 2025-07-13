<template>
  <form @submit.prevent="submit">
    <input v-model="form.name" />
    <button type="submit">Speichern</button>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import '../../css/tagForm.css'

const props = defineProps({ tag: Object })

const form = useForm({
  name: props.tag?.name || '',
})

const submit = () => {
  props.tag
    ? form.put(route('tags.update', props.tag.id))
    : form.post(route('tags.store'))
}
</script>
