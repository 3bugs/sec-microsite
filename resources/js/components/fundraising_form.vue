<template>
  <v-card :loading="false">
    <v-overlay
      :value="isSaving || isDeleting"
      z-index="9999"
    >
      <v-progress-circular
        indeterminate
        size="70"
      >
        <v-img
          lazy-src="/images/logo.svg"
          max-height="40"
          max-width="40"
          src="/images/logo.svg"
          class="mb-2"
        />
      </v-progress-circular>
    </v-overlay>
    <template
      v-slot:progress
    >
      <v-progress-linear
        color="primary"
        :height="5"
        indeterminate
      ></v-progress-linear>
    </template>

    <v-toolbar flat>
      <v-toolbar-title>{{ currentRouteTitle }} - {{ item == null ? 'เพิ่ม' : 'แก้ไข' }}ข้อมูล</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>
      <v-spacer/>
      <v-btn
        color="warning"
        class="mb-2"
        @click="handleClickCancel"
        :disabled="isSaving || isDeleting"
      >
        <v-icon
          small
          class="mr-2"
        >
          mdi-arrow-left
        </v-icon>
        ยกเลิก
      </v-btn>
    </v-toolbar>

    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
      class="pl-5 pr-5"
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

      <v-file-input
        label="รูปภาพ Cover"
        prepend-icon="mdi-camera"
        :rules="coverImageRules"
        required
        class="mt-2"
        @change="handleFileInputChanged"
      ></v-file-input>

      <v-container
        class="pl-0 pr-0"
        v-if="selectedImageSrc != null"
      >
        <v-img
          :lazy-src="selectedImageSrc"
          max-height="150"
          max-width="300"
          :src="selectedImageSrc"
          style="border: 1px solid #ccc"
        >
          <template v-slot:placeholder>
            <v-row
              class="fill-height ma-0"
              align="center"
              justify="center"
            >
              <v-progress-circular
                indeterminate
                color="grey lighten-5"
              ></v-progress-circular>
            </v-row>
          </template>
        </v-img>
        <!--<img :src="selectedImageSrc" style="object-fit: cover; width: 400px; height: 200px">-->
      </v-container>

      <v-container
        class="pl-0 pr-0 pt-6 pb-6"
      >
        <ckeditor
          :editor="editor"
          v-model="editorData"
          :config="editorConfig"
          :rules="descriptionRules"
        ></ckeditor>
      </v-container>

      <!--<image-uploader
        :debug="1"
        :maxWidth="512"
        :quality="0.7"
        :autoRotate=true
        outputFormat="verbose"
        :preview=false
        :className="['fileinput', { 'fileinput&#45;&#45;loaded' : hasImage }]"
        :capture="false"
        accept="video/*,image/*"
        doNotResize="['gif', 'svg']"
        @input="setImage"
        @onUpload="startImageResize"
        @onComplete="endImageResize"
      />-->

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
    <v-toolbar
      flat
      class="pb-5"
    >
      <v-btn
        :disabled="!valid || isSaving || isDeleting"
        color="success"
        @click="validate"
        :loading="isSaving"
      >
        <v-icon
          small
          class="mr-2"
        >
          mdi-content-save
        </v-icon>
        บันทึก
      </v-btn>
      <v-spacer/>
      <v-dialog
        v-if="item != null"
        v-model="confirmDeleteDialog"
        max-width="500"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="error"
            v-bind="attrs"
            v-on="on"
            :loading="isDeleting"
            :disabled="isSaving || isDeleting"
          >
            <v-icon
              small
              class="mr-2"
            >
              mdi-trash-can-outline
            </v-icon>
            ลบ
          </v-btn>
        </template>
        <v-card>
          <v-card-title class="headline">
            ต้องการลบข้อมูลนี้ใช่หรือไม่?
          </v-card-title>
          <v-card-text>ข้อมูลจะถูกลบออกจากฐานข้อมูล หลังจากคุณคลิก 'ลบ'</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="confirmDeleteDialog = false"
            >
              ยกเลิก
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="handleClickDelete"
            >
              ลบ
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>

    <my-dialog
      :visible="dialog.visible"
      :persistent="dialog.persistent"
      @close="dialog.visible = false"
      :title="dialog.title"
      :message="dialog.message"
      :button-list="dialog.buttonList"
    />
  </v-card>
</template>

<script>
import {routeDataList} from '../constants';
import MyDialog from '../components/my_dialog';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

//import ImageUploader from 'vue-image-upload-resize';

export default {
  components: {
    MyDialog,
    //ImageUploader,
  },
  props: {
    item: Object,
    categoryList: Array,
    onCancelForm: Function,
    onSave: Function,
    onDelete: Function,
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
    selectedFile: null,
    selectedImageSrc: null,
    confirmDeleteDialog: false,
    routeDataList,
    isSaving: false,
    isDeleting: false,
    dialog: {
      visible: false,
      title: '',
      message: '',
    },
    editor: ClassicEditor,
    editorData: '<p>Content of the editor</p>',
    editorConfig: {},
  }),
  computed: {
    currentRouteTitle() {
      const currentRouteName = this.$route.name;
      return this.routeDataList.filter(
        route => route.name === currentRouteName
      )[0].title;
    },

    coverImageRules() {
      return this.item == null ? [v => !!v || 'ต้องใส่รูปภาพ'] : [];
    },

    coverImage() {
      /*if (this.selectedFile != null) {
        const reader = new FileReader();
        reader.onload = function (e) {
          image.src = e.target.result;
        }
        // you have to declare the file loading
        reader.readAsDataURL(this.selectedFile);
      }*/
    },
  },
  created() {
    console.log('***** FundraisingForm created() *****');
    if (this.item != null) {
      this.title = this.item.title;
      this.description = this.item.description;
      this.selectedCategory = this.categoryList.filter(
        category => category.id === this.item.category_id
      )[0];
      this.selectedImageSrc = this.item.cover_image;
    }
  },
  methods: {
    showDialog(title, message, buttonList, persistent) {
      this.dialog = {
        visible: true,
        persistent: persistent,
        title: title,
        message: message,
        buttonList: buttonList,
      };
    },

    handleFileInputChanged(file) {
      this.selectedFile = file;
      this.getImageSrc();
    },

    getImageSrc() {
      const file = this.selectedFile;
      const self = this;

      if (file != null) {
        const reader = new FileReader();
        reader.onload = function (e) {
          self.selectedImageSrc = e.target.result;
        }
        reader.readAsDataURL(file);
      } else {
        this.selectedImageSrc = this.item == null ? null : this.item.cover_image;
      }
    },

    handleClickCancel() {
      if (this.onCancelForm != null) {
        this.onCancelForm();
      }
    },

    handleClickDelete() {
      this.doDeleting();
      this.confirmDeleteDialog = false;
    },
    doDeleting() {
      const self = this;

      this.isDeleting = true;
      axios.post('/api/fundraising', {
        id: this.item.id,
        _method: 'delete',
      })
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.showDialog('ลบข้อมูลสำเร็จ', 'ลบข้อมูลในฐานข้อมูลสำเร็จ', [{
              text: 'OK', onClick: () => {
                if (this.onDelete != null) {
                  this.onDelete();
                }
              },
            }], true);
          } else {
            this.showDialog('ผิดพลาด', `เกิดข้อผิดพลาด: ${message}`, [{
              text: 'OK', onClick: () => {
                //
              },
            }], true);
          }
        })
        .catch(function (error) {
          console.log(error);
          this.showDialog('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ Server กรุณาลองอีกครั้ง\n\n' + error, [{
            text: 'OK', onClick: () => {
              //
            },
          }], true);
        })
        .then(function () { // always executed
          self.isDeleting = false;
        });
    },

    validate() {
      if (this.$refs.form.validate()) {
        const msg = 'ข้อมูลที่จะส่งไปบันทึกลงฐานข้อมูล\n-----\n'
          + `Title: ${this.title}\n-----\n`
          + `Description: ${this.description}\n-----\n`
          + `Category: [${this.selectedCategory.id}] ${this.selectedCategory.title}\n-----`;
        //alert(msg);

        this.doSaving();
      }
    },
    doSaving() {
      const self = this;

      const formData = new FormData();
      formData.append('id', this.item == null ? 0 : this.item.id);
      formData.append('title', this.title);
      formData.append('description', this.description);
      formData.append('category_id', this.selectedCategory.id);
      formData.append('cover_image', this.selectedFile);
      if (this.item != null) {
        formData.append('_method', 'put');
      }
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      };

      this.isSaving = true;
      //axios.put ไม่ work!!!
      //const saveMethod = this.item == null ? axios.post : axios.put;
      axios.post('/api/fundraising', formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.showDialog('บันทึกข้อมูลสำเร็จ', 'บันทึกข้อมูลไปยังฐานข้อมูลสำเร็จ', [{
              text: 'OK', onClick: () => {
                if (this.onSave != null) {
                  this.onSave();
                }
              },
            }], true);
          } else {
            this.showDialog('ผิดพลาด', `เกิดข้อผิดพลาด: ${message}`, [{
              text: 'OK', onClick: () => {
                //
              },
            }], true);
          }
        })
        .catch(function (error) {
          console.log(error);
          this.showDialog('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ Server กรุณาลองอีกครั้ง\n\n' + error, [{
            text: 'OK', onClick: () => {
              //
            },
          }], true);
        })
        .then(function () { // always executed
          self.isSaving = false;
        });
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
