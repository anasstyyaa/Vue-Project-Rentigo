import { createRouter, createWebHistory } from 'vue-router';
import CarArchivePage from '../components/pages/CarArchivePage/CarArchivePage.vue';
import RegisterPage from '../components/pages/RegisterPage/RegisterPage.vue';
import LoginPage from '../components/pages/LoginPage/LoginPage.vue';

const routes = [
  { path: '/', component: CarArchivePage },
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage }
];

export default createRouter({
  history: createWebHistory(),
  routes,
});