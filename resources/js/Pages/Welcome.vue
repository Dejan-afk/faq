<template>
  <section class="tabs-section" aria-label="Themenbereiche">
    <CategoryTabs
      :categories="categories"
      :selected-id="selectedCategory"
      @select="selectedCategory = $event"
    />
  </section>

  <section aria-label="Häufig gestellte Fragen">
    <FaqAccordion 
      :items="filtered" 
      :category="formatCategoryName(selectedCategory)"
      :search-term="searchTerm"
    />
  </section>

  <section aria-label="Kontaktformular">
    <FaqContact />
  </section>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CategoryTabs from '@/Components/CategoryTabs.vue'
import FaqAccordion from '@/Components/FaqAccordion.vue';
import { ref, computed, inject } from 'vue'
import '../../css/welcome.css'
import FaqContact from '@/Components/FaqContact.vue';

defineOptions({ layout: AppLayout })

const props = defineProps({
    faqs: Array,
    categories: Array,
});

const selectedCategory = ref(props.categories[0]?.id || null);
const searchTerm = inject('searchTerm')

/**
 * Filtert Fragen und Antworten im Akkordion clientseitig.
 * Fragen bleiben pro Kategorie aufgeteilt; dementsprechend Ergebnisse
 * auch nur angezeigt, wenn die richtige Kategorie ausgewählt ist. 
 * 
 * Über Funktionalität kann man diskutieren. 
 * UX-Idee: highlighten der Kategorie-Tabs (ggfs. kleine Zahl oder Punkt)
 */
const filtered = computed(() => {
  return props.faqs.filter(faq => {
    const matchesCategory =
      selectedCategory.value === null || faq.category_id === selectedCategory.value

    const matchesSearch =
      !searchTerm.value ||
      [faq.question, faq.answer, ...(faq.tags || [])]
        .join(' ')
        .toLowerCase()
        .includes(searchTerm.value.toLowerCase())

    return matchesCategory && matchesSearch
  })
})

const formatCategoryName = (id) => {
  const name = props.categories.find(c => c.id === id)?.name;
  return name === 'Services' ? 'Service' : name || 'All Categories'
}
</script>
