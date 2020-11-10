<template>
  <v-overlay
    :value="visible"
    z-index="9999"
  >
    <v-progress-circular
      indeterminate
      size="70"
    >
      <img
        lazy-src="/images/logo.svg"
        style="width: 40px; height: 40px"
        src="/images/logo.svg"
        class="mb-2"
      />
    </v-progress-circular>
  </v-overlay>
</template>

<script>
export default {
  components: {},
  props: {
    visible: Boolean,
  },
  data() {
    return {};
  },
  computed: {
    computedTest() {
    },
  },
  created() {
  },
  methods: {
    test() {
    },
  }
}
</script>

<style scoped>
</style>
