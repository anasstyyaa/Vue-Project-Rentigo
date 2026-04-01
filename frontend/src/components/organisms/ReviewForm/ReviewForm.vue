<template>
  <div class="flex flex-col gap-6 p-4">
    <div class="text-center">
      <Heading :level="3" size="xl">Rate your ride</Heading>
      <Text color="muted">How was your experience with the {{ carName }}?</Text>
    </div>

    <div class="flex flex-col items-center gap-2">
      <StarRating v-model="rating" />
      <Text size="xs" weight="bold" class="uppercase text-yellow-600">
        {{ ratingLabel }}
      </Text>
    </div>

    <div class="flex flex-col gap-2 text-left">
      <Text size="sm" weight="bold">Your Review</Text>
      <textarea 
        v-model="comment"
        placeholder="Tell us what you liked or what could be better..."
        class="w-full h-32 p-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-black outline-none resize-none transition-all"
      ></textarea>
    </div>

    <MyButton 
      label="Submit Review" 
      :loading="loading"
      class="w-full h-14 !bg-black !text-white !rounded-2xl"
      @click="handleSubmit" 
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';
import StarRating from '../../atoms/StarRating/StarRating.vue';
import MyButton from '../../atoms/Button/Button.vue';

const props = defineProps(['carName', 'loading']);
const emit = defineEmits(['submit']);

const rating = ref(0);
const comment = ref('');

const ratingLabel = computed(() => {
  const labels = { 0: 'Select a rating', 1: 'Terrible', 2: 'Bad', 3: 'Okay', 4: 'Great', 5: 'Amazing!' };
  return labels[rating.value];
});

const handleSubmit = () => {
  if (rating.value === 0) return alert("Please select a rating.");
  emit('submit', { rating: rating.value, comment: comment.value });
};
</script>