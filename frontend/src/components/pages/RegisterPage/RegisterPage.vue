<template>
  <AuthTemplate>
    <template #header>
      <Header />
    </template>

    <template #form>
      <RegisterForm 
        :loading="isLoading" 
        :error="errorMessage" 
        @register="handleRegister" 
      />
    </template>
  </AuthTemplate>
</template>

<script setup>
import { ref } from 'vue';
import axios from '../../../utils/axios.js';
import { useRouter } from "vue-router";

import AuthTemplate from '../../templates/AuthTemplate/AuthTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import RegisterForm from '../../organisms/RegisterForm/RegisterForm.vue';

const router = useRouter();
const isLoading = ref(false);
const errorMessage = ref('');

const handleRegister = async (data) => {
  isLoading.value = true;
  errorMessage.value = '';

  try {
    const response = await axios.post("/api/register", {
      firstName: data.firstName,
      lastName: data.lastName,
      email: data.email,
      passwordHash: data.password, 
      username: data.username, 
      phoneNumber: data.phoneNumber
    });

    router.push({ path: '/login', query: { registered: 'true' } });

  } catch (err) {
    console.error('Registration error:', err);
    
    if (err.response && err.response.data) {
      errorMessage.value = err.response.data.error || "Registration failed";
    } else {
      errorMessage.value = "An unexpected error occurred. Please try again.";
    }

  } finally {
    isLoading.value = false;
  }
};
</script>