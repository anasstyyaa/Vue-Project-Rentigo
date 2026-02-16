<template>
  <span :class="classes">
    {{ formattedPrice }}
    <span v-if="showPeriod" class="text-xs font-normal text-gray-500"> / day</span>
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  amount: {
    type: [Number, String],
    required: true,
  },
  currency: {
    type: String,
    default: 'USD',
  },
  locale: {
    type: String,
    default: 'en-US',
  },
  showPeriod: {
    type: Boolean,
    default: true,
  }
});

const formattedPrice = computed(() => {
  const price = typeof props.amount === 'string' ? parseFloat(props.amount) : props.amount;

  return new Intl.NumberFormat(props.locale, {
    style: 'currency',
    currency: props.currency,
  }).format(price);
});

const classes = 'font-bold text-lg text-blue-600';
</script>