import IconButton from './IconButton.vue';

export default {
  title: 'Atoms/IconButton',
  component: IconButton,
  argTypes: {
    variant: {
      control: { type: 'select' },
      options: ['primary', 'danger', 'neutral'],
    },
  },
};

const Template = (args) => ({
  components: { IconButton },
  setup() {
    return { args };
  },
  template: `
    <IconButton v-bind="args">
      <svg v-if="args.icon === 'edit'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
      <svg v-else-if="args.icon === 'delete'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
    </IconButton>
  `,
});

export const Edit = Template.bind({});
Edit.args = {
  variant: 'primary',
  label: 'Edit User',
  icon: 'edit',
};

export const Delete = Template.bind({});
Delete.args = {
  variant: 'danger',
  label: 'Delete User',
  icon: 'delete',
};