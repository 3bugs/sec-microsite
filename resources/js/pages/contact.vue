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

    <v-dialog
      v-model="editDialogVisible"
      max-width="600px"
      :persistent="true"
    >
      <v-card>
        <v-card-title>
                <span class="headline">
                  บันทึกช่วยจำ
                </span>
          <v-spacer></v-spacer>
          <v-switch
            class="ma-0 pa-0"
            label="ติดต่อกลับแล้ว"
            v-model="editItem.seen"
            color="primary"
            inset
            hide-details
          ></v-switch>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-form
              ref="form"
              lazy-validation
              class="pl-0 pr-0"
            >
              <v-textarea
                v-model="editItem.note"
                label="ข้อความ"
                rows="6"
                row-height="20"
              ></v-textarea>
            </v-form>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="handleClickCancel"
          >
            ยกเลิก
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="handleClickSave"
          >
            บันทึก
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="messageDialogVisible"
      max-width="600px"
      :persistent="false"
    >
      <v-card>
        <v-card-title>
                <span class="headline">
                  ข้อความจากผู้ติดต่อ
                </span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-textarea
              v-model="contactMessage"
              label="ข้อความ"
              rows="6"
              row-height="20"
              readonly
            ></v-textarea>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="handleClickCloseMessage"
          >
            ปิด
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
          <v-chip
            class="ma-2"
            :color="unseenCount > 0 ? 'red' : 'green'"
            text-color="white"
          >
            ยังไม่ได้ติดต่อกลับ: {{ unseenCount }}
          </v-chip>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>

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
          :style="`border: 0 solid red; background-color: ${item.seen ? 'transparent' : 'pink'}; min-height: 50px; height: 100%; width: 10px;`"
          class="mt-2 mb-2"
        >
        </div>
      </template>

      <!--email-->
      <template v-slot:item.email="{ item }">
        <a :href="`mailto:${item.email}`">{{ item.email }}</a>
      </template>

      <!--message-->
      <template v-slot:item.message="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
<!--            <v-icon
              small
              v-bind="attrs"
              v-on="on"
              @click="handleClickEdit(item)"
            >
              mdi-note
            </v-icon>-->
            <div
              id="contact-message"
              v-html="nl2br(item.message)"
              v-bind="attrs"
              v-on="on"
              @click="handleClickMessage(item)"
            ></div>
          </template>
          <div v-html="nl2br(item.message)"></div>
        </v-tooltip>
      </template>

      <!--created-->
      <template v-slot:item.created_at="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              small
              v-bind="attrs"
              v-on="on"
            >
              mdi-calendar
            </v-icon>
          </template>
          <span>สร้าง: {{ formatThaiDateTime(item.created_at) }}</span>
        </v-tooltip>
      </template>

      <!--status-->
      <template
        v-slot:item.seen="{ item }"
      >
        <v-switch
          class="ma-0 pa-0"
          v-model="item.seen"
          color="primary"
          hide-details
          inset
          @click="handleClickSwitch(item)"
        ></v-switch>
      </template>

      <!--note-->
      <template v-slot:item.note="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              small
              v-bind="attrs"
              v-on="on"
              @click="handleClickEdit(item)"
            >
              mdi-note
            </v-icon>
          </template>
          <span v-html="item.note == null || item.note.length === 0 ? '(ยังไม่มีบันทึก)' : nl2br(item.note)"></span>
        </v-tooltip>
      </template>

      <template v-slot:item.actions="{ item }">
        <!--ลบ-->
        <v-tooltip bottom>
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
import MyDialog from '../components/my_dialog';
import {formatThaiDateTime, nl2br} from '../utils/utils';

export default {
  props: {},
  components: {
    MyDialog,
  },
  data() {
    return {
      KEY_TABLE_OPTIONS: `table-contact-options`,
      isLoadingList: true,
      isDeleting: false,
      isUpdatePublished: false,
      isSaving: false,
      headers: [
        {text: ' ', align: 'start', value: 'strip', sortable: false, width: '15px',},
        {text: 'ชื่อผู้ติดต่อ', value: 'name', sortable: true,},
        {text: 'อีเมล', value: 'email', sortable: true,},
        {text: 'เบอร์โทร', value: 'phone', sortable: true,},
        {text: 'ข้อความ', value: 'message', sortable: false,},
        {text: 'ส', value: 'created_at', sortable: true, width: '60px', align: 'center',},
        {text: 'ติดต่อแล้ว', value: 'seen', sortable: true, width: '120px', align: 'center',},
        {text: 'บันทึกช่วยจำ', value: 'note', sortable: false, width: '100px', align: 'center',},
        {text: 'จัดการ', value: 'actions', sortable: false, width: '70px', align: 'center',},
      ],
      dataList: [],
      unseenCount: null,
      routeDataList,
      editDialogVisible: false,
      editItem: {
        note: '',
      },
      defaultItem: {
        note: '',
      },
      messageDialogVisible: false,
      contactMessage: '',
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
      nl2br,
    }
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
    },
  },
  watch: {
    editDialogVisible(val) {
      val || this.closeEditDialog();
    },
  },
  created() {
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

    handleClickRefresh() {
      this.dataList = [];
      this.unseenCount = null;
      this.fetchList();
    },

    scrollToTop() {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    },

    fetchList() {
      this.isLoadingList = true;

      const url = `/api/contact?t=${Date.now()}`;
      console.log(url);

      axios.get(url, {
        params: {}
      })
        .then((response) => {
          console.log(response.data);
          if (response.data.status === 'ok') {
            const dataList = response.data.data_list;
            dataList.forEach((item, index) => {
              item.seen = (item.seen === 1);
            });
            this.dataList = dataList;
            this.unseenCount = response.data.unseen_count;
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

    handleClickEdit(item) {
      this.editItem = Object.assign({}, item);
      this.editDialogVisible = true;
    },
    handleClickCancel() {
      this.closeEditDialog();
    },
    handleClickSave() {
      this.doSaving();
    },
    closeEditDialog() {
      this.editItem = Object.assign({}, this.defaultItem);
      this.editDialogVisible = false;
    },

    doSaving() {
      const self = this;
      const {id, note, seen} = this.editItem;
      const formData = new FormData();
      formData.append('id', id);
      formData.append('note', note == null ? '' : note.trim());
      formData.append('seen', seen ? 1 : 0);
      formData.append('_method', 'put');

      const config = {
        headers: {
          //'content-type': 'multipart/form-data'
        }
      };

      this.isSaving = true;
      //axios.put ไม่ work!!!
      //const saveMethod = this.item == null ? axios.post : axios.put;
      axios.post(`/api/contact`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.closeEditDialog();
            this.snackbar.message = 'บันทึกข้อมูลสำเร็จ'
            this.snackbar.iconName = 'mdi-check-bold';
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

    handleClickDelete(item) {
      this.showDialog(
        `ลบข้อมูลผู้ติดต่อ`,
        `ยืนยันลบข้อมูลผู้ติดต่อชื่อ '${item.name}' หรือไม่?`,
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
      axios.post(`/api/contact`, {
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
      this.showDialog(
        `สถานะการติดต่อกลับ`,
        `ต้องการเปลี่ยนสถานะการติดต่อกลับเป็น ${!item.seen ? 'OFF (ยังไม่ได้ติดต่อกลับ)' : 'ON (ติดต่อกลับแล้ว)'} ใช่หรือไม่?`,
        [
          {
            text: 'ไม่ใช่', onClick: () => {
              item.seen = !item.seen;
            },
          },
          {
            text: 'ใช่', onClick: () => {
              this.doUpdateSeen(item);
            },
          },
        ],
        true,
      );
    },
    doUpdateSeen(item) {
      const self = this;

      const formData = new FormData();
      formData.append('id', item.id);
      formData.append('seen', item.seen ? 1 : 0);
      formData.append('_method', 'put');
      const config = {
        /*headers: {
          'content-type': 'multipart/form-data'
        }*/
      };

      item.isUpdating = true;
      //axios.put ไม่ work!!!
      axios.post(`/api/contact`, formData, config)
        .then((response) => {
          const status = response.data.status;
          const message = response.data.message;
          if (status === 'ok') {
            this.snackbar.message = 'บันทึกข้อมูลสำเร็จ';
            this.snackbar.iconName = 'mdi-check-bold';
            this.snackbar.visible = true;

            this.dataList = [];
            this.unseenCount = null;
            this.fetchList();
          } else {
            item.seen = !item.seen;

            this.showDialog('ผิดพลาด', `เกิดข้อผิดพลาด: ${message}`, [{
              text: 'OK', onClick: () => {
              },
            }], true);
          }
        })
        .catch(function (error) {
          item.seen = !item.seen;

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

    handleClickMessage(item) {
      this.contactMessage = item.message;
      this.messageDialogVisible = true;
    },
    handleClickCloseMessage() {
      this.messageDialogVisible = false;
    },
  }
}
</script>

<style scoped>
  #contact-message {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
</style>
