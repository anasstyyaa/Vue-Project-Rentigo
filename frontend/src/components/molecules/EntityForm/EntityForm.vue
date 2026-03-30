<template>
  <form @submit.prevent="$emit('submit', formData)" class="space-y-4">
    <!-- for users, i want to show the current profile picture if it exists -->
    <div v-if="formData.profilePicture" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
        Profile Picture Preview
      </label>
      <div class="w-24 h-24 relative">
        <img 
          :src="getProfilePreview(formData.profilePicture)" 
          class="h-full w-full object-cover rounded-full border-2 border-gray-200"
        />
      </div>
    </div>

    <!-- for cars, i show all current images with options to set main or delete -->
    <div v-if="formData.images && formData.images.length > 0" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
        Current Vehicle Photos
      </label>
      <div class="grid grid-cols-4 gap-3">
        <div v-for="(img, index) in formData.images" :key="index" class="relative group aspect-square">
          <img 
            :src="'http://localhost/' + img" 
            class="h-full w-full object-cover rounded-lg border-2 transition-all"
            :class="img === formData.mainImage ? 'border-yellow-400 ring-2 ring-yellow-100' : 'border-gray-200'"
          />

          <button 
            type="button"
            @click="setAsMain(img)"
            class="absolute -top-2 -left-2 rounded-full p-1 shadow-md transition-all z-10"
            :class="img === formData.mainImage ? 'bg-yellow-400 text-white' : 'bg-white text-gray-400 hover:text-yellow-500'"
            title="Set as main photo"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.169L12 18.896l-7.334 3.87 1.4-8.169L.132 9.21l8.2-1.192L12 .587z"/>
            </svg>
          </button>

          <button 
            type="button"
            @click="deleteImageManually(img)"
            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-transform scale-90 group-hover:scale-100 z-10"
            title="Delete photo"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div v-for="field in schema" :key="field.key">
      <FormField
        :id="field.key"
        :label="field.label"
        :type="field.type || 'text'"
        :modelValue="formData[field.key]"
        @update:modelValue="val => handleFieldUpdate(field.key, val)"
        :placeholder="field.placeholder"
        :options="field.options"
        :multiple="field.multiple" 
      />
    </div>
    
    <div class="flex justify-end space-x-3 pt-4">
      <button type="button" @click="$emit('cancel')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
        Cancel
      </button>
      <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
        Save Changes
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue';
import FormField from '../../atoms/FormField/FormField.vue';
import axios from '../../../utils/axios'; 

const props = defineProps({
  schema: Array,
  initialData: Object
});

const emit = defineEmits(['submit', 'cancel']);
const formData = ref({});

const updateFormData = (data) => {
  if (!data) return;
  //formData.value = JSON.parse(JSON.stringify(data));
  formData.value = { ...data };
  if (!formData.value.images) formData.value.images = [];
};

const handleFieldUpdate = (key, value) => {
  formData.value[key] = value;
};

const deleteImageManually = async (url) => {
  if (confirm('Delete this photo permanently from the server?')) {
    try {
      await axios.post('/api/cars/delete-image', { imageUrl: url });
      formData.value.images = formData.value.images.filter(img => img !== url);
      props.initialData.images = props.initialData.images.filter(img => img !== url);
    } catch (error) {
      console.error("Delete error:", error);
      alert('Failed to delete image.');
    }
  }
};

const setAsMain = async (url) => {
  try {
    await axios.post('/api/cars/set-main-image', { 
      carId: formData.value.carId, 
      imageUrl: url 
    });

    formData.value.mainImage = url;
    props.initialData.mainImage = url;
    
    alert("Main image updated!");
  } catch (error) {
    console.error("Error setting main image:", error);
  }
};


const getProfilePreview = (value) => {
  if (!value) return '';
  
  if (typeof value === 'string') {
    return 'http://localhost/' + value;
  }
  if (value instanceof File) {
    return URL.createObjectURL(value);
  }
  
  return '';
};

updateFormData(props.initialData);

// watching for changes when the Edit button is clicked in the parent
watch(() => props.initialData, (newVal) => {
  updateFormData(newVal);
}, { deep: true, immediate: true });
</script>