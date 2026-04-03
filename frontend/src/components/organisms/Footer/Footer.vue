<template>
  <footer class="bg-gray-50 border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="col-span-1 md:col-span-2">
          <Heading :level="3" size="lg" class="mb-4 text-blue-600">
            Rentigo
          </Heading>
          <Text as="p" size="sm" color="muted" class="mb-4 max-w-sm">
            Premium car rentals for your next journey. Experience comfort, 
            reliability, and style with our extensive fleet of vehicles 
            tailored to your needs.
          </Text>
          <div class="flex space-x-4">
            <a 
              v-for="social in socialLinks" 
              :key="social.name"
              :href="social.href" 
              class="text-gray-400 hover:text-blue-600 transition-colors"
              :aria-label="social.name"
            >
              <span class="text-xs font-bold uppercase tracking-wider">{{ social.name }}</span>
            </a>
          </div>
        </div>
        
        <div>
          <Heading :level="4" size="md" class="mb-4">
            Rent With Us
          </Heading>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link.name">
              <router-link 
                :to="link.href" 
                class="text-gray-600 hover:text-blue-600 transition-colors text-sm"
              >
                {{ link.name }}
              </router-link> 
            </li>
          </ul>
        </div>
        
        <div>
          <Heading :level="4" size="md" class="mb-4">
            Support
          </Heading>
          <ul class="space-y-2">
            <li v-for="link in legalLinks" :key="link.name">
              <router-link 
                :to="link.href" 
                class="text-gray-600 hover:text-blue-600 transition-colors text-sm"
              >
                {{ link.name }}
              </router-link>
            </li>
          </ul>
        </div>
      </div>
      
      <div class="mt-8 pt-8 border-t border-gray-200">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          <Text as="p" size="sm" color="muted">
            © {{ currentYear }} Rentigo Car Rentals. All rights reserved.
          </Text>
          <div class="flex space-x-6">
             <Text size="xs" color="muted" class="hover:text-blue-600 cursor-pointer">Help Center</Text>
             <Text size="xs" color="muted" class="hover:text-blue-600 cursor-pointer">Safety Information</Text>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue';
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';

defineProps({
  quickLinks: {
    type: Array,
    default: () => [
      { name: 'Browse Fleet', href: '/cars' },
      { name: 'Locations', href: '/locations' },
      { name: 'Special Offers', href: '/offers' },
      { name: 'How it Works', href: '/how-it-works' },
    ],
  },
  legalLinks: {
    type: Array,
    default: () => [
      { name: 'Privacy Policy', href: '/privacy' },
      { name: 'Terms & Conditions', href: '/terms' },
      { name: 'Insurance Info', href: '/insurance' },
      { name: 'Contact Us', href: '/contact' },
    ],
  },
  socialLinks: {
    type: Array,
    default: () => [
      { name: 'FB', href: '#' },
      { name: 'IG', href: '#' },
      { name: 'X', href: '#' },
    ],
  },
});

const currentYear = computed(() => new Date().getFullYear());
</script>