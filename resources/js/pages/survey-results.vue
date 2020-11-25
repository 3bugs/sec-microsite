<template>
  <v-container>
    <v-overlay
      :value="false"
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
          :style="`border: 0 solid red; background-color: transparent; min-height: 25px; height: 100%; width: 10px;`"
          class="mt-1 mb-1"
        >
        </div>
      </template>

      <!--created-->
      <template v-slot:item.created_at="{ item }">
        <span>{{ formatThaiDateTime(item.created_at) }}</span>
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
import {formatThaiDateTime} from '../utils/utils';

export default {
  props: {
  },
  components: {
    MyDialog,
  },
  data() {
    return {
      KEY_TABLE_OPTIONS: `table-survey-results-options`,
      isLoadingList: true,
      isDeleting: false,
      isUpdatePublished: false,
      headers: [
        {text: ' ', align: 'start', value: 'strip', sortable: false, width: '15px',},
        {text: 'IP Address', value: 'ip', sortable: true,},
        {text: 'Result', value: 'result', sortable: true,},
        {text: 'บันทึกเมื่อ', value: 'created_at', sortable: true,},
      ],
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
    }
  },
  computed: {
    currentRouteTitle() {
      return getRouteTitle(this.$route.name);
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
      this.fetchList();
    },

    scrollToTop() {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    },

    fetchList() {
      this.isLoadingList = true;

      const url = `/api/survey?t=${Date.now()}`;
      console.log(url);

      axios.get(url, {
        params: {}
      })
        .then((response) => {
          console.log(response.data);
          if (response.data.status === 'ok') {
            this.dataList = response.data.data_list;
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
  }
}
</script>

<style scoped>
</style>
