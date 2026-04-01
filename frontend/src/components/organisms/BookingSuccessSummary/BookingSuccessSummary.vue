<template>
  <div class="flex flex-col items-center text-center gap-6 py-4">
    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center animate-bounce">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
      </svg>
    </div>

    <div>
      <Heading :level="2" size="2xl">Booking Confirmed!</Heading>
      <Text color="muted">Your ride is ready. Check your email for details.</Text>
    </div>

    <div class="w-full bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col gap-4">
      <CarSummary 
        :image="carImage"
        :brand="carBrand"
        :model="carModel"
        :year="carYear"
        :transmission="carTransmission"
      />

      <div class="bg-white p-4 rounded-2xl border border-gray-100 flex flex-col gap-1 text-left">
        <Text size="xs" color="muted" weight="bold" class="uppercase tracking-wider">Renter Details</Text>
        <div class="flex items-center gap-2 mt-1">
          <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
            <Text size="xs" class="!text-white font-bold">{{ firstName[0] }}{{ lastName[0] }}</Text>
          </div>
          <Text size="base" weight="semibold">{{ firstName }} {{ lastName }}</Text>
        </div>
      </div>

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

    <div class="flex flex-col w-full gap-3">
      <MyButton 
        label="View My Bookings" 
        class="w-full h-14 !rounded-2xl shadow-lg shadow-blue-100 
         transition-all duration-300 ease-out
         hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-200
         active:scale-95"
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
import MyButton from '../../atoms/Button/Button.vue';

defineProps({
  firstName: { type: String, default: 'Guest' },
  lastName: { type: String, default: '' },
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