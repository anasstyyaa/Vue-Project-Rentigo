import AdminTableRow from './AdminTableRow.vue';

export default {
  title: 'Molecules/AdminTableRow',
  component: AdminTableRow,
  decorators: [() => ({ template: '<table class="w-full"><tbody><story/></tbody></table>' })],
};

const Template = (args) => ({
  components: { AdminTableRow },
  setup() { return { args }; },
  template: '<AdminTableRow v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = {
  booking: {
    RentalId: 1024,
    UserName: 'Alexander Pierce',
    UserId: 88,
    Make: 'BMW',
    Model: 'M4 Competition',
    CarId: 12,
    StartDate: '2026-05-01',
    EndDate: '2026-05-07',
    TotalPrice: '1,250.00',
    Status: 'Confirmed'
  }
};

export const Completed = Template.bind({});
Completed.args = {
  booking: {
    ...Default.args.booking,
    Status: 'Completed',
    TotalPrice: '850.00'
  }
};