<template>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
    <MyInput 
      type="date" 
      label="Pick-up Date" 
      :modelValue="start" 
      :min="today"
      @update:modelValue="$emit('update:start', $event)"
    />
    <MyInput 
      type="date" 
      label="Return Date" 
      :modelValue="end" 
      :min="start || today"
      @update:modelValue="$emit('update:end', $event)"
    />
  </div>
</template>

<script setup>
import MyInput from '@/components/atoms/Input/Input.vue';

defineProps(['start', 'end']);
defineEmits(['update:start', 'update:end']);

const today = new Date().toISOString().split('T')[0];
</script>