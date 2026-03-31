<template>
  <span :class="[
    'text-base transition-colors',
    colorClasses[color],
    sizeClasses[size],
    weight === 'bold' ? 'font-bold' : 'font-normal'
  ]">
    <slot />
  </span>
</template>

<script setup>
const props = defineProps({
  color: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'primary', 'secondary', 'muted', 'error'].includes(value)
  },
  size: {
    type: String,
    default: 'md'
  },
  weight: {
    type: String,
    default: 'normal'
  }
});


const colorClasses = {
  default: 'text-black',
  primary: 'text-blue-600',
  secondary: 'text-gray-700',
  muted: 'text-gray-400',
  error: 'text-red-500' 
};

const sizeClasses = {
  xs: 'text-xs',
  sm: 'text-sm',
  md: 'text-base',
  lg: 'text-lg',
  xl: 'text-xl'
};
</script>