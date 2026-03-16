<template>
  <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <TableHeader>ID</TableHeader>
          <TableHeader sortable @sort="$emit('sort', 'brand')">Vehicle</TableHeader>
          <TableHeader>Specifications</TableHeader>
          <TableHeader sortable @sort="$emit('sort', 'pricePerDay')">Daily Rate</TableHeader>
          <TableHeader>Status</TableHeader>
          <TableHeader>Actions</TableHeader> </tr>
      </thead>
      
      <tbody class="divide-y divide-gray-100 bg-white">
        <tr v-if="loading">
          <td colspan="5" class="py-12 text-center">
            <Text color="muted" size="sm" weight="medium">Fetching fleet data...</Text>
          </td>
        </tr>

        <tr v-else-if="cars.length === 0">
          <td colspan="5" class="py-12 text-center">
            <Text color="muted">No vehicles available at the moment.</Text>
          </td>
        </tr>

        <CarTableRow 
          v-for="car in cars" 
          :key="car.carId" 
          :car="car"
          @edit="$emit('edit', $event)"
          @delete="$emit('delete', $event)"
        />
      </tbody>
    </table>
  </div>
</template>

<script setup>
import TableHeader from '../../atoms/TableHead/TableHead.vue';
import CarTableRow from '../../molecules/CarTableRow/CarTableRow.vue';
import Text from '../../atoms/Text/Text.vue';

defineProps({
  cars: { type: Array, required: true },
  loading: { type: Boolean, default: false }
});

defineEmits(['edit', 'delete', 'sort']);
</script>