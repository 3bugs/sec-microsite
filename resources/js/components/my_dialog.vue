<template>
  <v-dialog
    v-model="computedVisible"
    :persistent="persistent == null ? false : persistent"
    max-width="500"
  >
    <v-card>
      <v-card-title class="headline">{{ title }}</v-card-title>
      <v-card-text>{{ message }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          v-for="(button, index) in buttonList"
          :key="index"
          color="blue darken-1"
          text
          @click="() => {
            if (button.onClick != null) {
              button.onClick();
            }
            computedVisible = false;
          }"
        >
          {{ button.text }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    visible: Boolean,
    persistent: Boolean,
    title: String,
    message: String,
    buttonList: Array,
  },
  data: () => ({}),
  computed: {
    computedVisible: {
      get: function () {
        if (this.visible) {
          // Some dialog initialization code could be placed here
          // because it is called only when this.dialogVisible changes
        }
        return this.visible;
      },
      set: function (value) {
        if (!value) {
          this.$emit('close');
        }
      },
    },
  },
  created() {
  },
  methods: {
  }
}
</script>

<style scoped>
</style>
