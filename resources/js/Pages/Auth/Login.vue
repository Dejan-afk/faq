<script setup>
import { reactive } from 'vue'
import { useForm, Head, Link } from '@inertiajs/vue3'

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <form @submit.prevent="submit">
    <input v-model="form.email" placeholder="Email" />
    <input v-model="form.password" type="password" placeholder="Passwort" />
    <button type="submit">Login</button>
  </form>
</template>
