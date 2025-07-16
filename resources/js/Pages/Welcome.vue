<template>
  <!-- Tabs -->
  <CategoryTabs
    :categories="categories"
    :selected-id="selectedCategory"
    @select="selectedCategory = $event"
  />

  <!-- Accordion  TODO: error-handling -->
  <FaqAccordion 
    :items="filtered" 
    :category="formatCategoryName(selectedCategory)"
  />

  <!-- Contact -->
  <section class="contact">
    <div class="contact-info">
      <h2>Du findest keine Antwort auf deine Frage?</h2>
      <p>Nimm einfach Kontakt zu uns auf und wir versuchen so schnell wie möglich dir weiter zu helfen!</p>
    </div>
    <AppButton
      label="Kontakt aufnehmen"
      variant="secondary"
      icon="icon-email.svg"
      as="button"
      @click="alertMail"
    />
  </section>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CategoryTabs from '@/Components/CategoryTabs.vue'
import FaqAccordion from '@/Components/FaqAccordion.vue';
import { ref, computed } from 'vue'
import '../../css/welcome.css'
import AppButton from '@/Components/Input/AppButton.vue';

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

const formatCategoryName = (id) => {
  const name = props.categories.find(c => c.id === id)?.name;
  return name === 'Services' ? 'Service' : name || 'All Categories'
}
const alertMail = () => alert('Kontaktformular wird bald verfügbar sein!')
</script>
