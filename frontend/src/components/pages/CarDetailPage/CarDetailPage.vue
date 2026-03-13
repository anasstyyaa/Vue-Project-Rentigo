<template>
  <CarDetailTemplate>
    
    <template #header>
      <Header />
    </template>

    <template #visuals>
      <div v-if="loading" class="h-96 bg-gray-200 animate-pulse rounded-3xl"></div>
      <CarGallery v-else-if="car" :images="car.images || []" />
    </template>

    <template #sidebar>
      <div v-if="loading" class="h-[500px] bg-gray-200 animate-pulse rounded-3xl"></div>
      <CarDetails 
        v-else-if="car" 
        v-bind="car" 
        @rent="handleRentClick" 
      />
    </template>

    <!-- <template #details v-if="car">
       <div class="p-6 bg-blue-50 rounded-2xl border border-blue-100">
         <TextAtom size="sm" color="primary" weight="semibold">
           Pro Tip: Rent for more than 7 days to get a 10% discount!
         </TextAtom>
       </div>
    </template> -->

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

    if (result && result.carId) {
        if (!result.images || result.images.length === 0) {
            result.images = ['https://placehold.co/800x600?text=No+Images+Available'];
        }
        car.value = result; 
    } else {
        console.error("Data received but carId is missing:", result);
    }
    } catch (err) {
        console.error("Connection lost or JSON parse error:", err);
    } finally {
        loading.value = false;
    }
});

const handleRentClick = () => {
  router.push({ name: 'BookingForm', query: { carId: car.value.carId } });
};
</script>