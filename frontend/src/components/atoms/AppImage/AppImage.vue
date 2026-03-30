<template>
  <div :class="['overflow-hidden rounded-lg bg-gray-100', aspectClass]">
    <img
      v-if="src && !hasError"
      :src="computedSrc"
      :alt="alt"
      class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
      @error="handleError"
    />
    <div v-else class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-400">
       <span>No Image</span>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  src: { type: String, default: '' },
  alt: { type: String, default: 'Car image' },
  aspect: { type: String, default: 'video' },
});

const hasError = ref(false);

// 
const computedSrc = computed(() => {
  if (!props.src) return '';
  if (props.src.startsWith('http')) return props.src;
  return `http://localhost/${props.src}`;
});

watch(() => props.src, () => { hasError.value = false; });
const handleError = () => { hasError.value = true; };

const aspectClass = computed(() => {
  const mapping = { video: 'aspect-video', square: 'aspect-square', wide: 'aspect-[21/9]' };
  return mapping[props.aspect] || 'aspect-video';
});
</script>