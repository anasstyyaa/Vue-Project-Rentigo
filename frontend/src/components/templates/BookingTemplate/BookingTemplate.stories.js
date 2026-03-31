import BookingTemplate from './BookingTemplate.vue';

export default {
  title: 'Templates/BookingTemplate',
  component: BookingTemplate,
};

export const Default = {
  render: (args) => ({
    components: { BookingTemplate },
    setup() { return { args }; },
    template: `
      <BookingTemplate>
        <template #header>
          <div class="p-4 font-bold text-xl">App Header</div>
        </template>
        <template #back-button>
          <button class="text-sm text-gray-500">← Back to Details</button>
        </template>
        <template #booking-form>
          <div class="h-96 bg-gray-200 rounded-3xl flex items-center justify-center border-2 border-dashed border-gray-400">
            Booking Form Organism Goes Here
          </div>
        </template>
      </BookingTemplate>
    `,
  }),
};