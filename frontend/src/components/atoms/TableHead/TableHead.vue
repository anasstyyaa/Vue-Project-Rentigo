<template>
  <th 
    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b border-gray-200"
    :class="{ 'cursor-pointer hover:bg-gray-100 transition-colors': sortable }"
    @click="handleClick"
  >
    <div class="flex items-center space-x-1">
      <span>
        <slot />
      </span>
      
      <span v-if="sortable" class="inline-block w-4 h-4 text-gray-400">
        <svg v-if="sortDirection === 'asc'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        <svg v-else-if="sortDirection === 'desc'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="opacity-30">
          <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
        </svg>
      </span>
    </div>
  </th>
</template>

<script setup>
const props = defineProps({
  sortable: {
    type: Boolean,
    default: false
  },
  sortDirection: {
    type: String,
    default: null,
    validator: (value) => [null, 'asc', 'desc'].includes(value)
  }
});

const emit = defineEmits(['sort']);

const handleClick = () => {
  if (props.sortable) {
    emit('sort');
  }
};
</script>