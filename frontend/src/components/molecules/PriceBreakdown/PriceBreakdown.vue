<template>
  <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
    <div class="flex justify-between mb-2">
      <TextAtom size="sm" color="muted">
        {{ days > 0 ? days : 1 }} {{ (days > 1) ? 'days' : 'day' }} × ${{ dailyPrice }}
      </TextAtom>
      
      <TextAtom size="sm" weight="bold">
        ${{ subtotal }}
      </TextAtom>
    </div>

    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
      <HeadingAtom :level="3">Amount to Pay</HeadingAtom>
      <TotalPrice :amount="subtotal" label="Total Price" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import TextAtom from '@/components/atoms/Text/Text.vue';
import HeadingAtom from '@/components/atoms/Heading/Heading.vue';
import TotalPrice from '@/components/atoms/TotalPrice/TotalPrice.vue';

const props = defineProps({
  dailyPrice: Number,
  days: Number
});

const lineItemTotal = computed(() => (props.dailyPrice * (props.days || 1)).toFixed(2));
const subtotal = computed(() => {
  const dayCount = props.days > 0 ? props.days : 1; 
  const total = props.dailyPrice * dayCount;
  return total.toFixed(2);
});
</script>