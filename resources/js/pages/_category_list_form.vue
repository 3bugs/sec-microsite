<template>
  <v-container>
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

    <v-data-table
      :headers="headers"
      :items="dataList"
      :loading="isLoadingList"
      class="elevation-1"
      :footer-props="{
            //'items-per-page-all-text': 'ทั้งหมด',
            'items-per-page-text': 'จำนวนแถวข้อมูลต่อหน้า',
            //'page-text': '',
            'show-current-page': true,
          }"
      :options="getTableOptions()"
      @update:options="handleUpdateTableOptions"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>{{ currentRouteTitle }}</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>

          <v-dialog
            v-model="editDialogVisible"
            max-width="600px"
          >
            <template
              v-if="allowAdd"
              v-slot:activator="{ on, attrs }"
            >
              <v-btn
                color="primary"
                dark
                class="mb-2 mr-2"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon
                  small
                  class="mr-2"
                >
                  mdi-plus-thick
                </v-icon>
                เพิ่ม
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">
                  {{ editDialogTitle }}
                </span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                    class="pl-0 pr-0"
                  >
                    <v-text-field
                      v-model="editItem.title"
                      :counter="255"
                      :rules="titleRules"
                      label="ชื่อหมวดหมู่"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="editItem.description"
                      :rules="descriptionRules"
                      label="คำอธิบาย"
                      required
                    ></v-text-field>
                  </v-form>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="handleClickCloseEditDialog"
                >
                  ยกเลิก
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="handleClickSaveEditDialog"
                >
                  บันทึก
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-btn
            color="success"
            dark
            class="mb-2"
            @click="handleClickRefresh"
          >
            <v-icon medium>
              mdi-refresh
            </v-icon>
          </v-btn>
        </v-toolbar>
      </template>
      <template v-slot:item.strip="{ item }">
        <div
          :style="`border: 0 solid red; background-color: ${categoryColorList[(item.id - 1) % categoryColorList.length]}; min-height: 70px; height: 100%; width: 10px;`"
          class="mt-2 mb-2"
        >
        </div>
      </template>

      <!--created-->
      <template v-slot:item.created_at="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              small
              class="mr-2"
              v-bind="attrs"
              v-on="on"
            >
              mdi-calendar
            </v-icon>
          </template>
          <span>{{ formatThaiDateTime(item.created_at) }}</span>
        </v-tooltip>
      </template>

      <!--updated-->
      <template v-slot:item.updated_at="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              small
              class="mr-2"
              v-bind="attrs"
              v-on="on"
            >
              mdi-calendar
            </v-icon>
          </template>
          <span>{{ item.updated_at == null ? 'ยังไม่เคยมีการแก้ไข' : formatThaiDateTime(item.updated_at) }}</span>
        </v-tooltip>
      </template>

      <!--status-->
      <template v-slot:item.published="{ item }">
        <v-switch
          class="ma-0 pa-0"
          v-model="item.published"
          color="primary"
          hide-details
          @click="handleClickSwitch(item)"
        ></v-switch>
      </template>

      <template v-slot:item.actions="{ item }">
        <!--แก้ไข-->
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              small
              class="mr-3"
              v-bind="attrs"
              v-on="on"
              @click="handleClickEdit(item)"
            >
              mdi-pencil
            </v-icon>
          </template>
          <span>แก้ไข</span>
        </v-tooltip>

        <!--ลบ-->
        <v-tooltip bottom v-if="allowDelete">
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              small
              v-bind="attrs"
              v-on="on"
              @click="handleClickDelete(item)"
            >
              mdi-delete
            </v-icon>
          </template>
          <span>ลบ</span>
        </v-tooltip>
      </template>
      <template
        v-slot:progress
      >
        <v-progress-linear
          color="indigo"
          :height="5"
          indeterminate
        ></v-progress-linear>
      </template>
    </v-data-table>

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
      {{ snackbar.message }}
    </v-snackbar>
  </v-container>
</template>

<script>
import {routeDataList, getRouteTitle, categoryColorList} from '../constants';
import MyDialog from '../components/my_dialog';
import {formatThaiDateTime} from '../utils/utils';

export default {
  props: {
    tableName: String,
    allowAdd: {
      type: Boolean,
      default: true,
    },
    allowDelete: {
      type: Boolean,
      default: true,
    },
  },
  components: {
    MyDialog,
  },
  data() {
    return {
      KEY_TABLE_OPTIONS: `table-${this.tableName}-category-options`,
      valid: true,
      editItemIndex: -1,
      editItem: {
        title: '',
        description: '',
      },
      defaultItem: {
        title: '',
        description: '',
      },
      titleRules: [
        v => !!v || 'ต้องกรอกชื่อหมวดหมู่',
        v => (v && v.length <= 255) || 'ชื่อหมวดหมู่ต้องไม่เกิน 255 ตัวอักษร',
      ],
      descriptionRules: [
        v => !!v || 'ต้องกรอกคำอธิบาย',
      ],
      isLoadingList: true,
      isSaving: false,
      isDeleting: false,
      isUpdatePublished: false,
      headers: [
        {text: ' ', align: 'start', value: 'strip', sortable: false, width: '15px',},
        {text: 'ชื่อหมวดหมู่', align: 'start', value: 'title', sortable: true,},
        {text: 'คำอธิบาย', value: 'description', sortable: true,},
        {text: 'สร้าง', value: 'created_at', sortable: true, width: '70px', align: 'center',},
        {text: 'แก้ไข', value: 'updated_at', sortable: true, width: '70px', align: 'center',},
        {text: 'เผยแพร่', value: 'published', sortable: true, width: '100px', align: 'center',},
        {text: 'จัดการ', value: 'actions', sortable: false, width: '90px', align: 'center',},
      ],
      dataList: [],
      routeDataList,
      categoryColorList,
      editDialogVisible: false,
      dialog: {
        visible: false,
        title: '',
        message: '',
      },
      snackbar: {
        visible: false,
        message: '',
      },
      formatThaiDateTime,
    }
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
    },
    editDialogTitle() {
      return `${this.editItemIndex === -1 ? 'เพิ่ม' : 'แก้ไข'}หมวดหมู่`;
    }
  },
  watch: {
    editDialogVisible(val) {
      val || this.closeEditDialog();
    },
  },
  created() {
    console.log(`***** ${this.tableName} Category created() *****`);
    this.fetchList();
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

    handleUpdateTableOptions(option) {
      //alert(JSON.stringify(option));
      localStorage.setItem(this.KEY_TABLE_OPTIONS, JSON.stringify(option));
      console.log('TABLE OPTIONS SAVED');
    },
    getTableOptions() {
      const jsonOptions = localStorage.getItem(this.KEY_TABLE_OPTIONS);
      console.log('TABLE OPTIONS RESTORED');
      return jsonOptions == null ? null : JSON.parse(jsonOptions);
    },

    handleClickEdit(item) {
      this.editItemIndex = item.id;
      this.editItem = Object.assign({}, item);
      this.editDialogVisible = true;
    },
    handleClickCloseEditDialog() {
      this.closeEditDialog();
    },
    handleClickSaveEditDialog() {
      if (this.$refs.form.validate()) {
        this.doSaving();
      } else {
        this.snackbar.visible = true;
        this.snackbar.message = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        /*this.showDialog(
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          'กรุณากรอกข้อมูลให้ครบถ้วน',
          [{text: 'OK', onClick: null}],
          true
        );*/
      }
    },
    closeEditDialog() {
      this.editItemIndex = -1;
      this.editItem = Object.assign({}, this.defaultItem);
      this.editDialogVisible = false;
      this.resetValidation();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },

    doSaving() {
      const self = this;
      const {title, description} = this.editItem;
      const formData = new FormData();
      formData.append('id', this.editItemIndex);
      formData.append('title', title.trim());
      formData.append('description', description.trim());
      if (this.editItemIndex !== -1) {
        formData.append('_method', 'put');
      }
      const config = {
        headers: {
          //'content-type': 'multipart/form-data'
        }
      };

      this.isSaving = true;
      //axios.put ไม่ work!!!
      //const saveMethod = this.item == null ? axios.post : axios.put;
      axios.post(`/api/${this.tableName}-category`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.closeEditDialog();
            this.snackbar.message = 'บันทึกข้อมูลสำเร็จ'
            this.snackbar.visible = true;
            this.handleClickRefresh();
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

    handleClickRefresh() {
      this.dataList = [];
      this.fetchList();
    },

    scrollToTop() {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    },

    fetchList() {
      this.isLoadingList = true;

      const url = `/api/${this.tableName}-category?t=${Date.now()}`;
      console.log(url);

      axios.get(url, {
        params: {}
      })
        .then((response) => {
          console.log(response.data);
          if (response.data.status === 'ok') {
            const dataList = response.data.data_list;
            dataList.forEach((item, index) => {
              item.published = (item.published === 1);
              item.isUpdating = false;
            });
            this.dataList = dataList;
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
          this.isLoadingList = false;
        });
    },

    handleClickDelete(item) {
      this.showDialog(
        `ลบหมวดหมู่`,
        `การลบหมวดหมู่จะทำให้บทความทั้งหมดภายใต้หมวดหมู่นั้นถูกลบไปด้วย ยืนยันลบหมวดหมู่ '${item.title}' หรือไม่?`,
        [
          {
            text: 'ยกเลิก',
            onClick: () => {
            },
          },
          {
            text: 'ลบ',
            onClick: () => {
              this.doDeleting(item.id);
            },
          },
        ],
        false,
      );
    },
    doDeleting(id) {
      this.isDeleting = true;
      axios.post(`/api/${this.tableName}-category`, {
        id,
        _method: 'delete',
      })
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.snackbar.message = 'ลบข้อมูลสำเร็จ';
            this.snackbar.visible = true;
            this.handleClickRefresh();
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
        .then(() => { // always executed
          this.isDeleting = false;
        });
    },

    handleClickSwitch(item) {
      const preText = !item.published ? 'ปิดการ' : ''
      this.showDialog(
        `${preText}เผยแพร่ข้อมูล`,
        `ต้องการ${preText}เผยแพร่ข้อมูลนี้ใช่หรือไม่?`,
        [
          {
            text: 'ไม่ใช่', onClick: () => {
              item.published = !item.published;
            },
          },
          {
            text: 'ใช่', onClick: () => {
              this.doUpdatePublished(item);
            },
          },
        ],
        true,
      );
    },
    doUpdatePublished(item) {
      const self = this;

      const formData = new FormData();
      formData.append('id', item.id);
      formData.append('published', item.published ? 1 : 0);
      formData.append('_method', 'put');
      const config = {
        /*headers: {
          'content-type': 'multipart/form-data'
        }*/
      };

      item.isUpdating = true;
      //axios.put ไม่ work!!!
      axios.post(`/api/${this.tableName}-category`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.snackbar.message = 'บันทึกข้อมูลสำเร็จ';
            this.snackbar.visible = true;
          } else {
            item.published = !item.published;

            this.showDialog('ผิดพลาด', `เกิดข้อผิดพลาด: ${message}`, [{
              text: 'OK', onClick: () => {
              },
            }], true);
          }
        })
        .catch(function (error) {
          item.published = !item.published;

          console.log(error);
          this.showDialog('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ Server กรุณาลองอีกครั้ง\n\n' + error, [{
            text: 'OK', onClick: () => {
              //
            },
          }], true);
        })
        .then(function () { // always executed
          self.isUpdating = false;
        });
    },
  }
}
</script>

<style scoped>
</style>
