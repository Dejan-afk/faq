<template>
  <div class="contact">
    <div class="contact-info">
      <p class="contact-lead">Du findest keine Antwort auf deine Frage?</p>
      <p>
        Nimm einfach Kontakt zu uns auf und wir versuchen, so schnell wie möglich dir weiterzuhelfen!
      </p>
    </div>
    <AppButton
      label="Schreibe uns"
      variant="secondary"
      class="contact-button"
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
  width: 100%;
  max-width: 100%;
  padding: 1.5rem 1.2rem;
  background-color: var(--clr-brightgreen-100);
  border: 1px solid #eee;
  border-radius: 1rem;
  gap: 1rem;
  flex-wrap: wrap;
  box-sizing: border-box;
}

.contact-info {
  flex: 1;
  width: 100%;
  max-width: 38rem;
}

.contact-info p {
  margin: 0.3rem 0;
  color: var(--clr-darkgreen-800);
  font-size: 1.25rem;
  line-height: 1.4;
  word-wrap: break-word;
  overflow-wrap: break-word;
  letter-spacing: 0.01rem;
}

.contact-lead {
  font-weight: 700;
  font-size: 1rem;
}

.contact-button {
  flex: 0 0 auto;
  height: 2.5rem;
}
@media (max-width: 480px) {
  .contact {
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 1rem;
    text-align: left;
  }

  .contact-button {
    margin-top: 1rem;
    width: 100%;
    max-width: 16rem;
    justify-content: center;
  }
  .contact-lead {
    font-weight: 700;
    margin-bottom: 0.5rem;
  }
  .contact-info p {
    font-size: 1rem;
  }
}
</style>
