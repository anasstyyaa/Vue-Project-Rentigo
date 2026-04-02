<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Header />
    
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <div class="mb-8">
        <Heading :level="1" size="3xl" class="mb-2">Rentigo Fleet</Heading>
        <Text as="p" size="lg" color="muted">Premium car rentals for your next adventure</Text>
      </div>
      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <aside class="lg:col-span-3 space-y-8">
          <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
            <Text weight="bold" class="mb-4 block uppercase tracking-wider text-xs text-blue-600">Search</Text>
            <input 
              :value="search" 
              @input="$emit('update:search', $event.target.value)"
              placeholder="Brand or model..." 
              class="w-full border border-gray-200 p-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" 
            />

            <hr class="my-6 border-gray-100" />

            <Text weight="bold" class="mb-4 block uppercase tracking-wider text-xs text-blue-600">Filters</Text>
            
            <div class="mb-6">
              <div class="flex justify-between mb-2">
                <Text size="sm">Max Price</Text>
                <Text size="sm" weight="bold">${{ filters.maxPrice }}</Text>
              </div>
              <input 
                type="range" 
                :value="filters.maxPrice" 
                @input="$emit('update:filters', { ...filters, maxPrice: $event.target.value })"
                min="0" max="1000" step="10" 
                class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600" 
              />
            </div>

            <div class="mb-6">
              <Text size="sm" class="mb-2 block">Transmission</Text>
              <select 
                :value="filters.transmission" 
                @change="$emit('update:filters', { ...filters, transmission: $event.target.value })"
                class="w-full border border-gray-200 p-2.5 rounded-xl text-sm bg-gray-50"
              >
                <option value="all">All</option>
                <option value="Manual">Manual</option>
                <option value="Automatic">Automatic</option>
              </select>
            </div>

            <div>
              <Text size="sm" class="mb-2 block">Sort By</Text>
              <select 
                :value="sort" 
                @change="$emit('update:sort', $event.target.value)"
                class="w-full border border-gray-200 p-2.5 rounded-xl text-sm bg-gray-50"
              >
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
              </select>
            </div>
          </div>
        </aside>

        <div class="lg:col-span-9">
          <div v-if="cars.length > 0" class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <CarCard
              v-for="car in cars"
              :key="car.carId"
              v-bind="car"
              @learn-more-click="$emit('learn-more-click', car.carId)"
            />
          </div>
          
          <div v-else class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-100">
            <p class="text-gray-500 text-lg">No cars found matching your search.</p>
          </div>
        </div>
      </div>
    </main>
    
    <Footer />
  </div>
</template>

<script setup>
import Header from '../../organisms/Header/Header.vue';
import Footer from '../../organisms/Footer/Footer.vue';
import CarCard from "../../organisms/CarCard/CarCard.vue";
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';

const props = defineProps({
  cars: Array,
  search: String,
  filters: Object,
  sort: String
});

const emit = defineEmits(['learn-more-click', 'update:search', 'update:filters', 'update:sort']);
</script>