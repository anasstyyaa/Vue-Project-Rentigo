import AdminDashboardTemplate from './AdminDashboardTemplate.vue';

export default {
  title: 'Templates/AdminDashboardTemplate',
  component: AdminDashboardTemplate,
};

export const Default = () => ({
  components: { AdminDashboardTemplate },
  template: `
    <AdminDashboardTemplate>
      <template #header><div class="h-10 w-48 bg-gray-200 rounded"></div></template>
      <template #stats>
        <div v-for="i in 3" :key="i" class="h-32 bg-blue-100 rounded-2xl border-2 border-dashed border-blue-300"></div>
      </template>
      <template #content>
        <div class="h-96 bg-gray-100 rounded-2xl border-2 border-dashed border-gray-300"></div>
      </template>
    </AdminDashboardTemplate>
  `,
});