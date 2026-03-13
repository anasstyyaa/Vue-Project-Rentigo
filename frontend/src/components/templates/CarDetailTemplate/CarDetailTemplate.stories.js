import CarDetailTemplate from './CarDetailTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import Footer from '../../organisms/Footer/Footer.vue';
import CarGallery from '../../molecules/CarGallery/CarGallery.vue';
import CarDetailsSidebar from '../../organisms/CarDetails/CarDetails.vue';
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';

export default {
  title: 'Templates/CarDetailTemplate',
  component: CarDetailTemplate,
  parameters: {
    layout: 'fullscreen',
  },
};

const carMock = {
  brand: 'Porsche',
  model: '911 GT3',
  year: 2024,
  pricePerDay: 450,
  isAvailable: true,
  transmission: 'PDK',
  fuelType: 'Petrol',
  seats: 2,
  color: 'Shark Blue',
  description: 'The 911 GT3 is a high-performance homologation model of the Porsche 911 sports car. It is a line of high-performance models, which began with the 1973 911 Carrera RS.'
};

const imagesMock = [
  'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80',
];

export const FullDetailPage = {
  render: (args) => ({
    components: { 
      CarDetailTemplate, 
      Header, 
      Footer, 
      CarGallery, 
      CarDetailsSidebar, 
      Heading, 
      Text 
    },
    setup() {
      return { carMock, imagesMock };
    },
    template: `
      <CarDetailTemplate>
        <template #header>
          <Header />
        </template>

        <template #navigation>
          <button class="text-blue-600 hover:text-blue-800 transition-colors font-medium flex items-center gap-2">
            ← Back to Search
          </button>
        </template>

        <template #visuals>
          <CarGallery :images="imagesMock" />
        </template>

        <template #details>
          <div class="space-y-4">
            <Heading :level="3" size="xl">Premium Features</Heading>
            <ul class="grid grid-cols-2 gap-4">
              <li class="flex items-center gap-2 text-gray-600">✓ Sport Exhaust</li>
              <li class="flex items-center gap-2 text-gray-600">✓ Carbon Seats</li>
              <li class="flex items-center gap-2 text-gray-600">✓ Track Pack</li>
              <li class="flex items-center gap-2 text-gray-600">✓ Bose Sound</li>
            </ul>
          </div>
        </template>

        <template #sidebar>
          <CarDetailsSidebar v-bind="carMock" />
        </template>

        <template #footer>
          <Footer />
        </template>
      </CarDetailTemplate>
    `,
  }),
};