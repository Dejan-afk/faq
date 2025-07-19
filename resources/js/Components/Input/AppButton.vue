<template>
  <component
    :is="as"
    :href="href"
    :type="as === 'button' ? type : undefined"
    :class="[baseClass, variantClass, props.class]"
    @click="onClick"
  >
    <!-- REVERSE: Label zuerst -->
    <template v-if="reverse">
      <span>{{ label }}</span>
      <SvgIcon
        v-if="icon"
        :src="icon"
        :wrapper-class="iconClass"
        :style="rotateIconStyle"
      />
    </template>

    <!-- Normal: Icon zuerst -->
    <template v-else>
      <template v-if="variant === 'dark-icon'">
        <div class="app-button-icon-circle">
          <SvgIcon
            v-if="icon"
            :src="icon"
            :wrapper-class="iconClass"
            :style="rotateIconStyle"
          />
        </div>
      </template>
      <template v-else>
        <SvgIcon
          v-if="icon"
          :src="icon"
          :wrapper-class="iconClass"
          :style="rotateIconStyle"
        />
      </template>
      <span>{{ label }}</span>
    </template>
  </component>
</template>

<script setup>
import { computed } from 'vue'
import SvgIcon from '@/Components/SvgIcon.vue'
import '../../../css/app-button.css'

const props = defineProps({
  label: { type: String, default: '' },
  icon: { type: String, default: null },
  href: { type: String, default: null },
  as: { type: String, default: 'button' },
  type: { type: String, default: 'button' },
  variant: { type: String, default: 'none' }, // 'primary', 'secondary', 'dark-icon', 'none'.
  rotateIcon: { type: [String, Number], default: null },
  reverse: { type: Boolean, default: false }, 
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
