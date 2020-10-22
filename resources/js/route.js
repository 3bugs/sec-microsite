import Vue from 'vue';
import VueRouter from 'vue-router';

import Calendar from './pages/calendar';
import Dashboard from './pages/dashboard';
import Fundraising from './pages/fundraising';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  base: 'admin',
  routes: [
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
    },
    {
      path: '/fundraising',
      name: 'fundraising',
      component: Fundraising,
    },
  ],
});

export default router;
