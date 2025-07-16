<template>
  <div class="contact">
    <div class="contact-info">
      <p class="contact-lead">Du findest keine Antwort auf deine Frage?</p>
      <p>
        Nimm einfach Kontakt zu uns auf und wir versuchen, so schnell wie möglich dir weiterzuhelfen!
      </p>
    </div>
    <AppButton
      label="Kontakt aufnehmen"
      variant="secondary"
      icon="icon-email.svg"
      as="button"
      @click="alertMail"
    />
  </div>
</template>

<script setup>
import AppButton from '@/Components/Input/AppButton.vue'

const alertMail = () => alert('Kontaktformular wird bald verfügbar sein!')
</script>

<style scoped>
.contact {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.2rem;
  background-color: var(--clr-brightgreen-100);
  border: 1px solid #eee;
  border-radius: 0.5rem;
  gap: 1rem;
  flex-wrap: wrap; /* für Mobile fallback */
}

.contact-info {
  flex: 1;
  min-width: 250px;
}

.contact-info p {
  margin: 0.3rem 0;
  color: var(--clr-darkgreen-500);
  font-size: 0.95rem;
  line-height: 1.4;
}

.contact-lead {
  font-weight: 700;
  font-size: 1rem;
}
</style>
