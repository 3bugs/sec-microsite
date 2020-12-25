<!DOCTYPE html>
<html lang="th">
<head>
  <title>START TO GROW - Back Office</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- msal.min.js can be used in the place of msal.js; included msal.js to make debug easy -->
  <script type="text/javascript" src="https://alcdn.msauth.net/lib/1.4.4/js/msal.js" integrity="sha384-fTmwCjhRA6zShZq8Ow5ZkbWwmgp8En46qW6yWpNEkp37MkV50I/V2wjzlEkQ8eWD"
          crossorigin="anonymous"></script>

  <!-- msal.js with a fallback to backup CDN -->
  <script type="text/javascript">
    if (typeof Msal === 'undefined') document.write(unescape("%3Cscript src='https://alcdn.msftauth.net/lib/1.4.4/js/msal.js' type='text/javascript' %3E%3C/script%3E"));
  </script>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}?v=1" rel="stylesheet">

  <style>
    .v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child {
      margin-right: 18px !important;
    }

    .v-application--is-ltr .v-list-group--no-action > .v-list-group__items > .v-list-item {
      padding-left: 60px !important;
    }

    .v-list-group .v-list-group__header .v-list-item__icon.v-list-group__header__append-icon {
      min-width: 0 !important;
    }

    .v-btn {
      letter-spacing: 0;
    }

    .v-application--is-ltr .v-input--selection-controls__input {
      margin-right: auto;
      margin-left: auto;
    }
  </style>
</head>
<body>
<div id="app">
  <v-app>
    <v-btn
        fab dark large
        color="warning"
        fixed right bottom
        @click="handleClickHomeButton"
    >
      <v-icon dark>mdi-home</v-icon>
    </v-btn>
    <v-navigation-drawer
        v-if="loggedInUser != null"
        v-model="drawer"
        app
        dark
        src="/images/banner.jpg"
    >
      <v-container>
        <v-row align="center" justify="center">
          <v-img
              lazy-src="/images/logo_white.svg"
              max-height="60"
              max-width="60"
              src="/images/logo_white.svg"
          >
          </v-img>
        </v-row>
      </v-container>

      <v-list shaped>
        <template
            v-for="(item, index) in routeDataList"
        >
          <v-list-item
              :key="index"
              v-if="item.subItemList == null || item.subItemList.length === 0"
              link :to="item.name"
          >
            <v-list-item-action>
              <v-icon>@{{ item.menuIconName }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>@{{ item.menuTitle ? item.menuTitle : item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-group
              v-else
              :value="false"
              no-action
              color="white"
          >
            <template v-slot:activator>
              <v-list-item-action>
                <v-icon
                    v-text="item.menuIconName"
                ></v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>@{{ item.title }}</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
                v-for="(subItem, index) in item.subItemList"
                :key="index"
                link :to="subItem.name"
                dense
            >
              <v-list-item-title
                  v-text="subItem.menuTitle"
                  style="line-height: 2em"
              ></v-list-item-title>
            </v-list-item>
          </v-list-group>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
        app
        style="background: linear-gradient(91.95deg, #003558 14.65%, #005288 57.97%)"
        dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>SEC MICROSITE - Back Office</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-menu
          v-if="loggedInUser != null"
          :close-on-content-click="true"
          offset-y
      >
        <template v-slot:activator="{ on, attrs }">
          <v-button
              v-bind="attrs"
              v-on="on"
          >
            @{{ loggedInUser.name }}
            <v-icon dark large>
              mdi-account-circle
            </v-icon>
          </v-button>

        </template>

        <v-list dense>
          <v-list-item @click="handleClickLogout">
            <v-list-item-title>ออกจากระบบ</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <!--      <v-icon large v-if="loggedInUser != null">mdi-account</v-icon>-->
    </v-app-bar>

    <v-main :style="{background: '#eee'}">
      <v-container
          fluid
          v-if="loggedInUser != null"
          class="pt-1 pt-sm-2 pt-md-5 pl-1 pl-sm-2 pl-md-5 pr-1 pr-sm-2 pr-md-5 pb-16"
      >
        <router-view></router-view>
      </v-container>

      <v-container v-if="loggedInUser == null">
        <v-dialog
            v-model="loginFormVisible"
            persistent
            max-width="500px"
            min-width="360px"
        >
          <div>
            <v-tabs show-arrows icons-and-text dark grow>
              <v-tabs-slider color="purple darken-4"></v-tabs-slider>
              <v-tab style="background: linear-gradient(130deg, #003558 14.65%, #005288 57.97%)">
                <v-icon large>mdi-account</v-icon>
                <div class="caption py-1">Login</div>
              </v-tab>
              <v-tab-item>
                <v-card class="px-4">
                  <v-card-text>
                    <v-form ref="loginForm" v-model="loginFormValid" lazy-validation>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field
                              v-model="loginUser"
                              :rules="loginUserRules"
                              label="Username"
                              hint="กรอก username"
                              @keydown.enter="handleClickLoginButton"
                          ></v-text-field>
                          <v-text-field
                              v-model="loginPassword"
                              :rules="loginPasswordRules"
                              type="password"
                              name="password"
                              label="Password"
                              hint="กรอก password"
                              @keydown.enter="handleClickLoginButton"
                          ></v-text-field>
                        </v-col>
                        <v-col class="d-flex" cols="12" sm="6" xsm="12">
                        </v-col>
                        <v-spacer></v-spacer>
                        <v-col class="d-flex" cols="12" sm="3" xsm="12" align-end>
                          <v-btn
                              block
                              :disabled="!loginFormValid"
                              color="success"
                              @click="handleClickLoginButton"
                          >Login
                          </v-btn>
                        </v-col>
                      </v-row>
                    </v-form>
                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs>
          </div>
        </v-dialog>
      </v-container>
    </v-main>

    <v-footer
        app
        color="#003558"
    >
      <span class="white--text">&copy; @{{ currentYear }} สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์</span>
    </v-footer>

    <my-dialog
        :visible="dialog.visible"
        :persistent="dialog.persistent"
        @close="dialog.visible = false"
        :title="dialog.title"
        :message="dialog.message"
        :button-list="dialog.buttonList"
    />

    <v-snackbar
        v-model="snackbar.visible"
    >
      <v-icon
          v-if="snackbar.iconName != null"
          small color="success" class="mr-1"
      >
        @{{ snackbar.iconName }}
      </v-icon>
      @{{ snackbar.message }}
    </v-snackbar>
  </v-app>
</div>
<!-- Scripts -->
<script>
</script>
<script src="{{ mix('js/app.js') }}?v=3" defer></script>
</body>
</html>
