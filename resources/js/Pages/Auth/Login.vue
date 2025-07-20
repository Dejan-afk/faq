<template>
  <main class="login-page">
    <Head title="Login" />

    <div class="login-card">
      <h1>Anmelden</h1>

      <p class="login-subline">Bitte melde dich mit deinen Zugangsdaten an.</p>

      <form @submit.prevent="submit" class="login-form">
        <input
          v-model="form.email"
          type="email"
          placeholder="E-Mail-Adresse"
          required
        />
        <p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p>
        <input
          v-model="form.password"
          type="password"
          placeholder="Passwort"
          required
        />
        <p v-if="form.errors.password" class="form-error">{{ form.errors.password }}</p>

        <label class="remember">
          <input type="checkbox" v-model="form.remember" />
          Angemeldet bleiben
        </label>

        <button type="submit" :disabled="form.processing">
          Anmelden
        </button>

        <p v-if="status" class="status-msg">{{ status }}</p>

        <Link href="/" class="back-link">Zurück zur Startseite</Link>
      </form>
    </div>
  </main>
</template>

<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'

defineProps({
  status: String,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>
<style scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: var(--clr-darkgreen-800);
  padding: 2rem;
}

.login-card {
  background-color: white;
  padding: 2.5rem 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  max-width: 420px;
  width: 100%;
  text-align: center;
}

.login-card h1 {
  margin-bottom: 0.5rem;
  font-size: 1.8rem;
  color: var(--clr-darkgreen-800);
}

.login-subline {
  margin-bottom: 1.5rem;
  font-size: 0.95rem;
  color: #444;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.login-form input[type="email"],
.login-form input[type="password"] {
  padding: 0.65rem 0.9rem;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

.login-form .remember {
  font-size: 0.9rem;
  color: #333;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.login-form button {
  background-color: var(--clr-brightgreen-200);
  color: var(--clr-darkgreen-800);
  font-weight: 600;
  border: none;
  border-radius: 6px;
  padding: 0.65rem 1.2rem;
  cursor: pointer;
  transition: background 0.2s ease;
}

.login-form button:hover {
  background-color: #b6f3b3;
}

.status-msg {
  margin-top: 1rem;
  color: red;
  font-size: 0.9rem;
}

.back-link {
  margin-top: 1.5rem;
  display: inline-block;
  font-size: 0.9rem;
  color: var(--clr-darkgreen-800);
  text-decoration: underline;
}

</style>