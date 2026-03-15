import UserTableRow from './UserTableRow.vue';

export default {
  title: 'Molecules/UserTableRow',
  component: UserTableRow,
};

const Template = (args) => ({
  components: { UserTableRow },
  setup() {
    return { args };
  },
  template: `
    <table class="min-w-full bg-white border">
      <tbody>
        <UserTableRow v-bind="args" @edit="onEdit" @delete="onDelete" />
      </tbody>
    </table>
  `,
  methods: {
    onEdit: (user) => console.log('Edit user:', user),
    onDelete: (id) => console.log('Delete ID:', id),
  }
});

export const ActiveUser = Template.bind({});
ActiveUser.args = {
  user: {
    UserId: 2,
    FirstName: 'John',
    LastName: 'Doe',
    Email: 'john@example.com',
    IsActive: true
  }
};

export const InactiveUser = Template.bind({});
InactiveUser.args = {
  user: {
    UserId: 5,
    FirstName: 'Bob',
    LastName: 'Bobby',
    Email: 'bob@gmail.com',
    IsActive: false
  }
};