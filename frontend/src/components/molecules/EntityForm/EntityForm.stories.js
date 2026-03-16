import EntityForm from './EntityForm.vue';

export default {
  title: 'Molecules/EntityForm',
  component: EntityForm,
};

const Template = (args) => ({
  components: { EntityForm },
  setup() { return { args }; },
  template: '<EntityForm v-bind="args" @submit="args.onSubmit" @cancel="args.onCancel" />',
});

// user management 
export const UserSchema = Template.bind({});
UserSchema.args = {
  schema: [
    { key: 'firstName', label: 'First Name' },
    { key: 'lastName', label: 'Last Name' },
    { key: 'email', label: 'Email', type: 'email' },
  ],
  initialData: { firstName: '', lastName: '', email: '' },
  onSubmit: (data) => alert('Submitted User: ' + JSON.stringify(data)),
};

// car management
export const CarSchema = Template.bind({});
CarSchema.args = {
  schema: [
    { key: 'make', label: 'Car Make' },
    { key: 'model', label: 'Model' },
    { key: 'year', label: 'Year', type: 'number' },
  ],
  initialData: { make: 'Tesla', model: 'Model 3', year: 2024 },
  onSubmit: (data) => alert('Submitted Car: ' + JSON.stringify(data)),
};