import CarDetails from './CarDetails.vue';

export default {
  title: 'Organisms/CarDetails',
  component: CarDetails,
  tags: ['autodocs'],
};

export const Available = {
  args: {
    brand: 'Tesla',
    model: 'Model 3',
    year: 2023,
    pricePerDay: 120.00,
    isAvailable: true,
    transmission: 'Automatic',
    fuelType: 'Electric',
    seats: 5,
    color: 'Pearl White',
    description: 'Experience the future of driving with this high-performance electric sedan featuring Autopilot and premium interior.',
  },
};

export const Rented = {
  args: {
    ...Available.args,
    isAvailable: false,
    brand: 'Porsche',
    model: '911 Carrera',
    pricePerDay: 350.00,
    color: 'Guards Red',
  },
};