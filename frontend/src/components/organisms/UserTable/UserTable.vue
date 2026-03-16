<template>
  <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <TableHead>ID</TableHead>
          <TableHead sortable @sort="$emit('sort', 'name')">Name</TableHead>
          <TableHead>Email</TableHead>
          <TableHead align="center">Status</TableHead>
          <TableHead align="right">Actions</TableHead>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        <tr v-if="users.length === 0">
          <td colspan="5" class="px-6 py-12 text-center text-gray-500">
            <div class="flex flex-col items-center">
              <p>No users found matching your criteria.</p>
            </div>
          </td>
        </tr>

        <UserTableRow 
          v-for="user in users" 
          :key="user.userId" 
          :user="user"
          @edit="$emit('edit', $event)"
          @delete="$emit('delete', $event)"
        />
      </tbody>
    </table>
  </div>
</template>

<script setup>
import TableHead from '../../atoms/TableHead/TableHead.vue';
import UserTableRow from '../../molecules/UserTableRow/UserTableRow.vue';

const props = defineProps({
  users: {
    type: Array,
    required: true,
    default: () => []
  }
});

defineEmits(['edit', 'delete', 'sort']);
</script>