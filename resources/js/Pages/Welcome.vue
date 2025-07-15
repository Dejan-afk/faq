<template>
  <!-- Tabs -->
  <CategoryTabs
    :categories="categories"
    :selected-id="selectedCategory"
    @select="selectedCategory = $event"
  />

  <!-- Accordion -->
  <FaqAccordion :items="filtered" />

  <!-- Contact -->
  <section class="contact">
    <div class="contact-info">
      <h2>Du findest keine Antwort auf deine Frage?</h2>
      <p>Nimm einfach Kontakt zu uns auf und wir versuchen so schnell wie möglich dir weiter zu helfen!</p>
    </div>
    <button class="btn-contact" style="display: inline-block;"> <!-- Todo: Dark Button Component -->
      <SvgIcon src="icon-email.svg" wrapper-class="icon-contact" />
      <span>Kontakt</span>
    </button>
  </section>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CategoryTabs from '@/Components/CategoryTabs.vue'
import FaqAccordion from '@/Components/FaqAccordion.vue';
import { ref, computed } from 'vue'
import '../../css/welcome.css'

defineOptions({ layout: AppLayout })

const props = defineProps({
    faqs: Array,
    categories: Array,
});

const selectedCategory = ref(props.categories[0]?.id || null);

/* gefilterte FAQs */
const filtered = computed(() =>
  props.faqs.filter(f => selectedCategory.value === null
    ? true
    : f.category_id === selectedCategory.value)
)
</script>
