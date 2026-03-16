<template>
  <form @submit.prevent="$emit('submit', formData)" class="space-y-4">
    <div v-for="field in schema" :key="field.key">
      <FormField
        :id="field.key"
        :label="field.label"
        :type="field.type || 'text'"
        v-model="formData[field.key]"
        :placeholder="field.placeholder"
        :options="field.options"
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

const props = defineProps({
  schema: Array,       // Defines the fields (label, key, type)
  initialData: Object  // Existing data if editing
});

const emit = defineEmits(['submit', 'cancel']);

const formData = ref({});

const updateFormData = (data) => {
  formData.value = data ? { ...data } : {};
};

updateFormData(props.initialData);

watch(() => props.initialData, (newVal) => {
  updateFormData(newVal);
}, { deep: true });
</script>