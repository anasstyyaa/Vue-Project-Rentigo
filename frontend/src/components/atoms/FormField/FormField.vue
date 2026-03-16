<template>
  <div :class="type === 'checkbox' ? 'flex items-center space-x-3' : 'space-y-1'">
    <label v-if="type !== 'checkbox'" :for="id" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>

    <select
      v-if="options"
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
      v-else
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
defineProps(['id', 'label', 'type', 'modelValue', 'placeholder', 'options']);
const emit = defineEmits(['update:modelValue']);

const handleInput = (event) => {
  const value = event.target.type === 'checkbox' ? event.target.checked : event.target.value;
  emit('update:modelValue', value);
};
</script>