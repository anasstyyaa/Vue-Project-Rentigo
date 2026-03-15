import UserTable from './UserTable.vue';

export default {
  title: 'Organisms/UserTable',
  component: UserTable,
};

const Template = (args) => ({
  components: { UserTable },
  setup() {
    return { args };
  },
  template: '<div class="p-6 bg-gray-100"><UserTable v-bind="args" /></div>',
});

export const Default = Template.bind({});
Default.args = {
  users: [
    { UserId: 2, FirstName: 'John', LastName: 'Doe', Email: 'john@example.com', IsActive: true },
    { UserId: 5, FirstName: 'Bob', LastName: 'Bobby', Email: 'bob@gmail.com', IsActive: true },
    { UserId: 11, FirstName: 'Mania', LastName: 'K', Email: 'mania@gmail.com', IsActive: false },
  ],
};

export const Empty = Template.bind({});
Empty.args = {
  users: [],
};