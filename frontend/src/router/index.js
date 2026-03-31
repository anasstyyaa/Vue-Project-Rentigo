import { createRouter, createWebHistory } from 'vue-router';
import CarArchivePage from '../components/pages/CarArchivePage/CarArchivePage.vue';
import CarDetailPage from '../components/pages/CarDetailPage/CarDetailPage.vue';
import RegisterPage from '../components/pages/RegisterPage/RegisterPage.vue';
import LoginPage from '../components/pages/LoginPage/LoginPage.vue';
import UserManagementPage from '../components/pages/UserManagementPage/UserManagementPage.vue';
import CarManagementPage from '../components/pages/CarManagementPage/CarManagementPage.vue';
import ProfilePage from '../components/pages/ProfilePage/ProfilePage.vue';
import BookingPage from '../components/pages/BookingPage/BookingPage.vue';

const routes = [
  { path: '/', component: CarArchivePage },
  { path: '/cars/:id', component: CarDetailPage, props: true},
  { path: '/register', component: RegisterPage },
  { path: '/booking', component: BookingPage},
  { path: '/admin/users', component: UserManagementPage },
  { path: '/admin/cars', component: CarManagementPage },
  { path: '/login', component: LoginPage },
  { path: '/profile', component: ProfilePage },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});