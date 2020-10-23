<template>
  <v-container>
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
          v-if="showList"
          :headers="headers"
          :items="fundraisingList"
          :loading="isLoadingList"
          class="elevation-1"
          :footer-props="{
            //'items-per-page-all-text': 'ทั้งหมด',
            'items-per-page-text': 'จำนวนแถวข้อมูลต่อ 1 หน้า',
            'page-text': '',
            'show-current-page': true,
          }"
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
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="headline">ต้องการลบข้อมูลนี้?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">ยกเลิก</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">ลบ</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
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
          <template v-slot:item.category_id="{ item }">
            <v-chip
              small
              :color="fundraisingCategoryColorList[item.category_id - 1]"
            >
              {{ item.category_title }}
            </v-chip>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-icon
                  small
                  class="mr-2"
                  v-bind="attrs"
                  v-on="on"
                  @click="() => handleClickEdit(item)"
                >
                  mdi-pencil
                </v-icon>
              </template>
              <span>แก้ไข</span>
            </v-tooltip>
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
              color="purple"
              :height="10"
              indeterminate
            ></v-progress-linear>
          </template>
        </v-data-table>
      </v-tab-item>

      <v-tab-item
        :key="'details'"
      >
        <fundraising-form
          v-if="!showList"
          :item="editItem"
          :category-list="fundraisingCategoryList"
          :on-cancel-form="handleCancelForm"
        />
      </v-tab-item>
    </v-tabs-items>
  </v-container>
</template>

<script>
import FundraisingForm from '../components/fundraising_form';
import {routeDataList, fundraisingCategoryColorList} from '../constants';

export default {
  components: {
    FundraisingForm,
  },
  data: () => ({
    tab: 0,
    editItem: null,
    showList: true,
    isLoadingList: true,
    dialog: false,
    dialogDelete: false,
    headers: [
      {text: 'Title', align: 'start', value: 'title', sortable: true,},
      {text: 'Short description', value: 'description', sortable: true,},
      {text: 'Cover Image', value: 'image', sortable: false,},
      {text: 'Category', value: 'category_id', sortable: true,},
      {text: 'Actions', value: 'actions', sortable: false,},
    ],
    fundraisingList: [],
    fundraisingCategoryList: [],
    routeDataList,
    fundraisingCategoryColorList,
  }),
  computed: {
    currentRouteTitle() {
      const currentRouteName = this.$route.name;
      return this.routeDataList.filter(
        route => route.name === currentRouteName
      )[0].title;
    },
  },
  created() {
    console.log('***** Fundraising created() *****');
    this.fetchList();
  },
  methods: {
    handleClickAdd() {
      this.tab = 1;
      this.editItem = null;
      this.showList = false;
    },

    handleClickEdit(item) {
      this.tab = 1;
      this.editItem = item;
      this.showList = false;
    },

    handleClickRefresh() {
      this.fundraisingList = [];
      this.fetchList();
    },

    handleCancelForm() {
      this.tab = 0;
      this.showList = true;
    },

    fetchList() {
      this.isLoadingList = true;

      axios.get('/api/fundraising', {
        params: {}
      })
        .then((response) => {
          this.isLoadingList = false;

          console.log(response.data);
          if (response.data.status === 'ok') {
            this.fundraisingList = response.data.data_list;
            this.fundraisingCategoryList = response.data.category_list.map(item => ({
              ...item, toString: () => {
                return item.title
              }
            }));
          }
        })
        .catch(function (error) {
          this.isLoadingList = false;
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    },

    handleClickDelete(item) {
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      //this.desserts.splice(this.editedIndex, 1)
      this.closeDelete();
    },

    /*close () {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },*/

    closeDelete() {
      this.dialogDelete = false;
      /*this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });*/
    },
  }
}
</script>
