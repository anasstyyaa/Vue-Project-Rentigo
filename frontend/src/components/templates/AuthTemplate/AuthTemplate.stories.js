import AuthTemplate from './AuthTemplate.vue';
import Header from '../../organisms/Header/Header.vue';
import Footer from '../../organisms/Footer/Footer.vue';
import RegisterForm from '../../organisms/RegisterForm/RegisterForm.vue';
import LoginForm from '../../organisms/LoginForm/LoginForm.vue';

export default {
  title: 'Templates/AuthTemplate',
  component: AuthTemplate,
  parameters: {
    layout: 'fullscreen', 
  },
};

export const RegistrationPage = {
  render: () => ({
    components: { AuthTemplate, Header, Footer, RegisterForm },
    template: `
      <AuthTemplate>
        <template #header>
          <Header />
        </template>

        <template #form>
          <RegisterForm />
        </template>

    `,
  }),
};

export const LoginPage = {
  render: () => ({
    components: { AuthTemplate, Header, Footer, LoginForm },
    template: `
      <AuthTemplate>
        <template #header>
          <Header />
        </template>

        <template #form>
          <LoginForm />
        </template>

    `,
  }),
};