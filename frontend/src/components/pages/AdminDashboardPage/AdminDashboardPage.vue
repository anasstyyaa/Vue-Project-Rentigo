<template>
  <AdminHeader title="Dashboard">
    <div class="mb-8 flex justify-between items-center">
      <div>
        <AppHeading :level="1">Fleet Activity</AppHeading>
        <Text color="muted">Review and manage all rental activity</Text>
      </div>
      <MyButton label="Export CSV" size="small" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <Text size="xs" color="muted" weight="bold" class="uppercase">Total Revenue</Text>
        <div class="text-3xl font-black mt-1">${{ revenue.toLocaleString() }}</div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <Text size="xs" color="muted" weight="bold" class="uppercase">Active Bookings</Text>
        <div class="text-3xl font-black mt-1">{{ activeBookingsCount }}</div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
      <AdminBookingsTable 
        :bookings="bookings" 
        @sort-change="handleSort" 
      />
    </div>
  </AdminHeader>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import AdminBookingsTable from '@/components/organisms/AdminBookingsTable/AdminBookingsTable.vue';
import AdminHeader from '../../organisms/AdminHeader/AdminHeader.vue';
import AppHeading from '@/components/atoms/Heading/Heading.vue';
import Text from '@/components/atoms/Text/Text.vue';
import MyButton from '@/components/atoms/Button/Button.vue';

const bookings = ref([]);
const loading = ref(true);

const revenue = computed(() => {
  if (!Array.isArray(bookings.value)) return 0;

  return bookings.value.reduce((acc, b) => {
    const currentStatus = b.Status || b.status;
  
    if (currentStatus === 'Cancelled') {
      return acc;
    }

    return acc + (Number(b.TotalPrice) || 0);
  }, 0);
});

const activeBookingsCount = computed(() => {
  if (!Array.isArray(bookings.value)) return 0;

  return bookings.value.filter(b => {
    const currentStatus = b.Status || b.status;
    return currentStatus === 'Active' || currentStatus === 'Scheduled';
  }).length;
});

const fetchBookings = async () => {
  const token = localStorage.getItem('auth_token'); 
  
  if (!token) {
    window.location.href = '/login';
    return;
  }

  try {
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
      return;
    }

    const data = await response.json();
    if (data.error) {
       console.error("Backend Error:", data.error);
       bookings.value = [];
    } else {
       bookings.value = data;
    }
  } catch (err) {
    console.error("Fetch error:", err);
    bookings.value = [];
  } finally {
    loading.value = false;
  }
};

const handleSort = (field) => {
  bookings.value.sort((a, b) => (a[field] > b[field] ? 1 : -1));
};

onMounted(fetchBookings);
</script>