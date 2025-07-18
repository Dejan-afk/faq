<template>
  <component
    :is="as"
    :href="href"
    :type="as === 'button' ? type : undefined"
    :class="[baseClass, variantClass, props.class]"
    @click="onClick"
  >
    <!-- grüner Kreis-Wrapper -->
    <div
      v-if="variant === 'dark-icon'"
      class="app-button-icon-circle"
    >
      <SvgIcon
        v-if="icon"
        :src="icon"
        :wrapper-class="iconClass"
        :style="rotateIconStyle"
      />
    </div>

    <!-- Normaler Icon-Wrapper -->
    <SvgIcon
      v-else-if="icon"
      :src="icon"
      :wrapper-class="iconClass"
      :style="rotateIconStyle"
    />

    <span>{{ label }}</span>
  </component>
</template>

<script setup>
import { computed } from 'vue'
import SvgIcon from '@/Components/SvgIcon.vue'
import '../../../css/app-button.css'

const props = defineProps({
  label: { type: String, required: true },
  icon: { type: String, default: null },
  href: { type: String, default: null },
  as: { type: String, default: 'button' }, // 'a' oder 'button'
  type: { type: String, default: 'button' },
  variant: { type: String, default: 'primary' }, // 'primary' | 'secondary' | 'dark'
  rotateIcon: { type: [String, Number], default: null },
})

const emit = defineEmits(['click'])

const onClick = (e) => emit('click', e)

const baseClass = 'app-button'
const iconClass = `app-button-icon--${props.variant}`
const variantClass = `app-button--${props.variant}`

const rotateIconStyle = computed(() =>
  props.rotateIcon ? { transform: `rotate(${props.rotateIcon}deg)` } : {}
)

</script>
