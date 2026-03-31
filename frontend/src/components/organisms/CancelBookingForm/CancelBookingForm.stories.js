import CancelBookingForm from './CancelBookingForm.vue';

export default {
  title: 'Molecules/CancelBookingForm',
  component: CancelBookingForm,
};

export const Default = {
  args: {
    loading: false,
    carImage: 'https://via.placeholder.com/150',
    carBrand: 'BMW',
    carModel: 'X5',
    carYear: 2023,
    carTransmission: 'Automatic'
  }
};