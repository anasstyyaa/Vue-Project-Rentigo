<template>
  <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 w-full max-w-2xl mx-auto">
    <div class="mb-8 pb-6 border-b border-gray-100">
      <CarInfoSummary 
        :image="carImage"
        :brand="carBrand"
        :model="carModel"
        :year="carYear"
        :transmission="carTransmission"
      />
    </div>

    <div class="flex flex-col gap-8">
      <DateRangePicker 
        v-model:start="formData.startDate" 
        v-model:end="formData.endDate" 
      />

      <PriceBreakdown 
        :dailyPrice="carPrice" 
        :days="calculatedDays" 
      />

      <div class="pt-4">
        <MyButton 
          label="Confirm & Rent Now" 
          class="w-full h-14 text-lg shadow-lg shadow-black/10"
          :loading="loading"
          :disabled="calculatedDays < 1"
          @click="handleConfirm"
        />
        
        <TextAtom v-if="error" color="error" size="sm" class="mt-4 text-center font-medium">
          {{ error }}
        </TextAtom>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import CarInfoSummary from '@/components/molecules/CarInfoSummary/CarInfoSummary.vue';
import DateRangePicker from '@/components/molecules/DateRangePicker/DateRangePicker.vue';
import PriceBreakdown from '@/components/molecules/PriceBreakdown/PriceBreakdown.vue';
import MyButton from '@/components/atoms/Button/Button.vue';
import TextAtom from '@/components/atoms/Text/Text.vue';

const props = defineProps({
  // Car Data for the Summary
  carImage: String,
  carBrand: String,
  carModel: String,
  carYear: [Number, String],
  carTransmission: String,
  carPrice: { type: Number, required: true },
  loading: Boolean,
  error: String
});

const emit = defineEmits(['confirm']);

const formData = ref({
  startDate: new Date().toISOString().split('T')[0],
  endDate: ''
});

const calculatedDays = computed(() => {
  if (!formData.value.startDate || !formData.value.endDate) return 0;
  const start = new Date(formData.value.startDate);
  const end = new Date(formData.value.endDate);
  const diff = end - start;
  const days = Math.ceil(diff / (1000 * 60 * 60 * 24));
  return days > 0 ? days : 0;
});

const handleConfirm = () => {
  emit('confirm', {
    startDate: formData.value.startDate,
    endDate: formData.value.endDate,
    totalDays: calculatedDays.value,
    totalPrice: (calculatedDays.value * props.carPrice).toFixed(2)
  });
};
</script>