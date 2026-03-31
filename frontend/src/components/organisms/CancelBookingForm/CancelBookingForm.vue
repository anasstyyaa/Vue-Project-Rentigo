<template>
  <div class="flex flex-col gap-6">
    <div class="pb-4 border-b border-gray-100">
      <Text color="muted" size="xs" weight="bold" class="uppercase tracking-widest mb-3 block">
        Cancelling Reservation For:
      </Text>
      <CarSummary 
        :image="carImage"
        :brand="carBrand"
        :model="carModel"
        :year="carYear"
        :transmission="carTransmission"
      />
    </div>

    <div class="space-y-1">
      <Heading :level="3">Cancellation Reason</Heading>
      <Text color="muted" size="sm">Providing a reason helps us improve our service.</Text>
    </div>

    <InputAtom 
      v-model="reason"
      placeholder="Why are you cancelling?"
      label="Reason"
    />

    <div class="flex gap-3 mt-2">
      <MyButton 
        label="Keep Booking" 
        class="flex-1 !bg-gray-100 !text-gray-700 shadow-none" 
        @click="$emit('close')" 
      />
      <MyButton 
        label="Confirm Cancel" 
        color="error"
        class="flex-1"
        :disabled="!reason.trim() || loading"
        @click="$emit('submit', reason)" 
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';
import InputAtom from '../../atoms/Input/Input.vue';
import MyButton from '../../atoms/Button/Button.vue';
import CarSummary from '../../molecules/CarInfoSummary/CarInfoSummary.vue';

defineProps({ 
  loading: Boolean,
  carImage: String,
  carBrand: String,
  carModel: String,
  carYear: [String, Number],
  carTransmission: String
});

const emit = defineEmits(['close', 'submit']);
const reason = ref('');
</script>