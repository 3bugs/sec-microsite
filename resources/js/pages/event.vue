<template>
  <list-form
    table-name="event"
    :with-date="true"
    :show-pinned="true"
  />
</template>

<script>
import ListForm from './_list_form';

export default {
  components: {
    ListForm,
  },
  data() {
    return {};
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
