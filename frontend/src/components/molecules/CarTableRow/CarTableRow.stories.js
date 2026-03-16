import CarTableRow from './CarTableRow.vue';

export default {
  title: 'Molecules/CarTableRow',
  component: CarTableRow,
  argTypes: {
    onEdit: { action: 'edit' },
    onDelete: { action: 'delete' },
  },
};

const Template = (args) => ({
  components: { CarTableRow },
  setup() {
    return { args };
  },
  template: `
    <table class="min-w-full">
      <tbody>
        <CarTableRow v-bind="args" @edit="args.onEdit" @delete="args.onDelete" />
      </tbody>
    </table>
  `,
});

export const Available = Template.bind({});
Available.args = {
  car: {
    carId: 1,
    brand: 'Tesla',
    model: 'Model 3',
    year: 2024,
    transmission: 'Automatic',
    fuelType: 'Electric',
    pricePerDay: 120.00,
    isAvailable: true,
  },
};

export const Rented = Template.bind({});
Rented.args = {
  car: {
    ...Available.args.car,
    brand: 'Ford',
    model: 'Mustang',
    isAvailable: false,
  },
};