<template>
  <div>
    <h1>FAQ Übersicht</h1>

    <ul>
      <li v-for="faq in faqs" :key="faq.id">
        <strong>{{ faq.question }}</strong><br>
        <span>{{ faq.answer }}</span>
      </li>
    </ul>
  </div>
</template>

<script setup>
    defineProps({
        faqs: Array,
    });
</script>
