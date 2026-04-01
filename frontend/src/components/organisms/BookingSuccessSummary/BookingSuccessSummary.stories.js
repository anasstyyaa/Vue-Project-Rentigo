import BookingSuccessSummary from './BookingSuccessSummary.vue';

export default {
  title: 'Molecules/BookingSuccessSummary',
  component: BookingSuccessSummary,
  parameters: {
    layout: 'centered',
  },
};

export const Default = {
  args: {
    firstName: 'Alex',
    lastName: 'Rider',
    carImage: 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=400',
    carBrand: 'Ferrari',
    carModel: '488 Spider',
    carYear: 2023,
    carTransmission: 'F1 Automatic',
    totalPrice: '2,450.00',
    startDate: 'April 12, 2026',
    endDate: 'April 15, 2026',
    totalDays: 3
  },
};