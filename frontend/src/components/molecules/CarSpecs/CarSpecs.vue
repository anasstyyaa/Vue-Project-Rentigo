<template>
  <div class="flex items-center gap-3 text-sm text-gray-600">
    <div class="flex items-center gap-1">
      <Text as="span" size="sm" class="capitalize">{{ transmission }}</Text>
    </div>
    
    <span class="text-gray-300">|</span>

    <div class="flex items-center gap-1">
      <Text as="span" size="sm" class="capitalize"> {{ fuelType }} </Text>
    </div>

    <span class="text-gray-300">|</span>

    <div class="flex items-center gap-1">
      <Text as="span" size="sm">{{ seats }} Seats</Text>
    </div>
  </div>
</template>

<script setup>
import Text from '../../atoms/Text/Text.vue';

defineProps({
  transmission: {
    type: String,
    required: true, // automatic
  },
  fuelType: {
    type: String,
    required: true, // petrol
  },
  seats: {
    type: [Number, String],
    required: true,
  },
});
</script>