<template>
  <div class="bg-white p-10 rounded-2xl shadow-xl border border-gray-100 w-full">
    <Heading :level="2" size="2xl" class="mb-2 text-center">Welcome Back</Heading>
    <Text as="p" size="sm" color="muted" class="mb-8 text-center">
      Log in to manage your bookings and profile.
    </Text>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="space-y-1">
        <Text as="label" size="sm" weight="semibold" class="block">Email Address</Text>
        <input 
          v-model="credentials.email" 
          type="email" 
          required
          placeholder="name@company.com"
          class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-3 transition-all outline-none"
        />
      </div>

      <div class="space-y-1">
        <div class="flex justify-between items-center">
          <Text as="label" size="sm" weight="semibold">Password</Text>
        </div>
        <input 
          v-model="credentials.password" 
          type="password" 
          required
          placeholder="••••••••"
          class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-3 transition-all outline-none"
        />
      </div>

      <div v-if="error" class="flex justify-center">
        <Badge variant="danger" size="md">{{ error }}</Badge>
      </div>

      <MyButton 
        :label="loading ? 'Authenticating...' : 'Sign In'" 
        :primary="true" 
        size="large" 
        class="w-full h-12 !rounded-xl"
        @click="handleSubmit"
      />

      <div class="text-center pt-2">
        <Text size="sm" color="muted">
          Don't have an account? 
          <router-link to="/register" class="text-blue-600 font-bold cursor-pointer hover:underline">
            Register here
          </router-link>
        </Text>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import Heading from "../../atoms/Heading/Heading.vue";
import Text from "../../atoms/Text/Text.vue";
import Badge from "../../atoms/Badge/Badge.vue";
import MyButton from "../../atoms/Button/Button.vue"; // Adjusted to your Button.vue path

const props = defineProps({
  loading: { type: Boolean, default: false },
  error: { type: String, default: '' }
});

const emit = defineEmits(['login', 'toggle-auth']);

const credentials = reactive({
  email: '',
  password: ''
});

const handleSubmit = () => {
  if (!credentials.email || !credentials.password) return;
  emit('login', { ...credentials });
};
</script>

<style scoped>
.form-input {
  width: 100%;
  margin-top: 0.25rem;
  display: block;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  padding: 0.75rem;
  transition: all 0.2s;
}
.form-input:focus {
  border-color: #2563eb;
  outline: none;
  box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
}
</style>