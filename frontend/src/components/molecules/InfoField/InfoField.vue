<template>
  <div class="flex flex-col space-y-1 py-2 border-b border-gray-50 last:border-0">
    <Text as="label" weight="semibold" color="muted" size="xs" class="uppercase tracking-wider">
      {{ label }}
    </Text>
    <Text weight="medium" color="default" size="base">
      <slot>{{ value }}</slot>
    </Text>
  </div>
</template>

<script setup>
import Text from '../../atoms/Text/Text.vue';
defineProps({
  label: { type: String, required: true },
  value: { type: String, default: '' }
});
</script>