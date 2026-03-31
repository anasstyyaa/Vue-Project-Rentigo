import PriceBreakdown from './PriceBreakdown.vue';

export default {
  title: 'Molecules/PriceBreakdown',
  component: PriceBreakdown,
  argTypes: {
    dailyPrice: { control: 'number' },
    days: { control: 'number' },
  },
};

export const SingleDay = {
  args: {
    dailyPrice: 50,
    days: 1,
  },
};

export const MultiDay = {
  args: {
    dailyPrice: 99.99,
    days: 5,
  },
};

export const HighValue = {
  args: {
    dailyPrice: 500,
    days: 14,
  },
};