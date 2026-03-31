<template>
  <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 lg:p-8 flex flex-col gap-6">
    <div class="space-y-3">
      <BadgeAtom :variant="isAvailable ? 'success' : 'danger'" size="md">
        {{ isAvailable ? 'Available' : 'Currently Rented' }}
      </BadgeAtom>
      
      <div>
        <HeadingAtom :level="2" size="2xl" class="leading-tight">
          {{ brand }} {{ model }}
        </HeadingAtom>
        <TextAtom color="muted" size="base">
          {{ year }} • {{ fuelType }} • {{ seats }} Seats
        </TextAtom>
      </div>
    </div>

    <div v-if="description" class="space-y-2">
      <HeadingAtom :level="3" size="sm" class="uppercase tracking-wider text-grey-600">
        About this car
      </HeadingAtom>
      <TextAtom as="p" size="sm" color="muted" class="leading-relaxed">
        {{ description }}
      </TextAtom>
    </div>

    <div class="py-6 border-y border-gray-100 flex items-baseline justify-between">
      <div class="flex flex-col">
        <TextAtom size="xs" weight="bold" color="muted" class="uppercase tracking-wider">
          Daily Rate
        </TextAtom>
        <PriceAtom :amount="pricePerDay" currency="EUR" />
      </div>
      <TextAtom size="xs" color="muted" class="italic">Includes insurance</TextAtom>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div class="p-3 bg-gray-50 rounded-2xl flex flex-col">
        <TextAtom size="xs" color="muted" weight="bold" class="uppercase">Transmission</TextAtom>
        <TextAtom size="sm" weight="semibold">{{ transmission }}</TextAtom>
      </div>
      <div class="p-3 bg-gray-50 rounded-2xl flex flex-col">
        <TextAtom size="xs" color="muted" weight="bold" class="uppercase">Color</TextAtom>
        <TextAtom size="sm" weight="semibold">{{ color }}</TextAtom>
      </div>
    </div>

    <MyButton 
      label="Rent Now" 
      :primary="true" 
      size="large" 
      class="w-full h-14 !rounded-2xl shadow-lg shadow-blue-100 
         transition-all duration-300 ease-out
         hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-200
         active:scale-95"
      @click="$emit('rent')"
    />

    <TextAtom size="xs" color="muted" class="text-center px-4">
      Free cancellation up to 48 hours before the start of the rental.
    </TextAtom>
  </div>
</template>

<script setup>
import BadgeAtom from '../../atoms/Badge/Badge.vue';
import HeadingAtom from '../../atoms/Heading/Heading.vue';
import TextAtom from '../../atoms/Text/Text.vue';
import PriceAtom from '../../atoms/PriceDisplay/PriceDisplay.vue';
import MyButton from '../../atoms/Button/Button.vue';

defineProps({
  brand: String,
  model: String,
  year: [Number, String],
  pricePerDay: [Number, String],
  isAvailable: Boolean,
  transmission: String,
  fuelType: String,
  seats: [Number, String],
  color: String,
  description: String,
});

defineEmits(['rent']);
</script>