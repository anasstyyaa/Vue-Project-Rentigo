import Modal from './Modal.vue';

export default {
  title: 'Atoms/Modal',
  component: Modal,
};

export const Default = {
  render: (args) => ({
    components: { Modal },
    setup() { return { args }; },
    template: '<Modal v-bind="args">Modal Content Here</Modal>',
  }),
  args: { show: true },
};