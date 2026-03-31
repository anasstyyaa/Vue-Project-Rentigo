import BookingForm from './BookingForm.vue';

export default {
  title: 'Organisms/BookingForm',
  component: BookingForm,
};

export const CompleteForm = {
  args: {
    carImage: 'https://placehold.co/400x300?text=BMW+M4',
    carBrand: 'BMW',
    carModel: 'M4 Competition',
    carYear: 2024,
    carTransmission: 'Automatic',
    carPrice: 150.00,
    loading: false,
    error: ''
  },
};

export const WithBookingError = {
  args: {
    ...CompleteForm.args,
    error: 'This vehicle is unavailable for the selected dates.'
  }
};