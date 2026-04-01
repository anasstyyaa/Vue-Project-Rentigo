import StarRating from './StarRating.vue';
import { ref } from 'vue';

export default {
  title: 'Atoms/StarRating',
  component: StarRating,
  argTypes: {
    modelValue: { control: { type: 'number', min: 0, max: 5 } },
  },
};

export const Interactive = {
  render: (args) => ({
    components: { StarRating },
    setup() {
      const rating = ref(args.modelValue || 0);
      return { args, rating };
    },
    template: `
      <div class="p-4 border rounded-xl inline-block">
        <StarRating v-model="rating" />
        <p class="mt-2 text-sm text-gray-500 text-center font-mono">Value: {{ rating }}</p>
      </div>
    `,
  }),
  args: {
    modelValue: 3,
  },
};

export const Empty = {
  args: {
    modelValue: 0,
  },
};