import AdminBookingsTable from './AdminBookingsTable.vue';

export default {
  title: 'Organisms/AdminBookingsTable',
  component: AdminBookingsTable,
};

const mockBookings = [
  {
    RentalId: 501,
    UserName: 'Michael Scott',
    UserId: 12,
    Make: 'Chrysler',
    Model: 'Sebring',
    CarId: 4,
    StartDate: '2026-06-01',
    EndDate: '2026-06-03',
    TotalPrice: '250.00',
    Status: 'Completed'
  },
  {
    RentalId: 502,
    UserName: 'Dwight Schrute',
    UserId: 7,
    Make: 'Pontiac',
    Model: 'Firebird',
    CarId: 18,
    StartDate: '2026-06-05',
    EndDate: '2026-06-10',
    TotalPrice: '950.00',
    Status: 'Pending'
  }
];

export const Default = {
  args: {
    bookings: mockBookings
  }
};

export const Empty = {
  args: {
    bookings: []
  }
};