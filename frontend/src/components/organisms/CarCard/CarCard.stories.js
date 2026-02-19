import CarCard from './CarCard.vue';

export default {
  title: 'Organisms/CarCard',
  component: CarCard,
  tags: ['autodocs'],
};

export const TeslaModel3 = {
  args: {
    brand: 'Tesla',
    model: 'Model 3',
    year: 2023,
    image: 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&q=80&w=800',
    pricePerDay: 120.00,
    transmission: 'Automatic',
    fuelType: 'Electric',
    seats: 5,
  },
};

export const Porsche911 = {
  args: {
    brand: 'Porsche',
    model: '911 Carrera',
    year: 2022,
    image: 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=800',
    pricePerDay: 350.00,
    transmission: 'Automatic',
    fuelType: 'Petrol',
    seats: 2,
  },
};