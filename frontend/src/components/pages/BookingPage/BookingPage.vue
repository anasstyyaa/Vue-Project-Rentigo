<template>
  <BookingTemplate>
    <template #header>
      <Header />
    </template>

    <template #back-button>
      <button @click="router.back()" class="flex items-center gap-2 text-gray-600 hover:text-black transition-colors font-medium">
        <span class="text-xl">←</span> Back to car details
      </button>
    </template>

    <template #booking-form>
      <div v-if="loading" class="flex flex-col items-center justify-center p-20">
         <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-black mb-4"></div>
         <p class="text-gray-500">Loading car details...</p>
      </div>

      <BookingForm 
        v-else-if="car"
        :carImage="formattedImage"
        :carBrand="car.brand"
        :carModel="car.model"
        :carYear="car.year"
        :carTransmission="car.transmission"
        :carPrice="parseFloat(car.pricePerDay)"
        :loading="submitting"
        :error="apiError"
        @confirm="handleBookingSubmit"
      />
    </template>
  </BookingTemplate>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { get } from '@/utils/api'; 

import BookingTemplate from '../../templates/BookingTemplate/BookingTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import BookingForm from '../../organisms/BookingForm/BookingForm.vue';

const route = useRoute();
const router = useRouter();

const car = ref(null);
const loading = ref(true);
const submitting = ref(false);
const apiError = ref('');

const formattedImage = computed(() => {
  if (!car.value || !car.value.images) return 'https://placehold.co/800x600?text=No+Image';
  const imgs = typeof car.value.images === 'string' ? JSON.parse(car.value.images) : car.value.images;
  const firstImg = imgs[0];
  return firstImg.startsWith('http') ? firstImg : `http://localhost/${firstImg}`;
});

onMounted(async () => {
  try {
    const carId = route.query.carId;
    const res = await get(`/api/cars/${carId}`);
    car.value = await res.json();
  } catch (err) {
    apiError.value = "Could not load car data.";
  } finally {
    loading.value = false;
  }
});

const handleBookingSubmit = async (bookingDetails) => {
  submitting.value = true;
  apiError.value = '';

  try {
    const response = await fetch('http://localhost/api/bookings', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        carId: car.value.carId,
        startDate: bookingDetails.startDate,
        endDate: bookingDetails.endDate
      })
    });

    const result = await response.json();

    if (response.ok) {
      router.push('/profile');
    } else {
      apiError.value = result.error || "Booking failed.";
    }
  } catch (err) {
    apiError.value = "Server error. Please try again.";
  } finally {
    submitting.value = false;
  }
};
</script>