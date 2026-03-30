import ProfileTemplate from './ProfileTemplate.vue';

export default {
  title: 'Templates/ProfileTemplate',
  component: ProfileTemplate,
  parameters: {
    layout: 'fullscreen',
  },
  render: (args) => ({
    components: { ProfileTemplate },
    setup() {
      return { args };
    },
    template: `
      <ProfileTemplate v-bind="args">
        <template #header>
          <div class="bg-blue-50 border-2 border-dashed border-blue-200 rounded-xl p-8 text-center text-blue-400 font-bold">
            Header Slot (ProfileSummary Molecule goes here)
          </div>
        </template>
        
        <template #sidebar>
          <div class="bg-purple-50 border-2 border-dashed border-purple-200 rounded-xl p-20 text-center text-purple-400 font-bold">
            Sidebar Slot (PersonalInfoCard Organism goes here)
          </div>
        </template>
        
        <template #content>
          <div class="bg-green-50 border-2 border-dashed border-green-200 rounded-xl p-40 text-center text-green-400 font-bold">
            Main Content Slot (BookingsTable Organism goes here)
          </div>
        </template>
      </ProfileTemplate>
    `,
  }),
};

export const Default = {
  args: {},
};


export const OnlyMainContent = {
  render: (args) => ({
    components: { ProfileTemplate },
    setup() { return { args }; },
    template: `
      <ProfileTemplate v-bind="args">
        <template #header>
          <div class="bg-gray-100 p-4 rounded text-center">Header Only</div>
        </template>
        <template #content>
          <div class="bg-gray-50 p-20 rounded text-center">Main content taking up full width if no sidebar slot used</div>
        </template>
      </ProfileTemplate>
    `,
  }),
};