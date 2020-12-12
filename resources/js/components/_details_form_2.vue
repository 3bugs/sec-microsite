<template>
  <v-card :loading="false">
    <my-progress-overlay :visible="isSaving || isDeleting" />

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
      <v-toolbar-title>
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              icon
              light
              v-bind="attrs"
              v-on="on"
              @click="handleClickCancel"
            >
              <v-icon color="grey darken-2">
                mdi-arrow-left
              </v-icon>
            </v-btn>
          </template>
          <span>ย้อนกลับ (ยกเลิกการ{{ item == null ? 'เพิ่มข้อมูล' : 'เปลี่ยนแปลงที่ยังไม่ได้บันทึก' }})</span>
        </v-tooltip>

        {{ currentRouteTitle }} - {{ item == null ? 'เพิ่ม' : 'แก้ไข' }}ข้อมูล
      </v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>
      <v-spacer/>

      <v-switch
        class="ma-0 pa-0"
        v-model="published"
        :true-value="1"
        :false-value="0"
        label="เผยแพร่"
        color="primary"
        hide-details
      />
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
        label="หัวข้อ/ชื่อเรื่อง"
        required
      ></v-text-field>

      <v-text-field
        v-model="url"
        :rules="urlRules"
        label="URL"
        required
      ></v-text-field>

      <v-file-input
        label="รูปภาพ, ให้ใช้ขนาด 1920x700 px"
        prepend-icon="mdi-camera"
        accept="image/*"
        :rules="imageRules"
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
    </v-form>

    <v-toolbar
      flat
      class="pb-5"
    >
      <v-btn
        class="mr-2"
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
            ลบข้อมูล
          </v-card-title>
          <v-card-text>ต้องการลบข้อมูลนี้ ใช่หรือไม่?</v-card-text>
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

    <v-snackbar
      v-model="snackbar.visible"
    >
      <v-icon
        v-if="snackbar.iconName != null"
        small color="success" class="mr-1"
      >
        {{ snackbar.iconName }}
      </v-icon>
      {{ snackbar.message }}
    </v-snackbar>

    <!--<div style="flex: 1; position: fixed; bottom: 20px; text-align: center; z-index: 9999; border: 1px solid red">
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
    </div>-->
  </v-card>
</template>

<script>
import {getRouteTitle, routeDataList} from '../constants';
import MyDialog from '../components/my_dialog';
import MyProgressOverlay from '../components/my_progress_overlay';
require('./th');
//import Thai from '@ckeditor/ckeditor5-build-classic/build/translations/th';
//import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment';

//import editor from '@ckeditor/ckeditor5-build-decoupled-document';
//import SimpleUploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter';
//import {ClassicEditor} from '../../ckeditor5/packages/ckeditor5-build-classic';

import MyUploadAdapter from "./my_upload_adapter";
import {getThaiDateText} from "../utils/utils";

export default {
  components: {
    MyDialog, MyProgressOverlay,
  },
  props: {
    tableName: String,
    item: Object,
    onCancelForm: Function,
    onSave: Function,
    onDelete: Function,
  },
  data() {
    return {
      valid: true,
      title: '',
      titleRules: [
        v => !!v || 'ต้องกรอกหัวข้อ/ชื่อเรื่อง',
        v => (v && v.length <= 255) || 'หัวข้อ/ชื่อเรื่อง ต้องไม่เกิน 255 ตัวอักษร',
      ],
      url: '',
      urlRules: [
        v => !!v || 'ต้องกรอก URL',
        //v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      selectedFile: null,
      selectedImageSrc: null,
      published: 1,
      confirmDeleteDialog: false,
      routeDataList,
      isSaving: false,
      isDeleting: false,
      dialog: {
        visible: false,
        title: '',
        message: '',
      },
      snackbar: {
        visible: false,
        message: '',
        iconName: null,
      },
      isUpdated: false, // มีการบันทึกข้อมูลลงฐานข้อมูลหรือยัง
    }
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
    },

    imageRules() {
      return this.item == null ? [v => !!v || 'ต้องใส่รูปภาพ'] : [];
    },

    selectedItemsText() {
      if (this.date.length === 0) return '-';
      return getThaiDateText(this.date, 2);
    },
  },
  created() {
    console.log('***** DetailsForm created() *****');
    if (this.item != null) {
      this.title = this.item.title;
      this.url = this.item.url;
      this.selectedImageSrc = this.item.image;
      this.published = this.item.published;
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
        this.selectedImageSrc = this.item == null ? null : this.item.image;
      }
    },

    handleClickCancel() {
      if (this.isUpdated) {
        this.onSave();
      } else {
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
      axios.post(`/api/${this.tableName}`, {
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
          + `URL: ${this.url}\n-----\n`;
        //alert(msg);

        this.doSaving();
      } else {
        this.showDialog(
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          [{text: 'OK', onClick: null}],
          true
        );
      }
    },
    doSaving() {
      const self = this;

      const formData = new FormData();
      formData.append('id', this.item == null ? 0 : this.item.id);
      formData.append('title', this.title.trim());
      formData.append('url', this.url.trim());
      formData.append('image', this.selectedFile);
      formData.append('published', this.published);

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
      axios.post(`/api/${this.tableName}`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.isUpdated = true;

            if (this.item == null) {
              this.showDialog('บันทึกข้อมูลสำเร็จ', 'บันทึกข้อมูลไปยังฐานข้อมูลสำเร็จ', [{
                text: 'OK', onClick: () => {
                  if (this.onSave != null) {
                    this.onSave();
                  }
                },
              }], true);
            } else {
              this.snackbar.message = 'บันทึกข้อมูลสำเร็จ';
              this.snackbar.iconName = 'mdi-check-bold';
              this.snackbar.visible = true;
            }
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

<style>
.v-input .v-label {
  height: 30px;
  line-height: 35px;
}

.v-text-field .v-label {
   top: 0;
}

.v-date-picker-title__date {
  font-size: 28px;
}

.ck-editor__editable {
  min-height: 0;
}

.ck-content p, .ck-content li {
  color: #666;
}

.ck-content ol li {
  margin-bottom: 0.8em;
  margin-left: 2em;
}

.ck-content ul li {
  margin-bottom: 0.8em;
  margin-left: 3em;
}

.ck-content ul li:last-child {
  margin-bottom: 2em;
}

.ck-content ol li:last-child {
  margin-bottom: 2em;
}

.ck-content h2 {
  color: #10375C;
  font-weight: normal;
  margin-top: 1.8em;
  margin-bottom: 0.75em;
}

.ck-content h3 {
  color: #10375C;
  font-weight: normal;
  margin-top: 1.8em;
  margin-bottom: 0.75em;
}

.ck-content h4 {
  color: #222831;
  font-weight: normal;
  margin-top: 1.5em;
  margin-bottom: 0.5em;
}

.ck-content img {
  margin: 1rem 0;
  border: 1px solid #e0e0e0;
}
</style>
