import RegisterForm from './RegisterForm.vue';

export default {
  title: 'Organisms/RegisterForm',
  component: RegisterForm,
  tags: ['autodocs'],
  argTypes: {
    onRegister: { action: 'register-submitted' },
  },
};

export const Default = {
  args: {
    loading: false,
    error: '',
  },
};

export const LoadingState = {
  args: {
    loading: true,
    error: '',
  },
};

export const WithErrorMessage = {
  args: {
    loading: false,
    error: 'This email address is already in use.',
  },
};