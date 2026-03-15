import TableHead from './TableHead.vue';

export default {
  title: 'Atoms/Table/TableHead',
  component: TableHead,
  argTypes: {
    sortDirection: {
      control: { type: 'select' },
      options: [null, 'asc', 'desc'],
    },
    onClick: { action: 'sort' },
  },
};

const Template = (args) => ({
  components: { TableHead },
  setup() {
    return { args };
  },
  template: `
    <table class="min-w-full">
      <thead>
        <tr>
          <TableHead v-bind="args" @sort="args.onClick">
            {{ args.label }}
          </TableHead>
        </tr>
      </thead>
    </table>
  `,
});

export const Default = Template.bind({});
Default.args = {
  label: 'Username',
  sortable: false,
};

export const Sortable = Template.bind({});
Sortable.args = {
  label: 'Email',
  sortable: true,
  sortDirection: null,
};

export const Ascending = Template.bind({});
Ascending.args = {
  label: 'First Name',
  sortable: true,
  sortDirection: 'asc',
};

export const Descending = Template.bind({});
Descending.args = {
  label: 'Last Name',
  sortable: true,
  sortDirection: 'desc',
};