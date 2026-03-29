<template>
  <AdminTemplate>
    <template #sidebar-nav>
      <router-link to="/" class="nav-link-back mb-4 flex items-center text-blue-400 hover:text-white group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Website
      </router-link>

      <router-link to="/admin/dashboard" class="nav-link" active-class="active">Dashboard</router-link>
      <router-link to="/admin/users" class="nav-link" active-class="active">Manage Users</router-link>
      <router-link to="/admin/cars" class="nav-link" active-class="active">Manage Cars</router-link>
    </template>

    <template #sidebar-footer>
      <button @click="handleLogout" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
      </button>
    </template>

    <template #header-left>
      <h1 class="text-xl font-bold text-gray-800">{{ title }}</h1>
    </template>

    <template #header-right>
      <div class="flex items-center space-x-3">
        <div class="text-right">
          <p class="text-sm font-semibold text-gray-900 leading-none">{{ adminName }}</p>
          <p class="text-xs text-gray-500">Administrator</p>
        </div>
        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
          {{ adminInitial }}
        </div>
      </div>
    </template>

    <template #main-content>
      <slot />
    </template>
  </AdminTemplate>
</template>

<script setup>
import { computed } from 'vue';
import AdminTemplate from '../../templates/AdminTemplate/AdminTemplate.vue';

const props = defineProps({
  title: {
    type: String,
    default: 'Admin Panel'
  }
});

const emit = defineEmits(['logout']);

const adminUser = computed(() => {
  try {
    return JSON.parse(localStorage.getItem('user')) || { firstName: 'Admin' };
  } catch {
    return { firstName: 'Admin' };
  }
});

const adminName = computed(() => adminUser.value.firstName);
const adminInitial = computed(() => adminName.value.charAt(0).toUpperCase());

const handleLogout = () => {
  emit('logout');
  localStorage.removeItem('user');
  window.location.href = '/login';
};
</script>

<style scoped>
@reference "../../../assets/main.css"; 

.nav-link {
  @apply block px-4 py-2.5 rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white transition-all mb-1;
}

.active {
  @apply !bg-blue-600 !text-white !shadow-md;
}
</style>