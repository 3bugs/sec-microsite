<template>
  <v-container>
    <v-data-table
      v-if="showList"
      :headers="headers"
      :items="fundraisingList"
      :loading="isLoadingList"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>วิธีการระดมทุน</v-toolbar-title>
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
              class="mr-1"
            >
              mdi-plus-thick
            </v-icon>
            ADD
          </v-btn>
          <v-btn
            color="success"
            dark
            class="mb-2"
            @click="handleClickRefresh"
          >
            <v-icon
              class="mr-1"
            >
              mdi-refresh
            </v-icon>
            REFRESH
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
        <img :src="'/images/' + item.cover_image" style="width: 100px; height: 50px" class="mt-1">
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="() => handleClickEdit(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          small
          @click="() => handleClickDelete(item)"
        >
          mdi-delete
        </v-icon>
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

    <fundraising-form
      v-if="!showList"
      :item="editItem"
      :category-list="fundraisingCategoryList"
      :on-cancel-form="handleCancelForm"
    />
  </v-container>
</template>

<script>
import FundraisingForm from '../components/fundraising_form';

export default {
  components: {
    FundraisingForm,
  },
  data: () => ({
    editItem: null,
    showList: true,
    isLoadingList: true,
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: 'Title',
        align: 'start',
        value: 'title',
      },
      {text: 'Short description', value: 'description'},
      {text: 'Cover Image', value: 'image'},
      {text: 'Actions', value: 'actions', sortable: false},
    ],
    fundraisingList: [],
    fundraisingCategoryList: [],
  }),
  created() {
    console.log('***** Fundraising created() *****');
    this.fetchList();
  },
  methods: {
    handleClickAdd() {
      this.editItem = null;
      this.showList = false;
    },

    handleClickEdit(item) {
      this.editItem = item;
      this.showList = false;
    },

    handleClickRefresh() {
      this.fundraisingList = [];
      this.fetchList();
    },

    handleCancelForm() {
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
