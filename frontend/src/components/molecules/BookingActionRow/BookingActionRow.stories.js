import BookingActionRow from './BookingActionRow.vue';

export default {
  title: 'Molecules/BookingActionRow',
  component: BookingActionRow,
  decorators: [
    () => ({
      template: '<table class="min-w-full divide-y divide-gray-200"><tbody><story /></tbody></table>',
    }),
  ],
  argTypes: {
    statusType: {
      control: 'select',
      options: ['success', 'warning', 'danger', 'info'],
    },
    onCancel: { action: 'cancel-clicked' }
  },
};


export const Confirmed = {
  render: (args) => ({
    components: { BookingActionRow },
    setup() { return { args }; },
    template: `
      <table class="min-w-full">
        <tbody>
          <BookingActionRow v-bind="args" />
        </tbody>
      </table>
    `,
  }),
  args: {
    carName: 'Tesla Model 3',
    date: '2026-03-30',
    status: 'Confirmed',
    statusType: 'success',
    price: 450,
    canCancel: true,
  },
};