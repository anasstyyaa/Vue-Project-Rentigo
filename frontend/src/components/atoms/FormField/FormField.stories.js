import FormField from './FormField.vue';

export default {
  title: 'Atoms/FormField',
  component: FormField,
  argTypes: {
    type: { control: { type: 'select' }, options: ['text', 'email', 'number', 'password'] },
  },
};

const Template = (args) => ({
  components: { FormField },
  setup() { return { args }; },
  template: '<FormField v-bind="args" v-model="args.modelValue" />',
});

export const Default = Template.bind({});
Default.args = {
  id: 'first-name',
  label: 'First Name',
  placeholder: 'Enter first name...',
  modelValue: '',
};

export const EmailField = Template.bind({});
EmailField.args = {
  id: 'email',
  label: 'Email Address',
  type: 'email',
  placeholder: 'user@rentigo.com',
  modelValue: '',
};