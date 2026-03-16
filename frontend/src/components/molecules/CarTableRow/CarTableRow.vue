<template>
  <tr class="hover:bg-gray-50 transition-colors group">
    <TableColumn>
      <span class="text-xs font-mono text-gray-400">{{ car.carId }}</span>
    </TableColumn>

    <TableColumn primary>
      <div class="flex items-center space-x-3">
        <div class="flex-shrink-0 w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
          <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
            <path stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10M13 16h1m6-1v-4a1 1 0 00-1-1h-2l-1-1h-3m4 7h2" />
          </svg>
        </div>
        <div>
          <Text weight="semibold" color="default">{{ car.brand }} {{ car.model }}</Text>
          <Text size="xs" color="muted">{{ car.year }}</Text>
        </div>
      </div>
    </TableColumn>

    <TableColumn>
      <Text size="sm" color="muted">{{ car.transmission }}</Text>
      <Text size="xs" color="muted">{{ car.fuelType }}</Text>
    </TableColumn>

    <TableColumn>
      <PriceTag :amount="car.pricePerDay" />
    </TableColumn>

    <TableColumn>
      <Badge :type="car.isAvailable ? 'success' : 'danger'">
        {{ car.isAvailable ? 'Available' : 'Rented' }}
      </Badge>
    </TableColumn>

    <TableColumn align="right">
      <div class="flex justify-end space-x-1">
        <IconButton 
          variant="primary" 
          label="Edit Car" 
          @click="$emit('edit', car)"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
        </IconButton>

        <IconButton 
          variant="danger" 
          label="Delete Car" 
          @click="$emit('delete', car.carId)"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </IconButton>
      </div>
    </TableColumn>
  </tr>
</template>

<script setup>
import TableColumn from '../../atoms/TableCell/TableCell.vue';
import Text from '../../atoms/Text/Text.vue';
import PriceTag from '../../atoms/PriceDisplay/PriceDisplay.vue';
import Badge from '../../atoms/StatusBadge/StatusBadge.vue';
import IconButton from '../../atoms/IconButton/IconButton.vue'; 

defineProps({ car: Object });
defineEmits(['edit', 'delete']);
</script>