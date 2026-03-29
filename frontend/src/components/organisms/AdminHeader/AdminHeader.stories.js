import AdminHeader from './AdminHeader.vue';
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: {} },
    { path: '/admin/dashboard', component: {} },
    { path: '/admin/users', component: {} },
    { path: '/admin/cars', component: {} },
  ],
});

export default {
  title: 'Organisms/AdminHeader',
  component: AdminHeader,
  decorators: [
    (story) => {
      const app = story();
      return {
        components: { app },
        setup() {
          const { app: storyApp } = app;
        },
        template: '<story />',
      };
    },
  ],
};

const Template = (args) => ({
  components: { AdminHeader },
  setup() {
    return { args };
  },
  template: `
    <AdminHeader v-bind="args">
      <div class="p-8 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 text-center text-gray-400">
        Main Content Slot Content
      </div>
    </AdminHeader>
  `,
});

export const Default = Template.bind({});
Default.args = {
  title: 'User Management',
};