<template>
  <AdminTemplate>
    <template #sidebar-nav>
        <router-link to="/" class="nav-link-back mb-4 flex items-center text-blue-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Website
        </router-link>

        <router-link to="/admin/dashboard" class="nav-link">Dashboard</router-link>
        <router-link to="/admin/users" class="nav-link active">Manage Users</router-link>
        <router-link to="/admin/cars" class="nav-link">Manage Cars</router-link>
    </template>

    <template #sidebar-footer>
      <button @click="logout" class="text-gray-400 hover:text-white transition-colors text-sm">Logout</button>
    </template>

    <template #header-left>
      <h1 class="text-xl font-bold text-gray-800">Car Management</h1>
    </template>

    <template #header-right>
      <div class="text-sm text-gray-500">Admin: <strong>{{ adminName }}</strong></div>
    </template>

    <template #main-content>
      <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Overview of all registered cars and their status.</p>
        <button @click="openCreateModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
          + Add Car
        </button>
      </div>

      <CarTable 
        :cars="cars" 
        :loading="isLoading"
        @edit="openEditModal"
        @delete="handleDelete"
      />

      <div v-if="isModalOpen" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md">
          <h2 class="text-xl font-bold mb-4">
            {{ editingCar ? 'Edit Car' : 'Create New Car' }}
          </h2>
          
          <EntityForm 
            :schema="carSchema" 
            :initialData="editingCar || {}" 
            @submit="handleFormSubmit" 
            @cancel="closeModal" 
          />
        </div>
      </div>
    </template>
  </AdminTemplate>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from '../../../utils/axios';
import AdminTemplate from '../../templates/AdminTemplate/AdminTemplate.vue';
import CarTable from '../../organisms/CarTable/CarTable.vue';
import EntityForm from '../../molecules/EntityForm/EntityForm.vue';

const route = useRoute();
const router = useRouter();
const cars = ref([]);
const isLoading = ref(false);

const isModalOpen = ref(false);
const editingCar = ref(null); // null means "create mode", object means "edit mode"

const adminName = computed(() => {
  const user = JSON.parse(localStorage.getItem('user'));
  return user ? user.firstName : 'Admin';
});

const carSchema = computed(() => {
  return [
    { key: 'brand', label: 'Brand', placeholder: 'e.g. BMW' },
    { key: 'model', label: 'Model', placeholder: 'e.g. M4' },
    { key: 'year', label: 'Year', type: 'number' },
    { 
      key: 'transmission', 
      label: 'Transmission', 
      options: [
        { label: 'Automatic', value: 'Automatic' },
        { label: 'Manual', value: 'Manual' }
      ] 
    },
    { 
      key: 'fuelType', 
      label: 'Fuel Type', 
      options: [
        { label: 'Petrol', value: 'Petrol' },
        { label: 'Diesel', value: 'Diesel' },
        { label: 'Electric', value: 'Electric' },
        { label: 'Hybrid', value: 'Hybrid' }
      ] 
    },
    { key: 'pricePerDay', label: 'Price per Day ($)', type: 'number' },
    { key: 'seats', label: 'Seats', type: 'number' },
    { key: 'isAvailable', label: 'Available for Rent', type: 'checkbox' }
  ];
});

const openCreateModal = () => {
  editingCar.value = null;
  isModalOpen.value = true;
};

const openEditModal = (car) => {
  editingCar.value = { ...car }; // clone the car 
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const fetchCars = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get('/api/cars');
    cars.value = response.data;
  } catch (error) {
    console.error("Error fetching cars:", error);
    alert("Failed to load cars.");
  } finally {
    isLoading.value = false;
  }
};

const handleFormSubmit = async (formData) => {
  const submissionData = {
    ...formData,
    year: parseInt(formData.year),
    pricePerDay: parseFloat(formData.pricePerDay),
    seats: parseInt(formData.seats),
    isAvailable: formData.isAvailable ? 1 : 0
  };

  try {
    const method = editingCar.value ? 'put' : 'post';
    const url = editingCar.value 
      ? `/api/cars/${editingCar.value.carId}` 
      : '/api/cars';

    await axios[method](url, submissionData);
    
    closeModal();
    await fetchCars();
  } catch (error) {
    alert(error.response?.data?.error || "An error occurred while saving.");
  }
};

const handleDelete = async (carId) => {
  if (confirm("Are you sure you want to delete this car?")) {
    try {
      await axios.delete(`/api/cars/${carId}`);
      cars.value = cars.value.filter(c => c.carId !== carId);
    } catch (error) {
      console.error("Error deleting car:", error);
      alert("Delete failed.");
    }
  }
};

onMounted(fetchCars);

const logout = () => {
  localStorage.removeItem('user');
  window.location.href = '/login';
};
</script>

<style scoped>
@reference "../../../assets/main.css";

.nav-link {
  @apply block px-4 py-2.5 rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white transition-all;
}
.nav-link.active {
  @apply bg-blue-600 text-white;
}
</style>