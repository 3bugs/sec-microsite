<template>
  <v-container>
    <my-progress-overlay :visible="isDeleting || isLoadingItem"/>
    <!--<v-overlay
      :value="isDeleting"
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
    </v-overlay>-->
    <v-tabs
      v-model="tab"
      style="display: none"
      align-with-title
    >
      <v-tab
        v-for="item in ['list', 'details']"
        :key="item"
      >
        {{ item }}
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item
        :key="'list'"
      >
        <v-data-table
          v-if="true || showList"
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
              <v-btn
                color="primary"
                dark
                class="mb-2 mr-2"
                @click="handleClickAdd"
              >
                <v-icon
                  small
                  class="mr-2"
                >
                  mdi-plus-thick
                </v-icon>
                เพิ่ม
              </v-btn>
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
          <template v-slot:item.image="{ item }">
            <v-img
              :lazy-src="`${item.image}`"
              max-height="75"
              max-width="150"
              :src="`${item.image}`"
              style="border: 0 solid #ccc"
              class="mt-2 mb-2"
            >
            </v-img>
          </template>

          <!--title-->
          <template v-slot:item.title="{ item }">
            <span v-bind:style="{color: item.published ? 'rgba(0, 0, 0, 1)' : 'rgba(0, 0, 0, 0.4)'}">{{ item.title }}</span>
          </template>

          <template v-slot:item.url="{ item }">
            <a :href="item.url" target="_blank">{{ item.url }}</a>
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
              <span>สร้าง: {{ formatThaiDateTime(item.created_at) }}</span>
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
              <span>แก้ไขล่าสุด: {{ item.updated_at == null ? 'ยังไม่เคยมีการแก้ไข' : formatThaiDateTime(item.updated_at) }}</span>
            </v-tooltip>
          </template>

          <!--published-->
          <template v-slot:item.published="{ item }">
            <v-switch
              class="ma-0 pa-0"
              v-model="item.published"
              color="primary"
              hide-details
              inset
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
                  @click="() => handleClickEdit(item)"
                >
                  mdi-pencil
                </v-icon>
              </template>
              <span>แก้ไข</span>
            </v-tooltip>

            <!--ลบ-->
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-icon
                  small
                  v-bind="attrs"
                  v-on="on"
                  @click="() => handleClickDelete(item)"
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
      </v-tab-item>

      <v-tab-item
        :key="'details'"
      >
        <details-form
          v-if="!showList"
          :table-name="tableName"
          :item="editItem"
          :on-cancel-form="handleCancelForm"
          :on-save="handleSave"
          :on-delete="handleDelete"
        />
      </v-tab-item>
    </v-tabs-items>

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
  </v-container>
</template>

<script>
import {routeDataList, getRouteTitle} from '../constants';
import DetailsForm from '../components/_details_form_2';
import MyDialog from '../components/my_dialog';
import MyProgressOverlay from '../components/my_progress_overlay';
import {formatThaiDateTime} from '../utils/utils';
import {getThaiDateText} from "../utils/utils";

export default {
  props: {
    tableName: String,
    withDate: {
      type: Boolean,
      default: false,
    },
    showPinned: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    DetailsForm, MyDialog, MyProgressOverlay,
  },
  data() {
    return {
      KEY_TABLE_OPTIONS: `table-${this.tableName}-options`,
      tab: 0,
      editItem: null,
      showList: true,
      isLoadingList: true,
      isLoadingItem: false,
      isDeleting: false,
      isUpdatePublished: false,
      headers: [
        {text: 'รูปภาพ', value: 'image', sortable: false, width: '170px',},
        {text: 'หัวข้อ/ชื่อเรื่อง', align: 'start', value: 'title', sortable: true,},
        {text: 'URL', value: 'url', sortable: true,},
        {text: 'ส', value: 'created_at', sortable: true, width: '60px', align: 'center',},
        {text: 'ก', value: 'updated_at', sortable: true, width: '60px', align: 'center',},
        {text: 'เผยแพร่', value: 'published', sortable: true, width: '100px', align: 'center',},
        {text: 'จัดการ', value: 'actions', sortable: false, width: '120px', align: 'center',},
      ].filter(item => item != null),
      dataList: [],
      routeDataList,
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
      formatThaiDateTime,
      getThaiDateText,
    };
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
    },
  },
  created() {
    console.log(`***** ${this.tableName} created() *****`);
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

    handleClickAdd() {
      this.tab = 1;
      this.editItem = null;
      this.showList = false;
    },

    handleClickEdit(item) {
      this.fetchItem(item.id, fetchedItem => {
        this.tab = 1;
        this.editItem = fetchedItem;
        this.showList = false;
        this.scrollToTop();
      });
    },

    handleClickRefresh() {
      this.dataList = [];
      this.fetchList();
    },

    handleCancelForm() {
      this.tab = 0;
      this.showList = true;
    },
    handleSave() {
      this.tab = 0;
      this.showList = true;
      this.scrollToTop();
      this.handleClickRefresh();
    },
    scrollToTop() {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    },
    handleDelete() {
      this.tab = 0;
      this.showList = true;
      this.scrollToTop();
      this.handleClickRefresh();
    },

    fetchList() {
      this.isLoadingList = true;

      const url = `/api/${this.tableName}?t=${Date.now()}`;
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

    fetchItem(itemId, successCallback) {
      this.isLoadingItem = true;

      const url = `/api/${this.tableName}/${itemId}?t=${Date.now()}`;
      console.log(url);

      axios.get(url, {
        params: {}
      })
        .then((response) => {
          console.log(response.data);
          this.isLoadingItem = false;

          if (response.data.status === 'ok') {
            this.$nextTick(() => {
              const item = response.data.data;
              successCallback(item);
            })
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
          this.isLoadingItem = false;

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
          //this.isLoadingItem = false;
        });
    },

    handleClickDelete(item) {
      this.showDialog(
        `ลบข้อมูล`,
        `ต้องการลบข้อมูล '${item.title}' ใช่หรือไม่?`,
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
      axios.post(`/api/${this.tableName}`, {
        id,
        _method: 'delete',
      })
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.snackbar.message = 'ลบข้อมูลสำเร็จ';
            this.snackbar.iconName = 'mdi-check-bold';
            this.snackbar.visible = true;
            this.handleClickRefresh();

            /*this.showDialog('ลบข้อมูลสำเร็จ', 'ลบข้อมูลในฐานข้อมูลสำเร็จ', [{
              text: 'OK', onClick: () => {
                this.handleClickRefresh();
              },
            }], true);*/
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

    /*close () {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },*/
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
      axios.post(`/api/${this.tableName}`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.snackbar.message = 'บันทึกข้อมูลสำเร็จ';
            this.snackbar.iconName = 'mdi-check-bold';
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

<style>
.my-class {
  white-space: nowrap;
}

.v-list-item__title {
  line-height: 2 !important;
}
</style>
