<template>
  <div class="flex flex-col gap-4">
    <ImageAtom 
      :src="activeImage || images[0]" 
      aspect="video" 
      class="shadow-lg rounded-2xl border border-gray-100"
    />

    <div class="grid grid-cols-4 gap-4">
      <button 
        v-for="(img, index) in images.slice(0, 4)" 
        :key="index"
        @click="activeImage = img"
        class="overflow-hidden rounded-xl border-2 transition-all duration-200"
        :class="activeImage === img || (!activeImage && index === 0) 
                ? 'border-blue-600 ring-2 ring-blue-100' 
                : 'border-transparent opacity-70 hover:opacity-100'"
      >
        <ImageAtom :src="img" aspect="square" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import ImageAtom from '../../atoms/AppImage/AppImage.vue';

const props = defineProps({
  images: { type: Array, required: true, default: () => [] },
  mainImage: { type: String, default: '' } 
});

const activeImage = ref(props.mainImage || props.images[0] || '');

watch(() => props.images, (newImages) => {
  if (!activeImage.value && newImages.length > 0) {
    activeImage.value = props.mainImage || newImages[0];
  }
}, { immediate: true });

</script>