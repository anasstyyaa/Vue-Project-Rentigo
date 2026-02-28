import Header from './Header.vue';

export default {
  title: 'Organisms/Header',
  component: Header,
  tags: ['autodocs'],
};

export const Default = {
  args: {
    navigationLinks: [
      { name: 'Home', href: '/api/cars' },
      { name: 'Profile', href: '/profile' },
    ],
  },
};

export const CustomNavigation = {
  args: {
    navigationLinks: [
      { name: 'Blog', href: '/blog' },
      { name: 'News', href: '/news' },
      { name: 'Resources', href: '/resources' },
    ],
  },
};
