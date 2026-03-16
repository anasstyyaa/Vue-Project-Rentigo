import CarTable from './CarTable.vue';

export default {
  title: 'Organisms/CarTable',
  component: CarTable,
};

const Template = (args) => ({
  components: { CarTable },
  setup() {
    return { args };
  },
  template: '<CarTable v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = {
  loading: false,
  cars: [
    { carId: 1, brand: 'Audi', model: 'A4', year: 2023, transmission: 'Automatic', fuelType: 'Petrol', pricePerDay: 95, isAvailable: true },
    { carId: 2, brand: 'Toyota', model: 'Camry', year: 2022, transmission: 'Automatic', fuelType: 'Hybrid', pricePerDay: 70, isAvailable: false },
    { carId: 3, brand: 'Porsche', model: '911', year: 2024, transmission: 'PDK', fuelType: 'Petrol', pricePerDay: 450, isAvailable: true },
  ],
};

export const Loading = Template.bind({});
Loading.args = {
  cars: [],
  loading: true,
};

export const Empty = Template.bind({});
Empty.args = {
  cars: [],
  loading: false,
};