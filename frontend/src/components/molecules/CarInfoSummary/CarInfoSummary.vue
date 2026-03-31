<template>
  <div class="flex items-center gap-4">
    <img :src="image" class="w-20 h-20 object-cover rounded-xl shadow-sm" />
    <div>
      <HeadingAtom :level="3">{{ brand }} {{ model }}</HeadingAtom>
      <TextAtom size="xs" color="muted">{{ year }} • {{ transmission }}</TextAtom>
    </div>
  </div>
</template>

<script setup>
import HeadingAtom from '@/components/atoms/Heading/Heading.vue';
import TextAtom from '@/components/atoms/Text/Text.vue';

defineProps(['image', 'brand', 'model', 'year', 'transmission']);
</script>