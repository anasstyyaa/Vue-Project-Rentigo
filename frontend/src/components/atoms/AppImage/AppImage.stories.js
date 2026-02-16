import AppImage from './AppImage.vue';

export default {
  title: 'Atoms/AppImage',
  component: AppImage,
  tags: ['autodocs'],
};

export const Standard = {
  args: {
    src: 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=800',
    alt: 'Black Porsche 911',
    aspect: 'video',
  },
};

export const Square = {
  args: {
    src: 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&q=80&w=800',
    alt: 'Red Ferrari',
    aspect: 'square',
  },
};

export const BrokenLink = {
  args: {
    src: 'https://not-a-real-website.com/car.jpg',
    alt: 'This will fail',
  },
};