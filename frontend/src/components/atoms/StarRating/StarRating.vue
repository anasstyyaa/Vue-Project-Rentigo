<template>
  <div class="flex gap-1">
    <button 
      v-for="star in 5" 
      :key="star"
      type="button"
      @click="$emit('update:modelValue', star)"
      class="transition-transform active:scale-90"
    >
      <StarIcon 
        :size="28" 
        :class="[
          star <= modelValue ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300 fill-transparent',
          'transition-colors duration-200'
        ]"
      />
    </button>
  </div>
</template>

<script setup>
import { Star as StarIcon } from 'lucide-vue-next';
defineProps(['modelValue']);
defineEmits(['update:modelValue']);
</script>