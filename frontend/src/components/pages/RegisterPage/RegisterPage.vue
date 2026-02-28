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
import AuthTemplate from '../../templates/AuthTemplate/AuthTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import RegisterForm from '../../organisms/RegisterForm/RegisterForm.vue';

const isLoading = ref(false);
const errorMessage = ref('');

const handleRegister = async (data) => {
  isLoading.value = true;
  errorMessage.value = '';

  try {
    
    const response = await post("/api/register", {
      firstName: data.firstName,
      lastName: data.lastName,
      email: data.email,
      passwordHash: data.password, 
      phoneNumber: "000-000-000" 
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(data.message || "Registration failed");
    }

    window.location.href = "/login?success=1";
  } catch (err) {
    errorMessage.value = err.message;
  } finally {
    isLoading.value = false;
  }
};
</script>