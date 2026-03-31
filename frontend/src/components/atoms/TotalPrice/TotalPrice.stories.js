import TotalPrice from './TotalPrice.vue';

export default {
  title: 'Atoms/TotalPrice',
  component: TotalPrice,
};

export const Large = {
  args: {
    amount: 1250.50,
    label: 'Grand Total',
    size: 'lg'
  },
};

export const Medium = {
  args: {
    amount: 45.00,
    label: 'Subtotal',
    size: 'md'
  },
};

export const LargeAmount = {
  args: {
    amount: 15400.99,
    label: 'Total Investment',
    size: 'lg'
  },
};