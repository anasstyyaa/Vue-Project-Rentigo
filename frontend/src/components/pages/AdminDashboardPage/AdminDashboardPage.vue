<template>
  <AdminHeader/>
  <AdminDashboardTemplate>
    <template #header>
      <div>
        <AppHeading :level="1">Booking Management</AppHeading>
        <DataText color="muted">Review and manage all fleet activity</DataText>
      </div>
      <MyButton label="Export CSV" size="small" />
    </template>

    <template #stats>
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <Text size="xs" color="muted" weight="bold" class="uppercase">Total Revenue</Text>
        <div class="text-3xl font-black mt-1">${{ revenue }}</div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <Text size="xs" color="muted" weight="bold" class="uppercase">Active Bookings</Text>
        <div class="text-3xl font-black mt-1">{{ bookings.length }}</div>
      </div>
    </template>

    <template #content>
      <AdminBookingsTable 
        :bookings="bookings" 
        @sort-change="handleSort" 
      />
    </template>
  </AdminDashboardTemplate>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import AdminDashboardTemplate from '@/components/templates/AdminDashboardTemplate/AdminDashboardTemplate.vue';
import AdminBookingsTable from '@/components/organisms/AdminBookingsTable/AdminBookingsTable.vue';
import AppHeading from '@/components/atoms/Heading/Heading.vue';
import Text from '@/components/atoms/Text/Text.vue';
import MyButton from '@/components/atoms/Button/Button.vue';

const bookings = ref([]);
const loading = ref(true);

const revenue = computed(() => {
  return bookings.value
    .reduce((acc, curr) => acc + parseFloat(curr.TotalPrice || 0), 0)
    .toLocaleString();
});

const fetchBookings = async () => {
  const token = localStorage.getItem('auth_token'); 
  
  if (!token) {
    console.error("No token found in local storage");
    window.location.href = '/login';
    return;
  }

  const response = await fetch('http://localhost/api/admin/bookings', {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${token}`, 
      'Content-Type': 'application/json'
    }
  });

  if (response.status === 401 || response.status === 403) {
    localStorage.removeItem('auth_token');
    window.location.href = '/login';
  }

  const data = await response.json();
  bookings.value = data;
};

const handleSort = (field) => {
  bookings.value.sort((a, b) => (a[field] > b[field] ? 1 : -1));
};

onMounted(fetchBookings);
</script>