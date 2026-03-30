<template>
  <CarDetailTemplate>
    
    <template #header>
      <Header />
    </template>

    <template #visuals>
      <div v-if="loading" class="h-96 bg-gray-200 animate-pulse rounded-3xl"></div>
      <CarGallery v-else-if="car" :key="car.carId" :images="car.images" />
    </template>

    <template #sidebar>
      <div v-if="loading" class="h-[500px] bg-gray-200 animate-pulse rounded-3xl"></div>
      <CarDetails 
        v-else-if="car" 
        :key="'details-' + car.carId"
        v-bind="car" 
        @rent="handleRentClick" 
      />
    </template>

  </CarDetailTemplate>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { get } from '@/utils/api';

import CarDetailTemplate from '../../templates/CarDetailTemplate/CarDetailTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import CarGallery from '../../molecules/CarGallery/CarGallery.vue';
import CarDetails from '../../organisms/CarDetails/CarDetails.vue';
import TextAtom from '../../atoms/Text/Text.vue';

const route = useRoute();
const router = useRouter();
const car = ref(null);
const loading = ref(true);

onMounted(async () => {
  try {
    const res = await get(`/api/cars/${route.params.id}`);
    const result = await res.json();

    // 1. Safety check: make sure result exists
    if (result && result.carId) {
        
        // 2. Safely handle images array
        let rawImages = result.images;
        
        // If it's a string (sometimes APIs return JSON strings), parse it
        if (typeof rawImages === 'string') {
            try { rawImages = JSON.parse(rawImages); } catch(e) { rawImages = []; }
        }

        if (Array.isArray(rawImages) && rawImages.length > 0) {
            result.images = rawImages.map(img => {
                if (!img) return 'https://placehold.co/800x600?text=Error';
                if (img.startsWith('http')) return img;
                return `http://localhost/${img}`;
            });
        } else {
            result.images = ['https://placehold.co/800x600?text=No+Images+Available'];
        }
        
        car.value = result; 
    }
  } catch (err) {
    console.error("Critical Render Error:", err);
  } finally {
    loading.value = false;
  }
});

const handleRentClick = () => {
  router.push({ name: 'BookingForm', query: { carId: car.value.carId } });
};
</script>