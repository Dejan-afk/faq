<template>
  <WelcomeHead v-if="!isLoading" :faqs="store.faqs.value" />

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
import { ref, computed, inject, onMounted, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import CategoryTabs from '@/Components/CategoryTabs.vue'
import FaqAccordion from '@/Components/FaqAccordion.vue';
import FaqContact from '@/Components/FaqContact.vue';
import WelcomeHead from '@/Components/Seo/WelcomeHead.vue';
import { useFaqStore } from '@/Stores/useFaqStore';
import '../../css/welcome.css'


defineOptions({ layout: AppLayout })

const props = defineProps({
    faqs: Array,
    categories: Array,
    initialCategoryId: String | Number,
    //remove warns for now
    errors: Object,
    auth: Object,
    flash: Object,
    title: String,
    description: String
});

const isLoading = ref(true)
const store = useFaqStore()
store.setCategories(props.categories)
const selectedCategory = ref(props.categories[0]?.id || null);
const loadedFaqs = ref({ [props.initialCategoryId]: props.faqs })
const searchTerm = inject('searchTerm')

/* Führt sequentiell geladene FAQs wieder zusammen für Suchfeld */
const allFaqs = computed(() => {
  return Object.values(loadedFaqs.value).flat()
})

/* Wenn alle FAQs geladen in den Speicher packen 
*  UseCase war anders gedacht. Jetzt für SEO + Lazy-Loading verwendet
*/
watch(allFaqs, (val) => {
  if (val.length > 0) {
    store.setFaqs(val)
  }
  isLoading.value = false
}, { immediate: true })

/**
 * Filtert Fragen und Antworten im Akkordion clientseitig.
 * Fragen bleiben pro Kategorie aufgeteilt; dementsprechend Ergebnisse
 * nur angezeigt, wenn die richtige Kategorie ausgewählt ist. 
 * 
 * Über Funktionalität kann man diskutieren. 
 * UX-Idee: highlighten der Kategorie-Tabs (ggfs. kleine Zahl oder Punkt)
 */
const filtered = computed(() => {
  return allFaqs.value.filter(faq => {
    const searching = !!searchTerm.value?.trim()
    const searchWords = searchTerm.value.toLowerCase().split(/\s+/)

    const text = [faq.question, faq.answer, ...(faq.tags || [])]
      .join(' ')
      .toLowerCase()

    const matchesSearch = !searching || searchWords.every(word => text.includes(word))

    const matchesCategory = !searching && (
      selectedCategory.value === null || faq.category_id === selectedCategory.value
    )

    return (matchesCategory || searching) && matchesSearch
  })
})


/**
 * Lädt FAQs sequentiell nach dem Rendern für schnellere UI/UX
 */
onMounted(async () => {
  for (const category of props.categories) {
    const id = category.id
    if (id === props.initialCategoryId) continue
    if (!loadedFaqs.value[id]) {
      try {
        const response = await fetch(`/api/faqs?category_id=${id}`)
        if (!response.ok) throw new Error(`Fehler beim Laden von Kategorie ${id}`)
        const data = await response.json()
        loadedFaqs.value[id] = data
      } catch (error) {
        console.error(error)
      }
    }
  }
})

const formatCategoryName = (id) => {
  const name = props.categories.find(c => c.id === id)?.name;
  return name === 'Services' ? 'Service' : name || 'All Categories'
}
</script>