import StatusBadge from './StatusBadge.vue';

export default {
  title: 'Atoms/StatusBadge',
  component: StatusBadge,
  argTypes: {
    type: {
      control: { type: 'select' },
      options: ['success', 'warning', 'danger', 'info'],
    },
  },
};

const Template = (args) => ({
  components: { StatusBadge },
  setup() {
    return { args };
  },
  template: '<StatusBadge v-bind="args">{{ args.label }}</StatusBadge>',
});

export const Active = Template.bind({});
Active.args = {
  type: 'success',
  label: 'Active',
};

export const Inactive = Template.bind({});
Inactive.args = {
  type: 'danger',
  label: 'Inactive',
};

export const Pending = Template.bind({});
Pending.args = {
  type: 'warning',
  label: 'Pending',
};

export const AllStates = () => ({
  components: { StatusBadge },
  template: `
    <div class="flex space-x-4">
      <StatusBadge type="success">Success</StatusBadge>
      <StatusBadge type="warning">Warning</StatusBadge>
      <StatusBadge type="danger">Danger</StatusBadge>
      <StatusBadge type="info">Info</StatusBadge>
    </div>
  `,
});