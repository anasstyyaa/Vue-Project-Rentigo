<template>
  <div class="flex flex-col items-center text-center gap-6 py-4 max-h-[80vh] overflow-y-auto px-2 custom-scrollbar">
    
    <div class="shrink-0 w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center animate-bounce">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
      </svg>
    </div>

    <div class="shrink-0">
      <Heading :level="2" size="2xl">Booking Confirmed!</Heading>
      <Text color="muted">Your ride is ready. </Text>
    </div>

    <div class="w-full bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col gap-4">
      
      <RenterInfoCard 
        :firstName="firstName" 
        :lastName="lastName" 
        :email="email" 
        :phone="phone" 
      />

      <CarSummary 
        :image="carImage"
        :brand="carBrand"
        :model="carModel"
        :year="carYear"
        :transmission="carTransmission"
      />

      <div class="bg-white p-4 rounded-2xl border border-gray-100 flex flex-col gap-2 text-left">
        <div class="flex justify-between">
          <Text size="xs" color="muted" weight="bold" class="uppercase tracking-wider">Trip Duration</Text>
          <Text size="xs" weight="bold">{{ totalDays }} Days</Text>
        </div>
        <div class="flex justify-between items-center">
          <Text size="sm">{{ startDate }}</Text>
          <span class="text-gray-300">→</span>
          <Text size="sm">{{ endDate }}</Text>
        </div>
      </div>

      <div class="pt-4 border-t border-gray-200 flex justify-between items-center px-2">
        <Text size="sm" weight="bold">Total Paid</Text>
        <Price :amount="totalPrice" size="md" />
      </div>
    </div>

    <div class="shrink-0 w-full pt-2">
      <MyButton 
        label="View My Bookings" 
        class="w-full h-14 !rounded-2xl shadow-lg shadow-blue-100 
               transition-all duration-300 ease-out !bg-black !text-white
               hover:-translate-y-1 hover:shadow-xl active:scale-95"
        @click="$emit('view-bookings')" 
      />
    </div>
  </div>
</template>

<script setup>
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';
import Price from '../../atoms/TotalPrice/TotalPrice.vue';
import CarSummary from '../../molecules/CarInfoSummary/CarInfoSummary.vue';
import RenterInfoCard from '../../molecules/RenterInfoCard/RenterInfoCard.vue';
import MyButton from '../../atoms/Button/Button.vue';

defineProps({
  firstName: { type: String, default: 'Guest' },
  lastName: { type: String, default: '' },
  email: { type: String, default: 'Not provided' }, 
  phone: { type: String, default: 'Not provided' }, 
  carImage: String,
  carBrand: String,
  carModel: String,
  carYear: [Number, String],
  carTransmission: String,
  totalPrice: [Number, String],
  startDate: String,
  endDate: String,
  totalDays: [Number, String]
});

defineEmits(['view-bookings'])
</script>

<style scoped>
/* Optional: Make the scrollbar look cleaner */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #e5e7eb;
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #d1d5db;
}
</style>