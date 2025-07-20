import { ref } from 'vue'

const faqs = ref(null)
const categories = ref(null)

export const useFaqStore = () => {
  return {
    faqs,
    categories,
    setFaqs(data) {
      faqs.value = data
    },
    setCategories(data) {
      categories.value = data
    },
    clear() {
      faqs.value = null
      categories.value = null
    }
  }
}
