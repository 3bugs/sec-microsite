<template>
  <v-container fill-height fluid>
    <v-row
      align="center"
      justify="center"
    >
      <v-col class="text-center">
        <img
          src="/images/under_construction.png"
          width="300px"
          height="300px"
        ><br>
        <img
          src="/images/logo.svg"
          width="120px"
          height="120px"
        >
        <!--<v-tooltip left>
          <template v-slot:activator="{ on }">
            <v-btn
              :href="source"
              icon
              large
              target="_blank"
              v-on="on"
            >
              <v-icon large>mdi-code-tags</v-icon>
            </v-btn>
          </template>
          <span>Source</span>
        </v-tooltip>

        <v-tooltip right>
          <template v-slot:activator="{ on }">
            <v-btn
              icon
              large
              href="https://codepen.io/johnjleider/pen/zgxeLQ"
              target="_blank"
              v-on="on"
            >
              <v-icon large>mdi-codepen</v-icon>
            </v-btn>
          </template>
          <span>Codepen</span>
        </v-tooltip>-->
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  props: {
    source: String,
  },
}
</script>
