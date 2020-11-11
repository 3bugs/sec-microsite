<!DOCTYPE html>
<html lang="th">
<head>
  <title>SEC Microsite - Back Office</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <style>
    .v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child {
      margin-right: 18px !important;
    }
    .v-application--is-ltr .v-list-group--no-action>.v-list-group__items>.v-list-item {
      padding-left: 60px !important;
    }
    .v-list-group .v-list-group__header .v-list-item__icon.v-list-group__header__append-icon {
      min-width: 0 !important;
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
              <v-list-item-title>@{{ item.title }}</v-list-item-title>
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
              {{--<v-list-item-icon>
                <v-icon
                    v-text="subItem.menuIconName"
                    small
                ></v-icon>
              </v-list-item-icon>--}}
            </v-list-item>
          </v-list-group>
        </template>



        {{--<v-list-item
            v-for="(route, index) in routeDataList"
            :key="index"
            link :to="route.name"
        >
          <v-list-item-action>
            <v-icon>@{{ route.menuIconName }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>@{{ route.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-group
            :value="true"
            no-action
            color="yellow"
        >
          <template v-slot:activator>
            <v-list-item-action>
              <v-icon v-text="'mdi-update'"></v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Admin</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item
              v-for="(item, index) in ['aaa', 'bbb', 'ccc']"
              :key="index"
              link
          >
            <v-list-item-title v-text="item"></v-list-item-title>
            <v-list-item-icon>
              <v-icon v-text="'mdi-update'"></v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>--}}
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
        app
        style="background: linear-gradient(91.95deg, #003558 14.65%, #005288 57.97%)"
        dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>SEC MICROSITE - Back Office</v-toolbar-title>
    </v-app-bar>

    <v-main :style="{background: '#eee'}">
      <v-container fluid class="pt-1 pt-sm-2 pt-md-5 pl-1 pl-sm-2 pl-md-5 pr-1 pr-sm-2 pr-md-5 pb-16">
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer
        app
        color="#003558"
    >
      <span class="white--text">&copy; @{{ currentYear }} สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์</span>
    </v-footer>
  </v-app>
</div>
<!-- Scripts -->
<script>
</script>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
