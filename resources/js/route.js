import Vue from 'vue';
import VueRouter from 'vue-router';
import {routeDataList} from './constants';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  base: 'admin',
  routes: routeDataList,
});

export default router;
