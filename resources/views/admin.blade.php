<!DOCTYPE html>
<html lang="th">
<head>
  <title>SEC Microsite - Back Office</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
    >
      <v-container>
        <v-row align="center" justify="center">
          <v-img
              lazy-src="/images/logo.svg"
              max-height="75"
              max-width="75"
              src="/images/logo.svg"
          >
          </v-img>
        </v-row>
      </v-container>

      <v-list>
        <v-list-item
            v-for="route in routeDataList"
            link :to="route.name"
        >
          <v-list-item-action>
            <v-icon>@{{ route.menuIconName }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>@{{ route.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
        app
        color="indigo"
        dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>SEC Microsite - Back Office</v-toolbar-title>
    </v-app-bar>

    <v-main :style="{background: '#eee'}">
      <v-container fluid class="pa-5">
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer
        color="indigo"
        app
    >
      <span class="white--text">&copy; 2020 สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์</span>
    </v-footer>
  </v-app>
</div>
<!-- Scripts -->
<script>

</script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
