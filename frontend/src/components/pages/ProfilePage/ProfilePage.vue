<template>
  <Header />
  <div v-if="loading" class="flex justify-center items-center h-screen">
    <Text color="primary" weight="bold">Loading Profile...</Text>
  </div>

  <ProfileTemplate v-else>
    <template #header>
      <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <ProfileSummary 
          :name="`${user.firstName} ${user.lastName}`" 
          :avatar="user.profilePicture"
        >
          <template #badge>
            <Badge variant="primary">Verified Member</Badge>
          </template>
        </ProfileSummary>
        <MyButton label="Sign Out" @click="handleLogout" />
      </div>
    </template>

    <template #sidebar>
      <PersonalInfoCard :user="user" @edit="openEditModal" />
    </template>

    <template #content>
      <BookingsTable 
        :bookings="bookings" 
        @cancel-booking="handleCancel" 
      />
    </template>
  </ProfileTemplate>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { get } from "../../../utils/api.js";

import Header from '../../organisms/Header/Header.vue';
import ProfileTemplate from '../../templates/ProfileTemplate/ProfileTemplate.vue';
import ProfileSummary from '../../molecules/ProfileSummary/ProfileSummary.vue';
import PersonalInfoCard from '../../organisms/PersonalInfoCard/PersonalInfoCard.vue';
import BookingsTable from '../../organisms/BookingsTable/BookingsTable.vue';
import Text from '../../atoms/Text/Text.vue';
import Badge from '../../atoms/Badge/Badge.vue';
import MyButton from '../../atoms/Button/Button.vue';

const route = useRoute();
const router = useRouter();
const bookings = ref([]);
const savedUser = JSON.parse(localStorage.getItem('user') || '{}');
const user = ref({
  firstName: savedUser.firstName || '',
  lastName: savedUser.lastName || '',
  email: savedUser.email || '',
  profilePicture: savedUser.profilePicture || '',
  createdAt: savedUser.createdAt || ''
});

const loading = ref(true);
const fetchProfileData = async () => {
  try {
    loading.value = true;
    const token = localStorage.getItem('auth_token'); 

    if (!token) {
      router.push('/login');
      return;
    }

    const headers = {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    };
    //const userResponse = await fetch('/api/profile', { headers });
    const userResponse = await fetch('http://localhost/api/profile', { 
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        } 
    });
    
    if (userResponse.status === 401) {
      throw new Error("Unauthorized");
    }

    const userData = await userResponse.json();
    user.value = userData.data || userData;

    const bookingsResponse = await fetch('http://localhost/api/my-bookings', { headers });
    const bData = await bookingsResponse.json();
    
    const actualBookings = bData.data || bData;
    bookings.value = Array.isArray(actualBookings) ? actualBookings : [];
    
  } catch (error) {
    console.error("JWT Fetch Error:", error.message);
    if (error.message === "Unauthorized") {
       handleLogout(); 
    }
  } finally {
    loading.value = false;
  }
};

const handleCancel = async (bookingId) => {
  if (confirm("Are you sure you want to cancel this booking?")) {
    const token = localStorage.getItem('auth_token');
    try {
      const response = await fetch(`http://localhost:8080/api/bookings/${bookingId}/cancel`, {
        method: 'POST',
        headers: { 'Authorization': `Bearer ${token}` }
      });
      
      if (response.ok) {
        await fetchProfileData(); 
      } else {
        alert("Could not cancel booking.");
      }
    } catch (error) {
      console.error("Cancel error:", error);
    }
  }
};

const handleLogout = () => {
  localStorage.removeItem('auth_token'); 
  localStorage.removeItem('user');      
  router.push('/login');
};

const openEditModal = () => {
  console.log("Edit modal opened");
};

onMounted(fetchProfileData);
</script>