<template>
  <AdminTemplate>
    <template #sidebar-nav>
        <router-link to="/" class="nav-link-back mb-4 flex items-center text-blue-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Website
        </router-link>

        <router-link to="/admin/dashboard" class="nav-link">Dashboard</router-link>
        <router-link to="/admin/users" class="nav-link active">Manage Users</router-link>
        <router-link to="/admin/cars" class="nav-link">Manage Cars</router-link>
    </template>

    <template #sidebar-footer>
      <button @click="logout" class="text-gray-400 hover:text-white transition-colors text-sm">Logout</button>
    </template>

    <template #header-left>
      <h1 class="text-xl font-bold text-gray-800">User Management</h1>
    </template>

    <template #header-right>
      <div class="text-sm text-gray-500">Admin: <strong>{{ adminName }}</strong></div>
    </template>

    <template #main-content>
      <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Overview of all registered users and their status.</p>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow-sm transition-all text-sm font-medium">
          + Add New User
        </button>
      </div>

      <UserTable 
        :users="users" 
        :loading="isLoading"
        @edit="handleEdit"
        @delete="handleDelete"
      />
    </template>
  </AdminTemplate>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from '../../../utils/axios';
import AdminTemplate from '../../templates/AdminTemplate/AdminTemplate.vue';
import UserTable from '../../organisms/UserTable/UserTable.vue';

const users = ref([]);
const isLoading = ref(false);


const adminName = computed(() => {
  const user = JSON.parse(localStorage.getItem('user'));
  return user ? user.firstName : 'Admin';
});

const fetchUsers = async () => {
  isLoading.value = true;
  try {
    // Assuming you have an endpoint /api/users that returns the list
    const response = await axios.get('/api/users');
    users.value = response.data;
  } catch (error) {
    console.error("Error fetching users:", error);
    alert("Failed to load users.");
  } finally {
    isLoading.value = false;
  }
};

const handleEdit = (user) => {
  console.log("Opening edit modal for:", user);
};

const handleDelete = async (userId) => {
  if (confirm("Are you sure you want to delete this user?")) {
    try {
      await axios.delete(`/api/users/${userId}`);
      users.value = users.value.filter(u => u.UserId !== userId);
    } catch (error) {
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