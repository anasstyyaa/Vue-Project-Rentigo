<template>
  <div class="bg-white p-10 rounded-2xl shadow-xl border border-gray-100 w-full">
    <Heading :level="2" size="2xl" class="mb-2 text-center">Create Account</Heading>
    
    <Text as="p" size="sm" color="muted" class="mb-8 text-center">
      Join Rentigo to start booking.
    </Text>

    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <Text as="label" size="sm" weight="semibold">First Name</Text>
          <input 
            v-model="formData.firstName" 
            type="text" 
            :class="['form-input', errors.firstName ? 'border-red-500' : '']" 
            required 
          />
          <p v-if="errors.firstName" class="text-red-600 text-xs mt-1">
            {{ errors.firstName }}
          </p>
        </div>
        <div>
          <Text as="label" size="sm" weight="semibold">Last Name</Text>
          <input v-model="formData.lastName" type="text" class="form-input" required />
        </div>
      </div>

      <div>
        <Text as="label" size="sm" weight="semibold">Username</Text>
        <input 
          v-model="formData.username" 
          type="text" 
          :class="['form-input', errors.username ? 'border-red-500' : '']" 
          required  
        />
        <p v-if="errors.username" class="text-red-600 text-xs mt-1">
          {{ errors.username }}
        </p>
      </div>

     <div>
        <Text as="label" size="sm" weight="semibold">Phone Number</Text>
        <input 
          v-model="formData.phoneNumber" 
          type="text" 
          :class="['form-input', errors.phoneNumber ? 'border-red-500' : '']" 
          required 
        />
        <p v-if="errors.phoneNumber" class="text-red-600 text-xs mt-1">
          {{ errors.phoneNumber }}
        </p>
      </div>

      <div>
        <Text as="label" size="sm" weight="semibold">Email</Text>
        <input 
          v-model="formData.email" 
          type="email" 
          :class="['form-input', errors.email ? 'border-red-500' : '']" 
        />
        <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
      </div>

      <div>
        <Text as="label" size="sm" weight="semibold">Password</Text>
        <input 
          v-model="formData.password" 
          type="password" 
          :class="['form-input', errors.password ? 'border-red-500' : '']" 
        />
        <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password }}</p>
      </div>

      <div v-if="error" class="flex justify-center pt-2">
        <Badge variant="danger" size="md">{{ error }}</Badge>
      </div>

      <MyButton 
        :label="loading ? 'Creating Account...' : 'Register'" 
        :primary="true" 
        size="large" 
        class="w-full mt-4"
        @click="handleSubmit"
      />

      <div class="text-center pt-2">
        <Text size="sm" color="muted">
          Already have an account? 
          <router-link to="/login" class="text-blue-600 font-bold hover:underline">
            Log in here
          </router-link>
        </Text>
      </div>

    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import Heading from "../../atoms/Heading/Heading.vue";
import Text from "../../atoms/Text/Text.vue";
import Badge from "../../atoms/Badge/Badge.vue";
import MyButton from "../../atoms/Button/Button.vue";

const props = defineProps({
  loading: { type: Boolean, default: false },
  error: { type: String, default: '' }
});

const emit = defineEmits(['register']);

const formData = reactive({
  firstName: '',
  lastName: '',
  username: '', 
  phoneNumber: '',
  email: '',
  password: ''
});

const errors = reactive({});

const validateForm = () => {
  Object.keys(errors).forEach(key => errors[key] = '');
  let isValid = true;

  if (formData.firstName.trim().length < 2) {
    errors.firstName = 'First name is too short';
    isValid = false;
  }

  if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(formData.email)) {
    errors.email = 'Please enter a valid email address';
    isValid = false;
  }

  if (formData.password.length < 8) {
    errors.password = 'Password must be at least 8 characters';
    isValid = false;
  }

  if (!formData.username.trim()) {
    errors.username = 'Username is required';
    isValid = false;
  }

  if (formData.username.length < 3) {
    errors.username = 'Username must be at least 3 characters';
    isValid = false;
  }

  const phoneRegex = /^[0-9+]{10,15}$/;
  if (!phoneRegex.test(formData.phoneNumber.replace(/\s/g, ''))) {
    errors.phoneNumber = 'Please enter a valid phone number';
    isValid = false;
  }

  return isValid;
};

const handleSubmit = () => {
  if (validateForm()) {
    emit('register', { ...formData });
  }
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
.form-input.border-red-500 {
  border-color: #ef4444; /* Tailwind's red-500 */
}
.form-input.border-red-500:focus {
  box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
}
</style>