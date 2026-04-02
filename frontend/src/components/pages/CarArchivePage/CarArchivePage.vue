<template>
  <div v-if="loading" class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
      <p class="text-gray-600 font-medium">Checking availability...</p>
    </div>
  </div>

  <div v-else-if="error" class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center px-4">
      <p class="text-red-500 text-lg mb-4">{{ error }}</p>
      <button @click="fetchCars" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Try Again</button>
    </div>
  </div>
  <CarArchive
    v-else
    :cars="filteredCars"
    v-model:search="searchQuery"
    v-model:filters="filters"
    v-model:sort="sortBy"
    @learn-more-click="goToDetailPage"
  />

</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref, onMounted, computed } from "vue";
import CarArchive from "../../templates/CarArchive/CarArchive.vue";
import { get } from "../../../utils/api.js";

const router = useRouter();
const cars = ref([]);
const loading = ref(true);
const error = ref(null);

const searchQuery = ref('');
const sortBy = ref('price_asc');
const filters = ref({
  maxPrice: 500,
  transmission: 'all',
  fuel: 'all',
  seats: 'all',
  onlyAvailable: false
});

const fetchCars = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await get("/api/cars"); 

    if (!response.ok) {
      throw new Error(`Error ${response.status}: Failed to load the fleet.`);
    }

    const data = await response.json();
    cars.value = data;
  } catch (err) {
    error.value = err.message;
  } finally {
    loading.value = false;
  }
};

const filteredCars = computed(() => {
  let result = [...cars.value];
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(car => 
      car.brand?.toLowerCase().includes(query) || 
      car.model?.toLowerCase().includes(query)
    );
  }
  result = result.filter(car => Number(car.pricePerDay) <= filters.value.maxPrice);

  if (filters.value.transmission !== 'all') {
    result = result.filter(car => car.transmission === filters.value.transmission);
  }

  if (filters.value.fuel !== 'all') {
    result = result.filter(car => car.fuelType === filters.value.fuel);
  }

  if (filters.value.seats !== 'all') {
    result = result.filter(car => car.seats >= Number(filters.value.seats));
  }

  if (filters.value.onlyAvailable) {
    result = result.filter(car => car.status === 'available');
  }

  if (sortBy.value === 'price_asc') {
    result.sort((a, b) => a.pricePerDay - b.pricePerDay);
  } else if (sortBy.value === 'price_desc') {
    result.sort((a, b) => b.pricePerDay - a.pricePerDay);
  }

  return result;
});

const goToDetailPage = (id) => {
  router.push({ path: `/cars/${id}` });
};

onMounted(fetchCars);
</script>