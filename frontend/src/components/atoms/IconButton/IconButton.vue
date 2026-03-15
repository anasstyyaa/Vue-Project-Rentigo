<template>
  <button 
    type="button"
    :class="[
      'inline-flex items-center justify-center rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2',
      sizeClasses,
      variantStyles
    ]"
    @click="$emit('click', $event)"
  >
    <span class="sr-only">{{ label }}</span>
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'neutral',
    validator: (value) => ['primary', 'danger', 'neutral'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md'].includes(value)
  },
  label: {
    type: String,
    required: true
  }
});

defineEmits(['click']);

const variantStyles = computed(() => {
  const styles = {
    primary: 'text-blue-600 hover:bg-blue-50 hover:text-blue-700 focus:ring-blue-500',
    danger: 'text-red-600 hover:bg-red-50 hover:text-red-700 focus:ring-red-500',
    neutral: 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:ring-gray-400'
  };
  return styles[props.variant];
});

const sizeClasses = computed(() => {
  return props.size === 'sm' ? 'p-1.5' : 'p-2';
});
</script>