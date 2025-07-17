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
import { ref, computed } from 'vue'
import '../../css/welcome.css'
import FaqContact from '@/Components/FaqContact.vue';

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
</script>
