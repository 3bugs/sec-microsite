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

      <v-list nav>
        <v-list-item
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
      <v-container fluid class="pt-1 pt-sm-2 pt-md-5 pl-1 pl-sm-2 pl-md-5 pr-1 pr-sm-2 pr-md-5 pb-16">
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
  function handleClickHomeButton() {
    alert('ok');
  }
</script>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
