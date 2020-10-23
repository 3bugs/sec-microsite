require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import router from './route';
import {routeDataList} from './constants';

Vue.use(Vuetify);

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  router,
  data: () => ({
    drawer: null,
    routeDataList,
  }),
  created() {
    console.log('created()');
  },
  mounted() {
    console.log('mounted()');
  },
  methods: {
    handleClickHomeButton() {
      window.open('/');
    },
  }
});
