require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import router from './route';
import {routeDataList} from './constants';
import CKEditor from '@ckeditor/ckeditor5-vue';
//import CKEditor from 'ckeditor4-vue';

Vue.use(Vuetify);
Vue.use(CKEditor);

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
