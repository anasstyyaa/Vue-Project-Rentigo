<template>
  <AuthTemplate>
    <template #header>
      <Header />
    </template>

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
import { ref } from 'vue';
import { useRouter } from "vue-router";
import { post } from "../../../utils/api.js";

import AuthTemplate from '../../templates/AuthTemplate/AuthTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import LoginForm from '@/components/organisms/LoginForm/LoginForm.vue';

const router = useRouter();
const isLoading = ref(false);
const errorMessage = ref('');

const handleLogin = async (data) => {
  isLoading.value = true;
  errorMessage.value = null;

  try { 
    const response = await post("/api/login", {
      email: data.email,
      password: data.password
    });

    const result = await response.json();

    if (!response.ok) {
      throw new Error(result.error || result.message || "Login failed");
    }

    const loggedInUser = result.user; 
    
    if (loggedInUser) {
      console.log("Found user:", loggedInUser.firstName);

      localStorage.setItem('user', JSON.stringify(loggedInUser));

      router.push('/'); 
    } else {
      throw new Error("Login succeeded but no user data was returned.");
    }

  } catch (err) {
    errorMessage.value = err.message;
  } finally {
    isLoading.value = false;
  }
};
</script>