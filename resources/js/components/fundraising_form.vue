<template>
  <v-card>
    <v-toolbar
      flat
    >
      <v-toolbar-title>{{ item == null ? 'เพิ่ม' : 'แก้ไข' }}ข้อมูล</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-btn
        color="error"
        dark
        class="mb-2"
        @click="handleClickCancel"
      >
        <v-icon
          class="mr-1"
        >
          mdi-close-thick
        </v-icon>
        ยกเลิก
      </v-btn>
    </v-toolbar>

    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
      class="pl-5 pr-5 pb-5"
    >
      <v-text-field
        v-model="title"
        :counter="255"
        :rules="titleRules"
        label="ชื่อหัวข้อ"
        required
      ></v-text-field>

      <v-text-field
        v-model="description"
        :rules="descriptionRules"
        label="คำอธิบาย"
        required
      ></v-text-field>

      <v-select
        v-model="selectedCategory"
        :items="categoryList"
        :rules="[v => !!v || 'ต้องเลือกหมวดหมู่']"
        label="หมวดหมู่"
        required
      ></v-select>

      <v-btn
        :disabled="!valid"
        color="success"
        class="mt-4"
        @click="validate"
      >
        <v-icon
          class="mr-1"
        >
          mdi-content-save
        </v-icon>
        บันทึก
      </v-btn>

      <!--<v-btn
        color="error"
        class="mr-4"
        @click="reset"
      >
        Reset Form
      </v-btn>

      <v-btn
        color="warning"
        @click="resetValidation"
      >
        Reset Validation
      </v-btn>-->
    </v-form>
  </v-card>
</template>

<script>
export default {
  props: {
    item: Object,
    categoryList: Array,
    onCancelForm: Function,
  },
  data: () => ({
    valid: true,
    title: '',
    titleRules: [
      v => !!v || 'ต้องกรอกชื่อหัวข้อ',
      v => (v && v.length <= 255) || 'ชื่อหัวข้อต้องไม่เกิน 255 ตัวอักษร',
    ],
    description: '',
    descriptionRules: [
      v => !!v || 'ต้องกรอกคำอธิบาย',
      //v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
    ],
    selectedCategory: null,
    //fundraisingCategoryList: this.categoryList,
  }),
  created() {
    console.log('***** FundraisingForm created() *****');
    if (this.item != null) {
      this.title = this.item.title;
      this.description = this.item.description;
    }
  },
  methods: {
    handleClickCancel() {
      if (this.onCancelForm != null) {
        this.onCancelForm();
      }
    },

    validate() {
      if (this.$refs.form.validate()) {
        const msg = 'ข้อมูลที่จะส่งไปบันทึกลงฐานข้อมูล\n-----\n'
          + `Title: ${this.title}\n-----\n`
          + `Description: ${this.description}\n-----\n`
          + `Category: [${this.selectedCategory.id}] ${this.selectedCategory.title}\n-----`;
        alert(msg);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  }
}
</script>

<style scoped>
</style>
