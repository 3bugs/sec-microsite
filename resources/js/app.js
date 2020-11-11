require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import router from './route';
import {routeDataList} from './constants';
import CKEditor from '@ckeditor/ckeditor5-vue';
import colors from 'vuetify/lib/util/colors'
//import CKEditor from 'ckeditor4-vue';

Vue.use(Vuetify);
Vue.use(CKEditor);

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify({
    theme: {
      themes: {
        light: {
          primary: '#005288',
          secondary: colors.red.lighten4, // #FFCDD2
          accent: colors.indigo.base, // #3F51B5
        },
      },
    },
  }),
  router,
  data: () => ({
    drawer: null,
    routeDataList,
    currentYear: new Date().toISOString().substr(0, 4),
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
