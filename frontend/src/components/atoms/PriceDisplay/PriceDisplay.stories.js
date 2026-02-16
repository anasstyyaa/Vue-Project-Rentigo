import PriceDisplay from './PriceDisplay.vue';

export default {
  title: 'Atoms/PriceDisplay',
  component: PriceDisplay,
  argTypes: {
    amount: { control: 'number' },
    currency: { 
      control: 'select', 
      options: ['USD', 'EUR', 'GBP'] 
    },
    showPeriod: { control: 'boolean' }
  },
};

export const Standard = {
  args: {
    amount: 120.00,
    currency: 'USD',
    showPeriod: true,
  },
};

export const Luxury = {
  args: {
    amount: 350.50,
    currency: 'USD',
    showPeriod: true,
  },
};

export const Euro = {
  args: {
    amount: 85,
    currency: 'EUR',
    locale: 'de-DE'
  },
};