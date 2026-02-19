import CarArchive from './CarArchive.vue';

export default {
  title: 'Templates/CarArchive',
  component: CarArchive,
  tags: ['autodocs'],
};

const mockCars = [
  {
    id: 1,
    brand: 'Tesla',
    model: 'Model 3',
    year: 2023,
    image: 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&q=80&w=800',
    pricePerDay: 120,
    transmission: 'Automatic',
    fuelType: 'Electric',
    seats: 5
  },
  {
    id: 2,
    brand: 'BMW',
    model: 'M4 Competition',
    year: 2022,
    image: 'https://images.unsplash.com/photo-1617814076367-b759c7d82666?auto=format&fit=crop&q=80&w=800',
    pricePerDay: 250,
    transmission: 'Automatic',
    fuelType: 'Petrol',
    seats: 4
  },
  {
    id: 3,
    brand: 'Land Rover',
    model: 'Defender',
    year: 2023,
    image: 'https://images.unsplash.com/photo-1605515298946-d062f2e9da53?auto=format&fit=crop&q=80&w=800',
    pricePerDay: 180,
    transmission: 'Manual',
    fuelType: 'Diesel',
    seats: 7
  }
];

export const Default = {
  args: {
    cars: mockCars,
  },
};

export const Empty = {
  args: {
    cars: [],
  },
};