<template>
  <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
    <TableCell>
      <span class="text-xs font-mono text-gray-400">{{ user.userId }}</span>
    </TableCell>

    <TableCell primary>
      {{ user.firstName }} {{ user.lastName }}
    </TableCell>

    <TableCell>
      {{ user.email }}
    </TableCell>

    <TableCell>
      <StatusBadge :type="user.isActive ? 'success' : 'danger'">
        {{ user.isActive ? 'Active' : 'Inactive' }}
      </StatusBadge>
    </TableCell>

    <TableCell align="right">
      <div class="flex justify-end space-x-4">
        <IconButton 
          variant="primary" 
          label="Edit User" 
          @click="$emit('edit', user)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
        </IconButton>

        <IconButton 
          variant="danger" 
          label="Delete User" 
          @click="$emit('delete', user.userId)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </IconButton>
      </div>
    </TableCell>
  </tr>
</template>

<script setup>
import TableCell from '../../atoms/TableCell/TableCell.vue';
import StatusBadge from '../../atoms/StatusBadge/StatusBadge.vue';
import IconButton from '../../atoms/IconButton/IconButton.vue';

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
});

defineEmits(['edit', 'delete']);
</script>