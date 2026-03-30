<template>
  <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
      <Heading :level="3">Personal Information</Heading>
      <MyButton label="Edit" size="small" @click="$emit('edit')" />
    </div>
    <div class="p-6 space-y-1">
      <InfoField label="Username" :value="`@${user.username}`" />
      <InfoField label="Email Address" :value="user.email" />
      <InfoField label="Phone Number" :value="user.phoneNumber || 'Not provided'" />
      <InfoField label="Member Since">
        <DateTime :date="user.createdAt" format="long" />
      </InfoField>
    </div>
  </section>
</template>

<script setup>
import Heading from '../../atoms/Heading/Heading.vue';
import MyButton from '../../atoms/Button/Button.vue';
import DateTime from '../../atoms/DateDisplay/DateDisplay.vue';
import InfoField from '../../molecules/InfoField/InfoField.vue';

defineProps({
  user: {
    type: Object,
    required: true
  }
});

defineEmits(['edit']);
</script>