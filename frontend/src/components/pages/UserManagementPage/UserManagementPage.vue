<template>
  <AdminHeader>
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

    <div v-if="isModalOpen" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">
          {{ editingUser ? 'Edit User' : 'Create New User' }}
        </h2>
        
        <EntityForm 
          :schema="userSchema" 
          :initialData="editingUser || {}" 
          @submit="handleFormSubmit" 
          @cancel="closeModal" 
        />
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

const fetchUsers = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get('/api/users');
    users.value = response.data;
  } catch (error) {
    console.error("Error fetching users:", error);
    alert("Failed to load users.");
  } finally {
    isLoading.value = false;
  }
};

const handleFormSubmit = async (formData) => {
  const submissionData = {
    ...formData,
    // if checked (true), role is 2 (Admin), else 1 (User)
    roleId: formData.roleId === true || formData.roleId === 2 ? 2 : 1,
    isActive: 1
  };

  try {
    const method = editingUser.value ? 'put' : 'post';
    const url = editingUser.value 
      ? `/api/users/${editingUser.value.userId}` 
      : '/api/register';

    await axios[method](url, submissionData);
    
    closeModal();
    await fetchUsers();
  } catch (error) {
    alert(error.response?.data?.error || "An error occurred while saving.");
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