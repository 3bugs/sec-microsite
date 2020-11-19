<template>
  <category-list-form
    table-name="event"
    :allow-add="false"
    :allow-delete="false"
    :show-publish="false"
  />
</template>

<script>
import CategoryListForm from './_category_list_form';

export default {
  components: {
    CategoryListForm,
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
