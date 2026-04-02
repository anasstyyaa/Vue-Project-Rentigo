<template>
  <tr class="hover:bg-gray-50/50 transition-colors border-b border-gray-100 last:border-0">
    <AppTableCell>
      <span class="font-mono text-xs text-gray-400">#{{ booking.RentalId }}</span>
    </AppTableCell>

    <AppTableCell primary>
      <div class="flex flex-col">
        <span class="font-bold text-gray-900">{{ booking.UserName }}</span>
        <span class="text-[10px] uppercase tracking-tighter text-gray-400">ID: {{ booking.UserId }}</span>
      </div>
    </AppTableCell>

    <AppTableCell>
      <div class="flex flex-col">
        <span class="font-semibold text-gray-800">{{ booking.Make }} {{ booking.Model }}</span>
        <span class="text-xs text-gray-500">Ref: {{ booking.CarId }}</span>
      </div>
    </AppTableCell>

    <AppTableCell shadow>
      <div class="flex flex-col gap-0.5">
        <AppDate :date="booking.StartDate" format="short" class="font-medium" />
        <div class="flex items-center gap-1">
          <span class="text-[10px] text-gray-400 font-bold uppercase">to</span>
          <AppDate :date="booking.EndDate" format="short" />
        </div>
      </div>
    </AppTableCell>

    <AppTableCell>
      <span class="font-black text-gray-900">${{ booking.TotalPrice }}</span>
    </AppTableCell>

    <AppTableCell align="right">
      <AppStatusBadge :type="mapStatusToVariant(booking.Status)">
        {{ booking.Status }}
      </AppStatusBadge>
    </AppTableCell>
  </tr>
</template>

<script setup>
import AppTableCell from '../../atoms/TableCell/TableCell.vue';
import AppStatusBadge from '../../atoms/StatusBadge/StatusBadge.vue';
import AppDate from '../../atoms/DateDisplay/DateDisplay.vue';

const props = defineProps({
  booking: {
    type: Object,
    required: true
  }
});

const mapStatusToVariant = (status) => {
  const map = {
    'Completed': 'success',
    'Pending': 'warning',
    'Cancelled': 'danger',
    'Confirmed': 'info'
  };
  return map[status] || 'info';
};
</script>