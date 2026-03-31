<template>
  <div class="flex flex-col items-end">
    <span v-if="label" class="text-xs text-gray-500 uppercase font-black tracking-widest mb-1">
      {{ label }}
    </span>
    <span :class="[
      'font-black text-black leading-none',
      size === 'lg' ? 'text-3xl' : 'text-xl'
    ]">
      ${{ formattedAmount }}
    </span>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  amount: { type: [Number, String], default: 0 },
  label: { type: String, default: 'Total' },
  size: { type: String, default: 'lg' } // 'md' or 'lg'
});

const formattedAmount = computed(() => {
  const num = parseFloat(props.amount);
  return isNaN(num) ? '0.00' : num.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
});
</script>