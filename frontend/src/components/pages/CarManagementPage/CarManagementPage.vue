<template>
  <AdminHeader title="Car Management">
      <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Overview of all registered cars and their status.</p>
        <button @click="openCreateModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          + Add Car
        </button>
      </div>

      <CarTable 
        :cars="cars" 
        :loading="isLoading"
        @edit="openEditModal"
        @delete="handleDelete"
      />

      <div v-if="isModalOpen" class="fixed inset-0 bg-black/50 flex items-start justify-center z-50 overflow-y-auto p-4 sm:p-6">
        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md my-auto h-auto max-h-[90vh] flex flex-col">
          
          <h2 class="text-xl font-bold mb-4 flex-shrink-0">
            {{ editingCar ? 'Edit Car' : 'Create New Car' }}
          </h2>
          
          <div class="overflow-y-auto pr-2 flex-grow custom-scrollbar">
            <EntityForm 
              :schema="carSchema" 
              :initialData="editingCar || {}" 
              @submit="handleFormSubmit" 
              @cancel="closeModal" 
            />
          </div>

        </div>
      </div>
  </AdminHeader>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from '../../../utils/axios';
import CarTable from '../../organisms/CarTable/CarTable.vue';
import EntityForm from '../../molecules/EntityForm/EntityForm.vue';
import AdminHeader from '@/components/organisms/AdminHeader/AdminHeader.vue';

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
    { 
      key: 'images', 
      label: 'Vehicle Photos (Max 4)', 
      type: 'file', 
      multiple: true,
      accept: 'image/*'
    },
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
  const data = new FormData();
  
  // 1. Identify if we are updating or creating
  const isEdit = !!editingCar.value;
  const carId = isEdit ? editingCar.value.carId : null;

  // 2. Map all fields to FormData
  // We loop the schema to ensure we get everything defined
  carSchema.value.forEach(field => {
    if (field.key === 'images') return; // Handled separately below
    
    let value = formData[field.key];
    
    // Handle specific type conversions for PHP
    if (field.type === 'checkbox') {
      value = value ? '1' : '0';
    }
    
    if (value !== undefined && value !== null) {
      data.append(field.key, value);
    }
  });

  // 3. Handle Method Spoofing for Update
  if (isEdit) {
    data.append('_method', 'PUT');
  }

  // 4. Handle Images (Multiple)
  if (formData.images && formData.images.length > 0) {
    // If EntityForm gives you a FileList or Array
    for (let i = 0; i < formData.images.length; i++) {
      data.append('images[]', formData.images[i]);
    }
  }

  try {
    isLoading.value = true;
    
    // 5. Determine URL and Method
    // We always use POST because of Multipart/FormData + _method spoofing
    const url = isEdit ? `/api/cars/${carId}` : '/api/cars';
    
    await axios.post(url, data, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    // 6. Success Feedback & Cleanup
    closeModal();
    await fetchCars(); // Refresh the list
    alert(isEdit ? "Car updated!" : "Car created!");
    
  } catch (error) {
    console.error("Submission Error:", error.response?.data || error.message);
    alert("Error saving car: " + (error.response?.data?.error || "Check console"));
  } finally {
    isLoading.value = false;
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