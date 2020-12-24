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

// Config object to be passed to Msal on creation.
// For a full list of msal.js configuration parameters,
// visit https://azuread.github.io/microsoft-authentication-library-for-js/docs/msal/modules/_authenticationparameters_.html
const msalConfig = {
  auth: {
    clientId: '2035ec54-9f6b-4228-8ea1-99c4f2201357', //"Enter_the_Application_Id_Here"
    authority: "https://login.microsoftonline.com/0ad5298e-296d-45ab-a446-c0d364c5b18b", //"Enter_the_Cloud_Instance_Id_Here/Enter_the_Tenant_Info_Here"
    redirectUri: "https://ssw003asv801.azurewebsites.net/login", //"Enter_the_Redirect_Uri_Here"
  },
  cache: {
    cacheLocation: "sessionStorage", // This configures where your cache will be stored
    storeAuthStateInCookie: false, // Set this to "true" if you are having issues on IE11 or Edge
  }
};

// Add here the scopes to request when obtaining an access token for MS Graph API
// for more, visit https://github.com/AzureAD/microsoft-authentication-library-for-js/blob/dev/lib/msal-core/docs/scopes.md
const loginRequest = {
  //scopes: ["openid", "profile", "User.Read"]
  scopes: []
};

// Create the main myMSALObj instance
// configuration parameters are located at authConfig.js
const myMSALObj = new Msal.UserAgentApplication(msalConfig);

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
      //window.location.href = '/login';
      this.signIn();
    }
  },
  mounted() {
    console.log('mounted()');
  },
  methods: {
    /*
  Account's Properties
  - accountIdentifier
  - environment
  - homeAccountIdentifier
  - idToken
  - idTokenClaims
  - name
  - sid
  - userName
  */
    signIn() {
      myMSALObj.loginPopup(loginRequest)
        .then(loginResponse => {
          console.log("id_token acquired at: " + new Date().toString());
          console.log(loginResponse);

          const account = myMSALObj.getAccount();
          if (account) {
            localStorage.setItem('azure_account', JSON.stringify(account));
            setTimeout(() => {
              window.location.href = '/admin';
            }, 500);
          }
        }).catch(error => {
        console.log(error);
      });
    },
    signOut() {
      myMSALObj.logout();
    },
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
      this.signOut();

      /*this.showDialog(
        'Confirm logout',
        'ต้องการออกจากระบบใช่หรือไม่?',
        [
          {text: 'ไม่ใช่', onClick: null},
          {text: 'ใช่', onClick: this.doLogout}
        ],
        true,
      );*/
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
