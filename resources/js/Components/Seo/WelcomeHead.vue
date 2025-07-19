<template>
  <component is="head" v-html="faqLdJson" />

  <Head>
    <title>Häufig gestellte Fragen – DEKRA Neo</title>
    <meta name="description" content="Antworten auf häufige Fragen zu Services, Medien und Zahlungen bei DEKRA." />
    <meta name="keywords" content="DEKRA, Neo, FAQ, Hilfe, Zahlung, Services, Medien, Kontakt, Fragen" />
    <meta property="og:title" content="FAQ – DEKRA Neo" />
    <meta property="og:description" content="Hier findest du Antworten auf häufige Fragen rund um unsere Leistungen." />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="de_DE" />
  </Head>
</template>

<script setup>
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  faqs: { type: Array, required: true }
})

/**
 * Generiert JSON-LD-Schema für FAQPage zur Verbesserung der SEO (strukturierte Daten).
 * Wird im <head> eingebunden und unterstützt Google bei der Anzeige von Rich Results.
 */
const faqLdJson = computed(() => {
  const mainEntity = props.faqs.slice(0, 10).map(faq => ({
    "@type": "Question",
    "name": faq.question,
    "acceptedAnswer": {
      "@type": "Answer",
      "text": faq.answer
    }
  }))

  const json = {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": mainEntity
  }

  return `<${'script'} type="application/ld+json">${JSON.stringify(json)}</${'script'}>`
})
</script>
