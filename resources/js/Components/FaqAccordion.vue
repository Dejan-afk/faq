<template>
  <div class="faq-accordion">
    <div class="faq-accordion-header">
      <p>Fragen aus dem Bereich {{ category }}</p>
    </div>
    <article
      v-for="faq in items"
      :key="faq.id"
      class="faq-item"
      :class="{ open: openId === faq.id }"
    >
    <header class="faq-question" @click="toggle(faq.id)">
        <h3>{{ faq.question }}</h3>
        <span :class="['faq-toggle-circle', { open: openId === faq.id }]">
            <SvgIcon
            src="icon-chevron-up.svg"
            wrapper-class="faq-toggle-icon"
            />
        </span>
    </header>


      <transition name="accordion">
        <section v-if="openId === faq.id" class="faq-answer">
          {{ faq.answer }}
        </section>
      </transition>
    </article>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import SvgIcon from '@/Components/SvgIcon.vue'

const props = defineProps({
  items: { type: Array, required: true },
  category: { type: String, required: true },
})

const openId = ref(null)

function toggle(id) {
  openId.value = openId.value === id ? null : id
}
</script>

<style scoped>
.faq-accordion {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.faq-item {
  background: var(--clr-gray-50);
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 1px 4px rgb(0 0 0 / 8%);
}

.faq-question {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  padding: 0.9rem 1.2rem;
  background: var(--clr-gray-50);
}

.faq-question h3 {
  margin: 0;
  font-size: 0.95rem;
  font-weight: 600;
  color: var(--clr-darkgreen-800);
}

.faq-toggle-circle {
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--clr-darkgreen-800);
  border-radius: 50%;
  width: 1.75rem;
  height: 1.75rem;
  transition: all 0.3s ease;
}

.faq-toggle-circle.open {
  background: var(--clr-brightgreen-200);
}

.faq-toggle-icon svg {
  width: 0.9rem;
  height: 0.9rem;
  fill: white;
  transition: transform 0.3s ease;
}

/* Drehung, wenn offen */
.faq-toggle-circle.open .faq-toggle-icon svg {
  transform: rotate(180deg);
}

.faq-answer {
  padding: 0.8rem 1.2rem 1.2rem;
  background: var(--clr-brand-primary);
  color: var(--clr-white);
  border-radius: 0 0 0.5rem 0.5rem;
  line-height: 1.45;
  font-size: 0.9rem;
}

/* Transition‑Effekt */
.accordion-enter-from,
.accordion-leave-to {
  max-height: 0;
  opacity: 0;
}

.accordion-enter-to,
.accordion-leave-from {
  max-height: 400px;
  opacity: 1;
}

.accordion-enter-active,
.accordion-leave-active {
  transition: max-height 0.25s ease, opacity 0.25s ease;
}
</style>
