import CarSpecs from './CarSpecs.vue';

export default {
  title: 'Molecules/CarSpecs',
  component: CarSpecs,
  tags: ['autodocs'],
};

export const Economy = {
  args: {
    transmission: 'Manual',
    fuelType: 'Petrol',
    seats: 5,
  },
};

export const Electric = {
  args: {
    transmission: 'Automatic',
    fuelType: 'Electric',
    seats: 5,
  },
};

export const FamilySUV = {
  args: {
    transmission: 'Automatic',
    fuelType: 'Diesel',
    seats: 7,
  },
};