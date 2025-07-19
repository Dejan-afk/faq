<template>
  <div class="faq-accordion">
    <div class="faq-accordion-header">
      <h3>Fragen aus dem <span>Bereich {{ category }}</span></h3>
    </div>

    <article
      v-for="faq in items"
      :key="faq.id"
      class="faq-item"
      :class="{ open: openId === faq.id }"
    >
      <header class="faq-question" @click="toggle(faq.id)">
          <h3 v-html="highlightMatch(faq.question, searchTerm)" />
          <span :class="['faq-toggle-circle', { open: openId === faq.id }]">
              <SvgIcon
              src="icon-chevron-up.svg"
              wrapper-class="faq-toggle-icon"
              />
          </span>
      </header>

      <transition name="accordion">
        <section v-if="openId === faq.id" class="faq-answer" v-html="highlightMatch(faq.answer, searchTerm)" />
      </transition>
    </article>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import SvgIcon from '@/Components/SvgIcon.vue'
import '../../css/accordion.css'

const props = defineProps({
  items: { type: Array, required: true },
  category: { type: String, required: true },
  searchTerm: String,
})

const openId = ref(null)

function toggle(id) {
  openId.value = openId.value === id ? null : id
}
function highlightMatch(text, term) {
  if (!term) return text
  const escaped = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') // regex escape for v-html; prevents xss
  const regex = new RegExp(`(${escaped})`, 'gi')
  return text.replace(regex, '<mark>$1</mark>')
}
</script>