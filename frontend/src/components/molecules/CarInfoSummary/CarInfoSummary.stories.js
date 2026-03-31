import CarInfoSummary from './CarInfoSummary.vue';

export default {
  title: 'Molecules/CarInfoSummary',
  component: CarInfoSummary,
};

export const Default = {
  args: {
    image: 'https://placehold.co/400x400?text=Tesla+Model+3',
    brand: 'Tesla',
    model: 'Model 3',
    year: 2023,
    transmission: 'Automatic',
  },
};

export const VintageCar = {
  args: {
    image: 'https://placehold.co/400x400?text=Porsche+911',
    brand: 'Porsche',
    model: '911 Carrera',
    year: 1988,
    transmission: 'Manual',
  },
};