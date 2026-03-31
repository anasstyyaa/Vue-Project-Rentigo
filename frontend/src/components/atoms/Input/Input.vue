<template>
  <div class="flex flex-col gap-1.5 w-full">
    <label v-if="label" class="text-sm font-bold text-gray-700">{{ label }}</label>
    <input
      :type="type"
      :value="modelValue"
      :min="min"
      :placeholder="placeholder"
      @input="$emit('update:modelValue', $event.target.value)"
      class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black outline-none transition-all"
    />
  </div>
</template>

<script setup>
defineProps(['modelValue', 'label', 'type', 'min', 'placeholder']);
defineEmits(['update:modelValue']);
</script>