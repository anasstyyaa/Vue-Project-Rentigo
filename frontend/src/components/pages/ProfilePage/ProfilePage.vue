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
      </div>
    </template>

    <template #sidebar>
      <PersonalInfoCard :user="user" @edit="openEditModal" />
    </template>

    <template #content>
      <BookingsTable 
        :bookings="bookings" 
        @cancel-booking="openCancelModal" 
      />
    </template>
  </ProfileTemplate>

  <ModalAtom :show="showCancelModal" @close="showCancelModal = false">
    <CancelBookingForm 
      v-if="activeBooking"
      :carImage="`http://localhost/${activeBooking.carImage}`"
      :carBrand="activeBooking.carBrand || activeBooking.carName.split(' ')[0]"
      :carModel="activeBooking.carModel || activeBooking.carName.split(' ')[1]"
      :carYear="activeBooking.carYear || '2024'"
      :carTransmission="activeBooking.carTransmission || 'Auto'"
      :loading="cancelLoading"
      @close="showCancelModal = false"
      @submit="handleCancelSubmit"
    />
  </ModalAtom>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { post, get } from "../../../utils/api.js";

import Header from '../../organisms/Header/Header.vue';
import ProfileTemplate from '../../templates/ProfileTemplate/ProfileTemplate.vue';
import ProfileSummary from '../../molecules/ProfileSummary/ProfileSummary.vue';
import PersonalInfoCard from '../../organisms/PersonalInfoCard/PersonalInfoCard.vue';
import BookingsTable from '../../organisms/BookingsTable/BookingsTable.vue';
import Text from '../../atoms/Text/Text.vue';
import Badge from '../../atoms/Badge/Badge.vue';
import MyButton from '../../atoms/Button/Button.vue';
import ModalAtom from '../../atoms/Modal/Modal.vue';
import CancelBookingForm from '../../organisms/CancelBookingForm/CancelBookingForm.vue'; 

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


const showCancelModal = ref(false);
const activeBooking = ref(null);
const cancelLoading = ref(false);

const openCancelModal = (bookingId) => {
  activeBooking.value = bookings.value.find(b => b.rentalId === bookingId);
  if (activeBooking.value) {
    showCancelModal.value = true;
  }
};

// const handleCancel = async (bookingId) => {
//   if (!confirm("Are you sure you want to cancel this booking?")) return;

//   const token = localStorage.getItem('auth_token');
  
//   try {
//     const response = await fetch(`http://localhost/api/bookings/${bookingId}/cancel`, {
//       method: 'POST',
//       headers: { 
//         'Authorization': `Bearer ${token}`,
//         'Content-Type': 'application/json' 
//       },
//       body: JSON.stringify({ reason: 'Cancelled by user' })
//     });
    
//     if (response.ok) {
//       await fetchProfileData(true); 
//     } else {
//       const errorData = await response.json();
//       alert(errorData.error || "Could not cancel booking.");
//     }
//   } catch (error) {
//     console.error("Cancel error:", error);
//     alert("Server connection error. Please try again.");
//   }
// };

const handleCancelSubmit = async (reason) => {
  if (!activeBooking.value) return;
  
  cancelLoading.value = true;
  const token = localStorage.getItem('auth_token');
  
  try {
    const response = await fetch(`http://localhost/api/bookings/${activeBooking.value.rentalId}/cancel`, {
      method: 'POST',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json' 
      },
      body: JSON.stringify({ reason: reason }) 
    });
    
    if (response.ok) {
      showCancelModal.value = false;
      activeBooking.value = null; // Reset
      await fetchProfileData(); // Refresh table
    } else {
      const errorData = await response.json();
      alert(errorData.error || "Could not cancel booking.");
    }
  } catch (error) {
    console.error("Cancel error:", error);
  } finally {
    cancelLoading.value = false;
  }
};

const openEditModal = () => {
  console.log("Edit modal opened");
};



onMounted(fetchProfileData);
</script>