import AdminTemplate from './AdminTemplate.vue';

export default {
  title: 'Templates/AdminTemplate',
  component: AdminTemplate,
  parameters: {
    layout: 'fullscreen',
  },
};

const Template = (args) => ({
  components: { AdminTemplate },
  setup() {
    return { args };
  },
  template: `
    <AdminTemplate>
      <template #sidebar-nav>
        <div class="space-y-2">
          <div class="bg-blue-600 text-white p-2 rounded">Dashboard</div>
          <div class="text-gray-400 p-2 hover:bg-slate-800 rounded cursor-pointer">Manage Cars</div>
          <div class="text-gray-400 p-2 hover:bg-slate-800 rounded cursor-pointer">Manage Users</div>
        </div>
      </template>

      <template #sidebar-footer>
        <div class="text-sm text-gray-500">v1.0.4-stable</div>
      </template>

      <template #header-left>
        <h1 class="text-xl font-bold text-gray-800">Page Title</h1>
      </template>

      <template #header-right>
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs">JD</div>
          <span class="text-sm font-medium">John Doe</span>
        </div>
      </template>

      <template #main-content>
        <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 flex items-center justify-center text-gray-400">
          Main Content Organism Goes Here
        </div>
      </template>
    </AdminTemplate>
  `,
});

export const Default = Template.bind({});
Default.args = {};