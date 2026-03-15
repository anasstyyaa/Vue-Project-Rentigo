import TableCell from './TableCell.vue';

export default {
  title: 'Atoms/Table/TableCell',
  component: TableCell,
  argTypes: {
    align: {
      control: { type: 'select' },
      options: ['left', 'center', 'right'],
    },
  },
};

const Template = (args) => ({
  components: { TableCell },
  setup() {
    return { args };
  },
  template: `
    <table class="min-w-full border">
      <tbody>
        <tr class="bg-white">
          <TableCell v-bind="args">
            {{ args.default }}
          </TableCell>
        </tr>
      </tbody>
    </table>
  `,
});

export const Default = Template.bind({});
Default.args = {
  default: 'Standard Text Data',
  primary: false,
  align: 'left',
};

export const Primary = Template.bind({});
Primary.args = {
  default: 'John Doe',
  primary: true,
  align: 'left',
};

export const RightAligned = Template.bind({});
RightAligned.args = {
  default: '$120.00',
  primary: false,
  align: 'right',
};

export const WithHtmlContent = (args) => ({
  components: { TableCell },
  setup() {
    return { args };
  },
  template: `
    <table class="min-w-full border">
      <tbody>
        <tr class="bg-white">
          <TableCell v-bind="args">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
              Active
            </span>
          </TableCell>
        </tr>
      </tbody>
    </table>
  `,
});