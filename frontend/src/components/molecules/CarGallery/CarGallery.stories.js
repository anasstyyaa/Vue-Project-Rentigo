import CarGallery from './CarGallery.vue';

export default {
  title: 'Molecules/CarGallery',
  component: CarGallery,
  tags: ['autodocs'],
  argTypes: {
    images: {
      control: 'object',
      description: 'Array of image URLs (max 4 displayed in grid)',
    },
  },
};


export const FullGallery = {
  args: {
    images: [
      'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1525609004556-c46c7d6cf048?auto=format&fit=crop&w=800&q=80',
    ],
  },
};


export const PartialGallery = {
  args: {
    images: [
      'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80',
    ],
  },
};


export const SingleImage = {
  args: {
    images: [
      'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800&q=80',
    ],
  },
};