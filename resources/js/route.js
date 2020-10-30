import Vue from 'vue';
import VueRouter from 'vue-router';
import {routeDataList} from './constants';

Vue.use(VueRouter);

const routes = [];
routeDataList.forEach(item => {
  if (item.subItemList == null) {
    routes.push(item);
  } else {
    item.subItemList.forEach(subItem => {
      routes.push(subItem);
    });
  }
});

const router = new VueRouter({
  mode: 'history',
  base: 'admin',
  routes: routes,
});

export default router;
