import { createRouter, createWebHistory } from 'vue-router';
import CarArchivePage from '../components/pages/CarArchivePage/CarArchivePage.vue';
import RegisterPage from '../components/pages/RegisterPage/RegisterPage.vue';

const routes = [
  { path: '/', component: CarArchivePage },
  { path: '/register', component: RegisterPage },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});