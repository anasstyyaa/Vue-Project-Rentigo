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
    :cars="cars"
    @car-click="handleCarClick"
  />
</template>

<script setup>
import { ref, onMounted } from "vue";
import CarArchive from "../../templates/CarArchive/CarArchive.vue";
import { get } from "../../../utils/api.js";

const cars = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchCars = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await get("/cars"); 

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

const handleCarClick = (id) => {
  console.log("Viewing car details for ID:", id);
};

onMounted(fetchCars);
</script>