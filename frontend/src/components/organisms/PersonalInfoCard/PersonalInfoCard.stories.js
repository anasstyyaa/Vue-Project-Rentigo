import PersonalInfoCard from './PersonalInfoCard.vue';

export default {
  title: 'Organisms/PersonalInfoCard',
  component: PersonalInfoCard,
  args: {
    user: {
      username: 'johndoe_88',
      email: 'john@example.com',
      phoneNumber: '+1 (555) 000-1234',
      createdAt: '2024-01-15',
    }
  }
};

export const Default = {};

export const NoPhoneNumber = {
  args: {
    user: {
      username: 'secret_user',
      email: 'hidden@example.com',
      phoneNumber: '',
      createdAt: '2025-12-01',
    }
  }
};