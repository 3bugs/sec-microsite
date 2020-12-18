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
      <!--<v-btn
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
      </v-btn>-->

      <v-switch
        class="ma-0 pa-0"
        v-model="published"
        :true-value="1"
        :false-value="0"
        label="เผยแพร่"
        color="primary"
        hide-details
        inset
      />
    </v-toolbar>

    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
      class="pl-5 pr-5"
    >
      <v-container class="pa-0 ma-0" v-if="withDate">
        <v-row>
          <v-col class="pb-0 mb-0" cols="12" md="6">
            <v-dialog
              ref="datePickerDialog"
              v-model="datePickerModal"
              :return-value.sync="date"
              persistent
              width="300px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="dateRangeText"
                  :rules="dateRules"
                  label="วันที่จัดอีเวนต์"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  required
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="date"
                range
                scrollable
                locale="th-TH"
                :selected-items-text="selectedItemsText"
                @change="handleChangeDate"
              >
                <v-spacer></v-spacer>
                <v-btn
                  text
                  color="primary"
                  @click="datePickerModal = false"
                >
                  ยกเลิก
                </v-btn>
                <v-btn
                  text
                  color="primary"
                  @click="$refs.datePickerDialog.save(date)"
                >
                  ตกลง
                </v-btn>
              </v-date-picker>
            </v-dialog>
          </v-col>
          <v-col class="pb-0 mb-0" cols="12" md="3">
            <v-dialog
              ref="beginTimePickerDialog"
              v-model="beginTimePickerModal"
              :return-value.sync="beginTime"
              persistent
              width="300px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="beginTime"
                  :rules="timeRules"
                  label="ตั้งแต่เวลา"
                  prepend-icon="mdi-clock-time-four-outline"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  required
                ></v-text-field>
              </template>
              <v-time-picker
                v-model="beginTime"
                format="24hr"
                full-width
              >
                <v-spacer></v-spacer>
                <v-btn
                  text
                  color="primary"
                  @click="beginTimePickerModal = false"
                >
                  ยกเลิก
                </v-btn>
                <v-btn
                  text
                  color="primary"
                  @click="$refs.beginTimePickerDialog.save(beginTime)"
                >
                  ตกลง
                </v-btn>
              </v-time-picker>
            </v-dialog>
          </v-col>
          <v-col class="pb-0 mb-0" cols="12" md="3">
            <v-dialog
              ref="endTimePickerDialog"
              v-model="endTimePickerModal"
              :return-value.sync="endTime"
              persistent
              width="300px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="endTime"
                  :rules="timeRules"
                  label="ถึงเวลา"
                  prepend-icon="mdi-clock-time-four-outline"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  required
                ></v-text-field>
              </template>
              <v-time-picker
                v-model="endTime"
                format="24hr"
                full-width
              >
                <v-spacer></v-spacer>
                <v-btn
                  text
                  color="primary"
                  @click="endTimePickerModal = false"
                >
                  ยกเลิก
                </v-btn>
                <v-btn
                  text
                  color="primary"
                  @click="$refs.endTimePickerDialog.save(endTime)"
                >
                  ตกลง
                </v-btn>
              </v-time-picker>
            </v-dialog>
          </v-col>
        </v-row>
      </v-container>

      <v-text-field
        v-model="title"
        :counter="255"
        :rules="titleRules"
        label="หัวข้อ/ชื่อเรื่อง"
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
        accept="image/*"
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

      <!--Content Editor-->
      <v-container
        class="pl-0 pr-0 pt-6 pb-6"
      >
        <!--<div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
          <ckeditor
            :editor="editor"
            v-model="editorContent"
            :config="editorConfig"
            @ready="handleEditorReady"
          ></ckeditor>
        </div>-->
        <ckeditor
          :editor="editor"
          v-model="editorContent"
          :config="editorConfig"
          @ready="handleEditorReady"
        ></ckeditor>

        <div
          v-if="contentRuleVisible && editorContent.trim().length === 0"
          class="mt-1"
          style="color: #ff5252; font-size: 12px"
        >ต้องกรอกเนื้อหา
        </div>
      </v-container>

      <v-switch
        v-if="showPinned"
        v-model="pinned"
        :true-value="1"
        :false-value="0"
        label="ปักหมุด/ไฮไลท์"
        color="primary"
        hide-details
        inset
        style="margin-bottom: 10px"
      />

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
      <v-btn
        v-if="item != null"
        class="mr-2"
        color="primary"
        @click="handleClickViewWeb(item)"
      >
        <v-icon
          small
          class="mr-2"
        >
          mdi-web
        </v-icon>
        ดูหน้าเว็บ
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
import editor from '@ckeditor/ckeditor5-build-classic';
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
    categoryList: Array,
    onCancelForm: Function,
    onSave: Function,
    onDelete: Function,
    withDate: Boolean,
    showPinned: Boolean,
  },
  data() {
    return {
      valid: true,
      title: '',
      titleRules: [
        v => !!v || 'ต้องกรอกหัวข้อ/ชื่อเรื่อง',
        v => (v && v.length <= 255) || 'หัวข้อ/ชื่อเรื่อง ต้องไม่เกิน 255 ตัวอักษร',
      ],
      description: '',
      descriptionRules: [
        v => !!v || 'ต้องกรอกคำอธิบาย',
        //v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      selectedCategory: null,
      selectedFile: null,
      selectedImageSrc: null,
      published: 1,
      pinned: 0,
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
      editor,
      editorContent: '',
      editorConfig: {
        extraPlugins: [(editor) => this.uploader(editor, this.tableName)],
        language: 'th',
        /*alignment: {
          options: [ 'left', 'center', 'right' ]
        },
        toolbar: ['heading', '|', 'bold', 'italic', 'alignment', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'imageUpload', 'mediaEmbed', '|', 'undo', 'redo'],
        table: {
          toolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },*/
      },
      contentRuleVisible: false,
      isUpdated: false, // มีการบันทึกข้อมูลลงฐานข้อมูลหรือยัง

      date: [], //new Date().toISOString().substr(0, 10),
      datePickerModal: false,
      dateRules: [
        v => !!v || 'ต้องระบุวันที่จัดอีเวนต์',
      ],

      beginTime: '',
      endTime: '',
      beginTimePickerModal: false,
      endTimePickerModal: false,
      timeRules: [
        v => !!v || 'ต้องระบุเวลา',
      ],
    }
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
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

    dateRangeText () {
      if (this.date.length === 0) {
        return '';
      }
      else if (this.date.length === 1) {
        return getThaiDateText([this.date[0], this.date[0]]);
      } else {
        return getThaiDateText([this.date[0], this.date[1]]);
        /*return this.date[0] === this.date[1]
          ? getThaiDateText(this.date[0])
          : `${getThaiDateText(this.date[0])} - ${getThaiDateText(this.date[1])}`;*/
      }
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
      this.description = this.item.description;
      this.selectedCategory = this.categoryList.filter(
        category => category.id === this.item.category_id
      )[0];
      this.selectedImageSrc = this.item.cover_image;
      this.editorContent = this.item.content;
      this.published = this.item.published;
      this.pinned = this.item.pinned;

      if (this.item.begin_date != null) {
        this.date = this.item.begin_date === this.item.end_date
          ? [this.item.begin_date]
          : [this.item.begin_date, this.item.end_date];
      }
      if (this.item.begin_time != null) {
        this.beginTime = this.item.begin_time.substring(0, 5);
      }
      if (this.item.end_time != null) {
        this.endTime = this.item.end_time.substring(0, 5);
      }
    }
  },
  methods: {
    handleClickViewWeb(item) {
      window.open(`/${this.tableName}/${item.id}`);
    },

    handleChangeDate() {
      if (this.date.length === 2) {
        if (this.date[0] >= this.date[1]) {
          this.date = [this.date[1]];
          //return;
        }
      }
      //this.date.sort();
    },

    handleEditorReady() {
      console.log('EDITOR READY!');
      /*const toolbarContainer = document.querySelector('.document-editor__toolbar');
      toolbarContainer.appendChild(this.editor.ui.view.toolbar.element);*/
    },

    uploader(editor, tableName) {
      editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader, tableName);
      };
    },

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
      this.contentRuleVisible = (this.editorContent == null || this.editorContent.trim().length === 0)

      if (this.$refs.form.validate()) {
        const msg = 'ข้อมูลที่จะส่งไปบันทึกลงฐานข้อมูล\n-----\n'
          + `Title: ${this.title}\n-----\n`
          + `Description: ${this.description}\n-----\n`
          + `Category: [${this.selectedCategory.id}] ${this.selectedCategory.title}\n-----`;
        //alert(msg);

        if (this.editorContent == null || this.editorContent.trim().length === 0) {
          this.showDialog(
            'กรุณากรอกข้อมูลให้ครบถ้วน',
            'คุณยังไม่ได้กรอกเนื้อหาบทความ',
            [{text: 'OK', onClick: null}],
            true
          );
        } else {
          this.doSaving();
        }
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
      formData.append('description', this.description.trim());
      formData.append('category_id', this.selectedCategory.id);
      formData.append('cover_image', this.selectedFile);
      formData.append('content_data', this.editorContent.trim());
      formData.append('published', this.published);
      formData.append('pinned', this.pinned);
      if (this.withDate) {
        formData.append('begin_date', this.date[0]);
        formData.append('end_date', this.date.length > 1 ? this.date[1] : this.date[0]);
        formData.append('begin_time', this.beginTime);
        formData.append('end_time', this.endTime);
      }
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
