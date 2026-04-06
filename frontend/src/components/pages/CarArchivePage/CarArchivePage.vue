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

  <div class="flex justify-center space-x-4 py-8 bg-gray-50">
    <button 
      :disabled="currentPage === 1"
      @click="fetchCars(currentPage - 1)"
      class="px-4 py-2 bg-white border rounded shadow-sm disabled:opacity-50"
    >
      Previous
    </button>
    
    <span class="py-2 text-gray-600">
      Page {{ currentPage }} of {{ pagination.totalPages }}
    </span>

    <button 
      :disabled="currentPage === pagination.totalPages"
      @click="fetchCars(currentPage + 1)"
      class="px-4 py-2 bg-white border rounded shadow-sm disabled:opacity-50"
    >
      Next
    </button>
  </div>
  <Footer/>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref, onMounted, computed } from "vue";
import CarArchive from "../../templates/CarArchive/CarArchive.vue";
import { get } from "../../../utils/api.js";
import Footer from "../../organisms/Footer/Footer.vue"; 

const router = useRouter();
const cars = ref([]);
const pagination = ref({}); 
const currentPage = ref(1);
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

const fetchCars = async (page = 1) => {
  loading.value = true;
  error.value = null;
  currentPage.value = page;

  try {
    const response = await get(`/api/cars?page=${page}&limit=9`); 

    if (!response.ok) {
      throw new Error(`Error ${response.status}: Failed to load the fleet.`);
    }

    const result = await response.json();
    cars.value = result.data || []; 
    pagination.value = result.meta || {};
    
  } catch (err) {
    error.value = err.message;
  } finally {
    loading.value = false;
  }
};

const filteredCars = computed(() => {
  const sourceData = Array.isArray(cars.value) ? cars.value : [];
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

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(car => 
      car.brand?.toLowerCase().includes(query) || 
      car.model?.toLowerCase().includes(query)
    );
  }

  return result;
});

const goToDetailPage = (id) => {
  router.push({ path: `/cars/${id}` });
};

onMounted(fetchCars);
</script>