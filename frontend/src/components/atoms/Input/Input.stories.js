import MyInput from './Input.vue';

export default {
  title: 'Atoms/Input',
  component: MyInput,
};

export const DateInput = { args: { type: 'date', label: 'Pick-up Date' } };
export const TextInput = { args: { type: 'text', label: 'Promo Code', placeholder: 'Enter code...' } };