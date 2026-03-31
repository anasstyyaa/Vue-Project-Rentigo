<template>
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <Heading :level="3">Your Bookings</Heading>
      
      <div class="flex bg-gray-100 p-1 rounded-lg">
        <button 
          v-for="tab in ['active', 'history']" 
          :key="tab"
          @click="currentTab = tab"
          :class="[
            'px-4 py-1.5 text-sm font-medium rounded-md capitalize transition-all',
            currentTab === tab ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'
          ]"
        >
          {{ tab }}
        </button>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <TableHeader>Details</TableHeader>
            <TableHeader>Status</TableHeader>
            <TableHeader>Rate</TableHeader> <TableHeader align="right">Total</TableHeader> </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-50">
          <BookingActionRow 
            v-for="booking in filteredBookings" 
            :key="booking.id"
            v-bind="booking"
            @cancel="$emit('cancel-booking', $event)"
          />
          <tr v-if="filteredBookings.length === 0">
            <td colspan="4" class="px-6 py-12 text-center">
              <Text color="muted">No {{ currentTab }} bookings found.</Text>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Heading from '../../atoms/Heading/Heading.vue';
import TableHeader from '../../atoms/TableHead/TableHead.vue';
import Text from '../../atoms/Text/Text.vue';
import BookingActionRow from '../../molecules/BookingActionRow/BookingActionRow.vue';

const props = defineProps({
  bookings: {
    type: Array,
    default: () => []
  }
});

defineEmits(['cancel-booking']);
const currentTab = ref('active');

const filteredBookings = computed(() => {
  if (!props.bookings) return [];

  return props.bookings.map(booking => ({
    ...booking,
    canCancel: ['Confirmed', 'Pending', 'Booked'].includes(booking.status)
  })).filter(b => {
    const isActiveStatus = ['Confirmed', 'Pending', 'Booked'].includes(b.status);
    return currentTab.value === 'active' ? isActiveStatus : !isActiveStatus;
  });
});
</script>