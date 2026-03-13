<template>
  <AuthTemplate>
    <template #header>
      <Header />
    </template>

    <div v-if="successMessage" class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm text-center">
      {{ successMessage }}
    </div>

    <template #form>
      <LoginForm 
        :loading="isLoading" 
        :error="errorMessage" 
        @login="handleLogin" 
      />
    </template>
  </AuthTemplate>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from "vue-router";
import axios, { setAuthToken } from '../../../utils/axios.js';

import AuthTemplate from '../../templates/AuthTemplate/AuthTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import LoginForm from '../../organisms/LoginForm/LoginForm.vue';

const router = useRouter();
const route = useRoute();
const isLoading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

const handleLogin = async (loginData) => {
  isLoading.value = true;
  errorMessage.value = null;

  try { 
    const response = await axios.post('/api/login', {
      email: loginData.email, 
      password: loginData.password,
    });

    const result = response.data;

    if (result.token) {
      setAuthToken(result.token);

      if (result.user) {
        localStorage.setItem('user', JSON.stringify(result.user));
        console.log("Found user:", result.user.Username);
      }

      router.push('/');
    } else {
      errorMessage.value = 'No token received from server';
    }

    } catch (err) {
      console.error('Login error:', err);
      errorMessage.value = err.response?.data?.error || 'Login failed. Please check your credentials.';
    } finally {
      isLoading.value = false;
    }
};

onMounted(() => {
  if (route.query.registered === 'true') {
    successMessage.value = "Registration successful! Please log in.";
  }
});

</script>