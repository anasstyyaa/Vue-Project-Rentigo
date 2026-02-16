<template>
  <div :class="['overflow-hidden rounded-lg bg-gray-100', aspectClass]">
    <img
      v-if="!hasError"
      :src="src"
      :alt="alt"
      class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
      @error="handleError"
    />
    <div v-else class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-400">
      <ImageOff :size="48" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
//import { ImageOff } from 'lucide-vue-next';

const props = defineProps({
  src: {
    type: String,
    required: true,
  },
  alt: {
    type: String,
    default: 'Car image',
  },
  aspect: {
    type: String,
    default: 'video', // 'video' (16:9), 'square' (1:1), or 'wide' (21:9)
  },
});

const hasError = ref(false);

const handleError = () => {
  hasError.value = true;
};

const aspectClass = computed(() => {
  const mapping = {
    video: 'aspect-video',
    square: 'aspect-square',
    wide: 'aspect-[21/9]',
  };
  return mapping[props.aspect] || 'aspect-video';
});
</script>