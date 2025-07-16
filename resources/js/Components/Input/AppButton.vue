<template>
  <component
    :is="as"
    :href="href"
    :type="as === 'button' ? type : undefined"
    :class="[baseClass, variantClass]"
    @click="onClick"
  >
    <SvgIcon
      v-if="icon"
      :src="icon"
      :wrapper-class="iconClass"
    />
    <span>{{ label }}</span>
  </component>
</template>

<script setup>
import SvgIcon from '@/Components/SvgIcon.vue'
import '../../../css/app-button.css'

const props = defineProps({
  label: { type: String, required: true },
  icon: { type: String, default: null },
  href: { type: String, default: null },
  as: { type: String, default: 'button' }, // 'a' oder 'button'
  type: { type: String, default: 'button' },
  variant: { type: String, default: 'primary' }, // 'primary' | 'secondary'
})

const emit = defineEmits(['click'])

const onClick = (e) => emit('click', e)

const baseClass = 'app-button'
const iconClass = `app-button-icon--${props.variant}`
const variantClass = `app-button--${props.variant}`
</script>
