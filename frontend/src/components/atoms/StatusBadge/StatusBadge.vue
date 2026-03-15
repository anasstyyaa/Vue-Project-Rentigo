<template>
  <span 
    :class="[
      'inline-flex items-center px-5 py-1 rounded-full text-xs font-medium',
      statusStyles
    ]"
  >
    <svg class="-ml-0.5 mr-1.5 h-2 w-2" :class="dotColor" fill="currentColor" viewBox="0 0 8 8">
      <circle cx="4" cy="4" r="3" />
    </svg>
    <slot />
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  type: {
    type: String,
    default: 'info',
    validator: (value) => ['success', 'warning', 'danger', 'info'].includes(value)
  }
});

const statusStyles = computed(() => {
  const styles = {
    success: 'bg-green-100 text-green-800 border-green-200',
    danger: 'bg-red-100 text-red-800 border-red-200',
    warning: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    info: 'bg-blue-100 text-blue-800 border-blue-200'
  };
  return styles[props.type];
});

const dotColor = computed(() => {
  const dots = {
    success: 'text-green-400',
    danger: 'text-red-400',
    warning: 'text-yellow-400',
    info: 'text-blue-400'
  };
  return dots[props.type];
});
</script>