import BookingsTable from './BookingsTable.vue';

export default {
  title: 'Organisms/BookingsTable',
  component: BookingsTable,
  args: {
    bookings: [
      { 
        id: 1, 
        carName: 'Tesla Model 3', 
        startDate: '2026-04-10', 
        endDate: '2026-04-13', 
        status: 'Confirmed', 
        statusType: 'success', 
        dailyPrice: 150, 
        totalPrice: 450, 
        canCancel: true 
      },
      { 
        id: 2, 
        carName: 'Ford Mustang', 
        startDate: '2026-05-12', 
        endDate: '2026-05-15', 
        status: 'Pending', 
        statusType: 'warning', 
        dailyPrice: 200, 
        totalPrice: 600, 
        canCancel: true 
      },
      { 
        id: 3, 
        carName: 'Audi A4', 
        startDate: '2025-12-01', 
        endDate: '2025-12-04', 
        status: 'Completed', 
        statusType: 'info', 
        dailyPrice: 100, 
        totalPrice: 300, 
        canCancel: false 
      }
    ]
  },
  argTypes: {
    onCancelBooking: { action: 'cancel-booking-emitted' }
  }
};

export const Default = {};

export const NoBookings = {
  args: {
    bookings: []
  }
};