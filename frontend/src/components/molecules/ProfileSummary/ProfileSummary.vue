<template>
  <div class="flex flex-col items-center space-y-4 md:flex-row md:space-y-0 md:space-x-6">
    <div class="w-24 h-24 md:w-32 md:h-32">
      <AppImage 
        :src="avatar" 
        aspect="square" 
        class="rounded-full ring-4 ring-white shadow-lg" 
      />
    </div>
    <div class="text-center md:text-left">
      <Heading :level="2" size="2xl">{{ name }}</Heading>
      <div class="mt-1">
        <slot name="badge" />
      </div>
    </div>
  </div>
</template>

<script setup>
import AppImage from '../../atoms/AppImage/AppImage.vue';
import Heading from '../../atoms/Heading/Heading.vue';

defineProps({
  avatar: String,
  name: String
});
</script>