<template>
  <AdminHeader title="User Management">
    <div class="mb-6 flex justify-between items-center">
      <p class="text-gray-600">Overview of all registered users and their status.</p>
      <button @click="openCreateModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        + Add User
      </button>
    </div>

    <UserTable 
      :users="users" 
      :loading="isLoading"
      @edit="openEditModal"
      @delete="handleDelete"
    />

    <div v-if="pagination.totalPages > 1" class="mt-6 flex items-center justify-between bg-white p-4 rounded-lg shadow-sm">
      <span class="text-sm text-gray-600">
        Page {{ currentPage }} of {{ pagination.totalPages }}
      </span>
      
      <div class="flex gap-2">
        <button 
          @click="fetchUsers(currentPage - 1)" 
          :disabled="currentPage === 1"
          class="px-4 py-2 border rounded disabled:opacity-50 hover:bg-gray-50"
        >
          Previous
        </button>
        
        <button 
          @click="fetchUsers(currentPage + 1)" 
          :disabled="currentPage === pagination.totalPages"
          class="px-4 py-2 border rounded disabled:opacity-50 hover:bg-gray-50"
        >
          Next
        </button>
      </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl w-full max-w-md flex flex-col max-h-[90vh]">
        
        <div class="p-6 border-b border-gray-100">
          <h2 class="text-xl font-bold">
            {{ editingUser ? 'Edit User' : 'Create New User' }}
          </h2>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6">
          <EntityForm 
            :schema="userSchema" 
            :initialData="editingUser || {}" 
            @submit="handleFormSubmit" 
            @cancel="closeModal" 
          />
        </div>

      </div>
    </div>
  </AdminHeader>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from '../../../utils/axios';
import UserTable from '../../organisms/UserTable/UserTable.vue';
import EntityForm from '../../molecules/EntityForm/EntityForm.vue';
import AdminHeader from '@/components/organisms/AdminHeader/AdminHeader.vue';

const route = useRoute();
const router = useRouter();
const users = ref([]);
const isLoading = ref(false);
const currentPage = ref(1);
const pagination = ref({
  totalPages: 1,
  totalItems: 0
});

const isModalOpen = ref(false);
const editingUser = ref(null); // null means "create mode", object means "edit mode"

const adminName = computed(() => {
  const user = JSON.parse(localStorage.getItem('user'));
  return user ? user.firstName : 'Admin';
});

const userSchema = computed(() => {
  const baseSchema = [
    { key: 'firstName', label: 'First Name' },
    { key: 'lastName', label: 'Last Name' },
    { key: 'email', label: 'Email', type: 'email' },
    { 
      key: 'profilePicture', 
      label: 'Profile Picture', 
      type: 'file', 
      accept: 'image/*' 
    },
    { key: 'username', label: 'Username' }, 
    { key: 'phoneNumber', label: 'Phone Number' }, 
    { key: 'roleId', label: 'Is Admin', type: 'checkbox' }
  ];

  if (!editingUser.value) {
    baseSchema.push({ 
      key: 'passwordHash', 
      label: 'Password', 
      type: 'passwordHash', 
      placeholder: 'Min 8 characters' 
    });
  }

  return baseSchema;
});

const openCreateModal = () => {
  editingUser.value = null;
  isModalOpen.value = true;
};

const openEditModal = (user) => {
  editingUser.value = { ...user }; // clone the user 
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const fetchUsers = async (page = 1) => {
  isLoading.value = true;
  currentPage.value = page;
  try {
    const response = await axios.get(`/api/users?page=${page}&limit=10`);
    users.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (error) {
    console.error("Error fetching users:", error);
    alert("Failed to load users.");
  } finally {
    isLoading.value = false;
  }
};

const handleFormSubmit = async (formData) => {
  const isEdit = !!editingUser.value;
  const submissionData = new FormData();

  Object.keys(formData).forEach(key => {
    const value = formData[key];
    
    if (key === 'profilePicture') {
      const file = value instanceof File ? value : (value && value.raw instanceof File ? value.raw : null);
      
      if (file) {
        submissionData.append('profilePicture', file);
      } else if (typeof value === 'string' && value !== '[object File]') {
        submissionData.append('profilePicture', value);
      }
    } else if (value !== undefined && value !== null) {
      if (key === 'roleId') {
        submissionData.append(key, (value === true || value === 2) ? '2' : '1');
      } else {
        submissionData.append(key, value);
      }
    }
  });

  for (let pair of submissionData.entries()) {
    console.log(pair[0] + ': ', pair[1]);
  }

  try {
    let url = isEdit ? `/api/users/${editingUser.value.userId}` : '/api/register';
    await axios({
      method: 'post',
      url: url,
      data: submissionData,
      headers: {
        'Content-Type': undefined 
      }
    });

    closeModal();
    await fetchUsers(currentPage.value);
  } catch (error) {
    console.error("Server Response:", error.response?.data);
  }
};

const handleDelete = async (userId) => {
  if (confirm("Are you sure you want to delete this user?")) {
    try {
      await axios.delete(`/api/users/${userId}`);
      users.value = users.value.filter(u => u.userId !== userId);
    } catch (error) {
      console.error("Error deleting user:", error);
      alert("Delete failed.");
    }
  }
};

onMounted(fetchUsers);

const logout = () => {
  localStorage.removeItem('user');
  window.location.href = '/login';
};
</script>

<style scoped>
@reference "../../../assets/main.css";

.nav-link {
  @apply block px-4 py-2.5 rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white transition-all;
}
.nav-link.active {
  @apply bg-blue-600 text-white;
}
</style>