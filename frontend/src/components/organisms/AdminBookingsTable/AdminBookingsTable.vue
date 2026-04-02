<template>
  <div class="w-full overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <AppTableHeading>ID</AppTableHeading>
            <AppTableHeading sortable @sort="handleSort('UserName')">Customer</AppTableHeading>
            <AppTableHeading>Vehicle</AppTableHeading>
            <AppTableHeading sortable @sort="handleSort('StartDate')">Duration</AppTableHeading>
            <AppTableHeading sortable @sort="handleSort('TotalPrice')" class="text-right">Total</AppTableHeading>
            <AppTableHeading>Status</AppTableHeading>
            <AppTableHeading aria-label="Actions" />
          </tr>
        </thead>
        
        <tbody class="divide-y divide-gray-100">
          <template v-if="bookings.length > 0">
            <AdminTableRow 
              v-for="booking in bookings" 
              :key="booking.RentalId" 
              :booking="booking" 
            />
          </template>
          
          <tr v-else>
            <td colspan="7" class="py-20 text-center">
              <div class="flex flex-col items-center justify-center text-gray-400">
                <p class="font-medium">No bookings found for this period.</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import AppTableHeading from '../../atoms/TableHead/TableHead.vue';
import AdminTableRow from '../../molecules/AdminTableRow/AdminTableRow.vue';

const props = defineProps({
  bookings: {
    type: Array,
    required: true,
    default: () => []
  }
});

const emit = defineEmits(['sort-change']);

const handleSort = (field) => {
  emit('sort-change', field);
};
</script>