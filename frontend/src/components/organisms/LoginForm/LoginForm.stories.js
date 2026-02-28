import LoginForm from './LoginForm.vue';

export default {
  title: 'Organisms/LoginForm',
  component: LoginForm,
  tags: ['autodocs'],
  argTypes: {
    onLogin: { action: 'login-attempt' },
    onToggleAuth: { action: 'switch-to-register' },
  },
};

export const Default = {
  args: {
    loading: false,
    error: '',
  },
};

export const Loading = {
  args: {
    loading: true,
    error: '',
  },
};

export const WithError = {
  args: {
    loading: false,
    error: 'Invalid email or password. Please try again.',
  },
};