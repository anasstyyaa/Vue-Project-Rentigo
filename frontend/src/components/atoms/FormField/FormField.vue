<template>
  <div :class="type === 'checkbox' ? 'flex items-center space-x-3' : 'space-y-1'">
    <label v-if="type !== 'checkbox'" :for="id" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>

    <div v-if="type === 'file'">
      <input
        :id="id"
        type="file"
        :multiple="multiple"
        :accept="accept"
        @change="handleFileChange"
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
      />
      <p class="mt-1 text-xs text-gray-500">Selected: {{ fileCount }} / 4 photos</p>
    </div>

    <select
      v-else-if="options"
      :id="id"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
    >
      <option value="" disabled>Select {{ label }}</option>
      <option v-for="opt in options" :key="opt.value" :value="opt.value">
        {{ opt.label }}
      </option>
    </select>

    <input
      v-else-if="type !== 'file' && !options" 
      :id="id"
      :type="type"
      :placeholder="placeholder"
      :checked="type === 'checkbox' ? !!modelValue : undefined"
      :value="type !== 'checkbox' ? modelValue : undefined"
      @input="handleInput"
      :class="[
        type === 'checkbox' 
          ? 'h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500' 
          : 'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
      ]"
    />

    <label v-if="type === 'checkbox'" :for="id" class="text-sm font-medium text-gray-700">
      {{ label }}
    </label>
  </div>
</template>
<script setup>
import { ref } from 'vue';


const props = defineProps([
  'id', 'label', 'type', 'multiple', 'accept', 'modelValue', 'placeholder', 'options'
]);

const emit = defineEmits(['update:modelValue']);

const fileCount = ref(0);

const handleFileChange = (event) => {
  const files = event.target.files;
  if (!files) return;

  fileCount.value = files.length;

  if (props.multiple) {
    // for cars emit the whole array
    const fileArray = Array.from(files);
    emit('update:modelValue', fileArray);
  } else {
    // for users emit just the first File object
    emit('update:modelValue', files[0]);
  }
};

const handleInput = (event) => {
  const value = event.target.type === 'checkbox' ? event.target.checked : event.target.value;
  emit('update:modelValue', value);
};
</script>