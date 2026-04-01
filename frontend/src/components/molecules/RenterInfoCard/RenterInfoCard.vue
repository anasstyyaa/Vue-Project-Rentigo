<template>
  <div class="bg-white p-4 rounded-2xl border border-gray-100 flex flex-col gap-3 text-left">
    <Text size="xs" color="muted" weight="bold" class="uppercase tracking-wider">Renter Details</Text>
    
    <div class="flex items-center gap-3 pb-2 border-b border-gray-50">
      <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center shrink-0">
        <Text size="sm" class="!text-white font-bold">
          {{ initials }}
        </Text>
      </div>
      <div>
        <Text size="base" weight="semibold" class="block">{{ firstName }} {{ lastName }}</Text>
        <Text size="xs" color="muted">Primary Driver</Text>
      </div>
    </div>

    <div class="space-y-2 pt-1">
      <div v-if="email" class="flex items-center gap-2">
        <MailIcon :size="16" class="text-gray-400 group-hover:text-black transition-colors" />
        <Text size="sm">{{ email }}</Text>
      </div>
      <div v-if="phone" class="flex items-center gap-2">
        <PhoneIcon :size="16" class="text-gray-400 group-hover:text-black transition-colors" />
        <Text size="sm">{{ phone }}</Text>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import Text from '../../atoms/Text/Text.vue';
import { Mail as MailIcon, Phone as PhoneIcon } from 'lucide-vue-next';

const props = defineProps({
  firstName: { type: String, default: 'Guest' },
  lastName: { type: String, default: '' },
  email: String,
  phone: String
});

const initials = computed(() => {
  const f = props.firstName ? props.firstName[0] : '';
  const l = props.lastName ? props.lastName[0] : '';
  return (f + l).toUpperCase();
});
</script>