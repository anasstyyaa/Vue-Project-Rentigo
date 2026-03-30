import ProfileSummary from './ProfileSummary.vue';
import Badge from '../../atoms/Badge/Badge.vue';

export default {
  title: 'Molecules/ProfileSummary',
  component: ProfileSummary,
};

export const Standard = {
  render: (args) => ({
    components: { ProfileSummary, Badge },
    setup() { return { args }; },
    template: `
      <ProfileSummary v-bind="args">
        <template #badge>
          <Badge variant="primary">Premium Member</Badge>
        </template>
      </ProfileSummary>
    `,
  }),
  args: {
    name: 'Bob Bobby',
    avatar: 'https://via.placeholder.com/150',
  },
};