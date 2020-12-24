import MyProgressOverlay from "./components/my_progress_overlay";

require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import router from './route';
import {routeDataList} from './constants';
import CKEditor from '@ckeditor/ckeditor5-vue';
import colors from 'vuetify/lib/util/colors';
import MyDialog from './components/my_dialog';
//import CKEditor from 'ckeditor4-vue';

Vue.use(Vuetify);
Vue.use(CKEditor);

const LOGGED_IN_USER = 'logged_in_user';

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
  components: {
    MyDialog,
  },
  data: () => ({
    loggedInUser: null,
    loginFormVisible: true,
    tab: 0,
    loginFormValid: true,
    loginUser: '',
    loginUserRules: [
      v => !!v || 'ต้องกรอก username',
    ],
    loginPassword: '',
    loginPasswordRules: [
      v => !!v || 'ต้องกรอก password',
    ],
    dialog: {
      visible: false,
      title: '',
      message: '',
    },
    snackbar: {
      visible: false,
      message: '',
      iconName: null,
    },
    drawer: null,
    routeDataList,
    currentYear: new Date().toISOString().substr(0, 4),
  }),
  created() {
    console.log('created()');

    this.loggedInUser = null;
    const json = localStorage.getItem('azure_account');
    if (json != null) {
      this.loggedInUser = JSON.parse(json);
    } else {
      window.location.href = '/login';
    }
  },
  mounted() {
    console.log('mounted()');
  },
  methods: {
    handleClickHomeButton() {
      window.open('/');
    },
    handleClickLoginButton() {
      if (this.$refs.loginForm.validate()) {
        const msg = 'Form data\n-----\n'
          + `loginUser: ${this.loginUser}\n-----\n`
          + `loginPassword: ${this.loginPassword}\n-----\n`;
        //alert(msg);

        if (this.doAuthenticate()) {
          const loggedInUser = {
            id: 1,
            name: 'Administrator',
          };
          localStorage.setItem(LOGGED_IN_USER, JSON.stringify(loggedInUser));
          this.loggedInUser = loggedInUser;
        } else {
          this.showDialog(
            'Login failed',
            'Username หรือ Password ไม่ถูกต้อง',
            [{text: 'OK', onClick: null}],
            true
          );
        }
      } else {
        /*this.snackbar.message = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        this.snackbar.iconName = 'mdi-alert-circle';
        this.snackbar.visible = true;*/
        /*this.showDialog(
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          [{text: 'OK', onClick: null}],
          true
        );*/
      }
    },
    doAuthenticate() {
      return (this.loginUser === 'admin' && this.loginPassword === 'admin');
    },
    handleClickLogout() {
      this.showDialog(
        'Confirm logout',
        'ต้องการออกจากระบบใช่หรือไม่?',
        [
          {text: 'ไม่ใช่', onClick: null},
          {text: 'ใช่', onClick: this.doLogout}
        ],
        true,
      );
    },
    doLogout() {
      localStorage.removeItem(LOGGED_IN_USER);
      this.loggedInUser = null;
      //location.reload();
    },
    showDialog(title, message, buttonList, persistent) {
      this.dialog = {
        visible: true,
        persistent: persistent,
        title: title,
        message: message,
        buttonList: buttonList,
      };
    },
  }
});
