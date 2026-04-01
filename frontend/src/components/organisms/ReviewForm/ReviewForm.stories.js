import ReviewForm from './ReviewForm.vue';

export default {
  title: 'Organisms/ReviewForm',
  component: ReviewForm,
  parameters: {
    layout: 'centered',
  },
};

export const Default = {
  args: {
    carName: '2022 Mercedes-Benz C-Class',
    loading: false,
  },
};

export const Submitting = {
  args: {
    carName: '2022 Mercedes-Benz C-Class',
    loading: true,
  },
};

export const InsideModalLayout = {
  render: (args) => ({
    components: { ReviewForm },
    setup() {
      return { args };
    },
    template: `
      <div class="fixed inset-0 bg-black/20 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
          <ReviewForm v-bind="args" @submit="(data) => console.log('Submitted Review:', data)" />
        </div>
      </div>
    `,
  }),
  args: {
    carName: 'Tesla Model 3',
    loading: false,
  },
};