<template>
  <v-container>
    <v-card :loading="isFetching">
      <my-progress-overlay :visible="isSaving"/>

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
        <v-toolbar-title>ก.ล.ต. กับ SMEs</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer/>
      </v-toolbar>

      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        class="pl-5 pr-5"
      >
        <!--Content Editor-->
        <v-container
          class="pl-0 pr-0 pt-6 pb-6"
        >
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
      </v-form>

      <v-toolbar
        flat
        class="pb-5"
      >
        <v-btn
          :disabled="!valid || isSaving || isFetching"
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
    </v-card>
  </v-container>
</template>

<script>
import {getRouteTitle, routeDataList} from '../constants';
import MyDialog from '../components/my_dialog';
import MyProgressOverlay from '../components/my_progress_overlay';
import editor from '@ckeditor/ckeditor5-build-classic';

require('../components/th');

import MyUploadAdapter from "../components/my_upload_adapter";
import {getThaiDateText} from "../utils/utils";

export default {
  components: {
    MyDialog, MyProgressOverlay,
  },
  props: {},
  data() {
    return {
      isFetching: false,
      valid: true,
      routeDataList,
      isSaving: false,
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
        extraPlugins: [(editor) => this.uploader(editor, 'vision')],
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
    }
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
    },

    selectedItemsText() {
      if (this.date.length === 0) return '-';
      return getThaiDateText(this.date, 2);
    },
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.isFetching = true;

      const url = `/api/vision?t=${Date.now()}`;
      axios.get(url, {
        params: {}
      })
        .then((response) => {
          console.log(response.data);
          if (response.data.status === 'ok') {
            const item = response.data.data;
            if (item != null) {
              this.editorContent = item.content;
            }
          } else {
            const errorMessage = response.data.message;
            this.showDialog(
              'ผิดพลาด',
              errorMessage,
              [
                {text: 'OK', onClick: null}
              ],
              true,
            );
          }
        })
        .catch((error) => {
          console.log(error);
          this.showDialog(
            'ผิดพลาด',
            'เกิดข้อผิดพลาดในการเชื่อมต่อ Server กรุณาลองอีกครั้ง',
            [
              {text: 'OK', onClick: null}
            ],
            true,
          );
        })
        .then(() => { // always executed
          this.isFetching = false;
        });
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

    validate() {
      this.contentRuleVisible = (this.editorContent == null || this.editorContent.trim().length === 0);

      if (this.editorContent == null || this.editorContent.trim().length === 0) {
        this.showDialog(
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          'คุณยังไม่ได้กรอกเนื้อหา',
          [{text: 'OK', onClick: null}],
          true
        );
      } else {
        this.doSaving();
      }
    },
    doSaving() {
      const self = this;

      const formData = new FormData();
      //formData.append('id', this.item == null ? 0 : this.item.id);
      formData.append('content_data', this.editorContent.trim());
      //formData.append('_method', 'put');
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      };

      this.isSaving = true;
      //const saveMethod = this.item == null ? axios.post : axios.put;
      axios.post(`/api/vision`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.isUpdated = true;

            this.snackbar.message = 'บันทึกข้อมูลสำเร็จ';
            this.snackbar.iconName = 'mdi-check-bold';
            this.snackbar.visible = true;
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

.ck-content li {
  margin-bottom: 0.8em;
  margin-left: 2em;
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
