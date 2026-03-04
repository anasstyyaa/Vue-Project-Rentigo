<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Header />
    
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <div class="mb-8">
        <Heading :level="1" size="3xl" class="mb-2">
          Rentigo
        </Heading>
        <Text as="p" size="lg" color="muted">
          Premium car rentals for your next adventure
        </Text>
      </div>
      
      
      <!-- Article Grid -->
      <div 
        v-if="cars.length > 0" 
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"
      >
        <CarCard
          v-for="car in cars"
          :key="car.id"
          v-bind="car"
          @click="$emit('car-click', car.id)"
        />
      </div>
      
      <!-- Empty State -->
      <div v-else class="text-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-200">
        <p class="text-gray-500 text-lg">No cars found matching your search.</p>
      </div>
      
    </main>
    
    <Footer 
      :quick-links="footerQuickLinks"
      :legal-links="footerLegalLinks"
    />
  </div>
</template>

<script setup>
import Header from '../../organisms/Header/Header.vue';
import Footer from '../../organisms/Footer/Footer.vue';
import CarCard from "../../organisms/CarCard/CarCard.vue";
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';

const props = defineProps({
  cars: {
    type: Array,
    required: true,
    default: () => [],
  },
  footerQuickLinks: {
    type: Array,
    default: () => [
      { name: 'Home', href: '/' },
      { name: 'Articles', href: '/articles' },
      { name: 'Categories', href: '/categories' },
      { name: 'About', href: '/about' },
    ],
  },
  footerLegalLinks: {
    type: Array,
    default: () => [
      { name: 'Privacy Policy', href: '/privacy' },
      { name: 'Terms of Service', href: '/terms' },
      { name: 'Cookie Policy', href: '/cookies' },
    ],
  },
  showFilters: {
    type: Boolean,
    default: false,
  },
  showPagination: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['article-click']);

const handleArticleClick = (articleId) => {
  emit('article-click', articleId);
};
</script>
