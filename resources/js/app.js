require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import router from './route';

Vue.use(Vuetify);

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  router,
  data: () => ({
    drawer: null,
  }),
});
