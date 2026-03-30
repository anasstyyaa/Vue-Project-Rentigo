<template>
  <div class="max-w-sm overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all hover:shadow-md">
    <AppImage :src="fullImageUrl" :alt="`${brand} ${model}`" aspect="video" />

    <div class="p-4">
      <div class="mb-2">
        <h3 class="text-xl font-bold text-gray-900 leading-tight">
          {{ brand }} <span class="text-blue-600">{{ model }}</span>
        </h3>
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ year }}</p>
      </div>

      <CarSpecs 
        :transmission="transmission" 
        :fuelType="fuelType" 
        :seats="seats" 
        class="mb-4"
      />

      <hr class="mb-4 border-gray-100" />

      <div class="flex items-center justify-between">
        <PriceDisplay :amount="pricePerDay" />
        
        <button 
          @click="$emit('learn-more-click')"
          class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-blue-700"
        >
          Learn More
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import AppImage from '../../atoms/AppImage/AppImage.vue';
import PriceDisplay from '../../atoms/PriceDisplay/PriceDisplay.vue';
import CarSpecs from '../../molecules/CarSpecs/CarSpecs.vue';

const emit = defineEmits(['learn-more-click']);

const props = defineProps({
  brand: { type: String, required: true },
  model: { type: String, required: true },
  year: { type: [Number, String], required: true },
  mainImage: { type: String, required: true },
  pricePerDay: { type: [Number, String], required: true },
  transmission: { type: String, required: true },
  fuelType: { type: String, required: true },
  seats: { type: [Number, String], required: true },
});


const fullImageUrl = computed(() => {
  if (!props.mainImage) return '/placeholder-car.png'; 
  
  if (props.mainImage.startsWith('http')) return props.mainImage;
  
  return `http://localhost/${props.mainImage}`;
});
</script>