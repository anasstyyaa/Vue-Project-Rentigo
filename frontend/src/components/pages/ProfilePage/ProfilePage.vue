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
        @view-details="handleViewDetails"
        @leave-review="openReviewModal"
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
  <ModalAtom :show="showDetailsModal" @close="showDetailsModal = false">
    <div class="p-2">
      <BookingSuccessSummary 
        v-if="selectedBooking" 
        v-bind="selectedBooking" 
        @view-bookings="showDetailsModal = false"
      />
      </div>
  </ModalAtom>
  <ModalAtom :show="showReviewModal" @close="showReviewModal = false">
    <ReviewForm 
      v-if="activeBooking"
      :carName="activeBooking.carName"
      :loading="reviewLoading"
      @submit="handleReviewSubmit"
    />
  </ModalAtom>
  <ModalAtom :show="showEditModal" @close="showEditModal = false">
    <div class="p-6 flex flex-col max-h-[90vh]"> 

      <div class="overflow-y-auto pr-2 custom-scrollbar"> 
        <EntityForm 
          :schema="userSchema" 
          :initialData="user" 
          @submit="handleProfileSubmit" 
          @cancel="showEditModal = false" 
        />
      </div>
      
      <div v-if="editLoading" class="absolute inset-0 bg-white/50 flex items-center justify-center z-50">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
      </div>
    </div>
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
import Heading from '../../atoms/Heading/Heading.vue';
import Badge from '../../atoms/Badge/Badge.vue';
import MyButton from '../../atoms/Button/Button.vue';
import ModalAtom from '../../atoms/Modal/Modal.vue';
import CancelBookingForm from '../../organisms/CancelBookingForm/CancelBookingForm.vue'; 
import BookingSuccessSummary from '../../organisms/BookingSuccessSummary/BookingSuccessSummary.vue';
import ReviewForm from '../../organisms/ReviewForm/ReviewForm.vue';
import EntityForm from '../../molecules/EntityForm/EntityForm.vue';



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
      activeBooking.value = null;
      await fetchProfileData(); 
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


const showDetailsModal = ref(false);
const selectedBooking = ref(null);

const handleViewDetails = (bookingId) => {
  const booking = bookings.value.find(b => b.rentalId === bookingId);
  
  if (booking) {
    const imageName = booking.carImage || booking.mainImage;
    const formattedImage = imageName 
      ? `http://localhost/${imageName}`
      : 'https://placehold.co/600x400?text=No+Image';

    selectedBooking.value = {
      firstName: user.value.firstName,
      lastName: user.value.lastName,
      email: user.value.email, 
      phone: user.value.phone, 
      carImage: formattedImage, 
      carBrand: booking.carName.split(' ')[0],
      carModel: booking.carName.split(' ')[1],
      carYear: booking.carYear || '2024',
      carTransmission: booking.carTransmission || 'Auto',
      totalPrice: booking.totalPrice,
      startDate: booking.startDate,
      endDate: booking.endDate,
      totalDays: booking.totalDays || 1
    };
    showDetailsModal.value = true;
  }
};


const showReviewModal = ref(false);
const reviewLoading = ref(false);

const openReviewModal = (bookingId) => {
  activeBooking.value = bookings.value.find(b => b.rentalId === bookingId);
  if (activeBooking.value) {
    showReviewModal.value = true;
  }
};

const handleReviewSubmit = async (reviewData) => {
  reviewLoading.value = true;
  try {
    const response = await fetch('http://localhost/api/reviews', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        rentalId: activeBooking.value.rentalId,
        carId: activeBooking.value.carId, 
        userId: user.value.id,
        rating: reviewData.rating,
        comment: reviewData.comment
      })
    });

    if (response.ok) {
      showReviewModal.value = false;
      alert("Thank you for your review!");
      await fetchProfileData();
    }
  } catch (error) {
    console.error("Review Error:", error);
  } finally {
    reviewLoading.value = false;
  }
};



const showEditModal = ref(false);
const editLoading = ref(false);

const userSchema = [
  { key: 'firstName', label: 'First Name', placeholder: 'Enter first name' },
  { key: 'lastName', label: 'Last Name', placeholder: 'Enter last name' },
  { key: 'email', label: 'Email Address', type: 'email' },
  { key: 'phoneNumber', label: 'Phone Number', placeholder: '+1 234 567 890' }, 
  { 
    key: 'profilePicture', 
    label: 'Change Profile Picture', 
    type: 'file', 
    accept: 'image/*' 
  }
];

const handleProfileSubmit = async (formData) => {
  editLoading.value = true;
  const token = localStorage.getItem('auth_token');
  
  const data = new FormData();
  data.append('firstName', formData.firstName);
  data.append('lastName', formData.lastName);
  data.append('email', formData.email);
  data.append('phoneNumber', formData.phoneNumber || '');
  
  if (formData.profilePicture instanceof File) {
    data.append('profilePicture', formData.profilePicture);
  }

  try {
    const response = await fetch('http://localhost/api/profile/update', {
      method: 'POST', 
      headers: {
        'Authorization': `Bearer ${token}`
      },
      body: data
    });

    if (response.ok) {
      const updatedUser = await response.json();
      // Update local state and storage
      user.value = updatedUser.data || updatedUser;
      localStorage.setItem('user', JSON.stringify(user.value));
      
      showEditModal.value = false;
      alert("Profile updated successfully!");
    } else {
      alert("Failed to update profile.");
    }
  } catch (error) {
    console.error("Profile Update Error:", error);
  } finally {
    editLoading.value = false;
  }
};

const openEditModal = () => {
  console.log("Edit modal opened");
  showEditModal.value = true; 
};

onMounted(fetchProfileData);
</script>

<style scoped>

.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #cbd5e1; 
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #94a3b8; 
}

.absolute.inset-0 {
  backdrop-filter: blur(2px);
  transition: all 0.3s ease;
}
</style>