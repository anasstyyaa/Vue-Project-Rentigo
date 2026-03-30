<template>
  <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
    <TableCell primary>
      <div class="flex flex-col">
        <Text weight="bold" size="base">{{ carName }}</Text>
        <div class="flex items-center space-x-1 mt-0.5">
          <DateTime :date="startDate" format="short" />
          <span class="text-gray-400">—</span>
          <DateTime :date="endDate" format="short" />
        </div>
      </div>
    </TableCell>
    
    <TableCell>
      <StatusBadge :type="statusType">{{ status }}</StatusBadge>
    </TableCell>
    
    <TableCell>
      <div class="flex flex-col">
        <Price :amount="dailyPrice" :showPeriod="true" />
      </div>
    </TableCell>
    
    <TableCell align="right">
      <div class="flex flex-col items-end">
        <Text size="xs" color="muted" weight="bold" class="uppercase tracking-tighter">Total Amount</Text>
        <Price :amount="totalPrice" :showPeriod="false" />
        <MyButton 
          v-if="canCancel" 
          label="Cancel" 
          size="small" 
          class="mt-2" 
          @click="$emit('cancel', id)" 
        />
      </div>
    </TableCell>
  </tr>
</template>

<script setup>
import TableCell from '../../atoms/TableCell/TableCell.vue';
import StatusBadge from '../../atoms/StatusBadge/StatusBadge.vue';
import Price from '../../atoms/PriceDisplay/PriceDisplay.vue';
import Text from '../../atoms/Text/Text.vue';
import DateTime from '../../atoms/DateDisplay/DateDisplay.vue';
import MyButton from '../../atoms/Button/Button.vue';

defineProps({
  id: [Number, String],
  carName: String,
  startDate: String, 
  endDate: String,   
  status: String,
  statusType: String,
  dailyPrice: [Number, String],
  totalPrice: [Number, String],
  canCancel: Boolean
});

defineEmits(['cancel']);
</script>
