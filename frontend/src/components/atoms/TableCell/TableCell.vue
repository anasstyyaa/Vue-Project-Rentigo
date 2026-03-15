<template>
  <td 
    class="px-6 py-6 whitespace-nowrap text-sm leading-5 transition-colors"
    :class="[
      alignmentClass,
      { 'font-medium text-gray-900': primary, 'text-gray-500': !primary }
    ]"
  >
    <slot />
  </td>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  align: {
    type: String,
    default: 'left',
    validator: (value) => ['left', 'center', 'right'].includes(value)
  },
  primary: {
    type: Boolean,
    default: false
  }
});

const alignmentClass = computed(() => {
  return {
    'text-left': props.align === 'left',
    'text-center': props.align === 'center',
    'text-right': props.align === 'right',
  };
});
</script>