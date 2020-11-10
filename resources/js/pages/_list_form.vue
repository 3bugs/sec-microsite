<template>
  <v-container>
    <v-overlay
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
    </v-overlay>
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
              :lazy-src="`${item.cover_image}`"
              max-height="75"
              max-width="150"
              :src="`${item.cover_image}`"
              style="border: 0 solid #ccc"
              class="mt-2 mb-2"
            >
            </v-img>
          </template>

          <!--category-->
          <template v-slot:item.category_id="{ item }">
            <v-chip
              small
              :color="categoryColorList[item.category_id - 1]"
            >
              {{ item.category_title }}
            </v-chip>
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
            <!--ดูหน้าเว็บ-->
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-icon
                  small
                  class="mr-3"
                  v-bind="attrs"
                  v-on="on"
                  @click="() => handleClickViewWeb(item)"
                >
                  mdi-web
                </v-icon>
              </template>
              <span>ดูหน้าเว็บ</span>
            </v-tooltip>

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
          :category-list="categoryList"
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
      {{ snackbar.message }}
    </v-snackbar>
  </v-container>
</template>

<script>
import {routeDataList, getRouteTitle, categoryColorList} from '../constants';
import DetailsForm from '../components/_details_form';
import MyDialog from '../components/my_dialog';
import {formatThaiDateTime} from '../utils/utils';

export default {
  props: {
    tableName: String,
  },
  components: {
    DetailsForm, MyDialog,
  },
  data() {
    return {
      KEY_TABLE_OPTIONS: `table-${this.tableName}-options`,
      tab: 0,
      editItem: null,
      showList: true,
      isLoadingList: true,
      isDeleting: false,
      isUpdatePublished: false,
      headers: [
        {text: 'รูปภาพปก', value: 'image', sortable: false, width: '170px',},
        {text: 'หัวเรื่อง', align: 'start', value: 'title', sortable: true,},
        /*{text: 'คำอธิบายย่อ', value: 'description', sortable: true,},*/
        {text: 'หมวดหมู่', value: 'category_id', sortable: true,},
        {text: 'สร้าง', value: 'created_at', sortable: true, width: '70px', align: 'center',},
        {text: 'แก้ไข', value: 'updated_at', sortable: true, width: '70px', align: 'center',},
        {text: 'เผยแพร่', value: 'published', sortable: true, width: '100px', align: 'center',},
        {text: 'จัดการ', value: 'actions', sortable: false, width: '120px', align: 'center',},
      ],
      dataList: [],
      categoryList: [],
      routeDataList,
      categoryColorList,
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

    handleClickViewWeb(item) {
      window.open(`/${this.tableName}/${item.id}`);
      /*this.showDialog(
        'Under Construction!',
        'ฟังก์ชันนี้อยู่ระหว่างการพัฒนา',
        [
          {
            text: 'OK',
            onClick: null,
          }
        ],
        false,
      );*/
    },

    handleClickEdit(item) {
      this.tab = 1;
      this.editItem = item;
      this.showList = false;
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

            this.categoryList = response.data.category_list.map(item => ({
              ...item, toString: () => {
                return item.title
              }
            }));
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
