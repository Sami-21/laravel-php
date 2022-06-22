<template>
  <v-data-table
    :headers="headers"
    :items="transactions"
    sort-by="name"
    class="elevation-1"
  >
    <!-- Custom column for the date -->
    <template v-slot:[`item.created_at`]="{ item }">
      <span>{{ new Date(item.created_at).toLocaleString() }}</span>
    </template>

    <!-- Custom column for the Total -->
    <template v-slot:[`item.total`]="{ item }">
      <span>{{ parseFloat(item.total).toFixed(2) }} DA</span>
    </template>

    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Transaction</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-autocomplete
          clearable
          :items="
            transactions.map((item) => {
              return item.client.name;
            })
          "
        ></v-autocomplete>
        <v-spacer></v-spacer>

        <Add />

        <Edit
          :dialogEdit="dialogEdit"
          :close="close"
          :current="currentItem"
          v-if="dialogEdit"
        />

        <Details
          :dialogView="dialogView"
          :close="close"
          :item="currentItem"
          v-if="dialogView"
        />

        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDeleteDialog"
                >Cancel</v-btn
              >
              <v-btn color="red darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="AddSuccess" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Transaction Added Successfully</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="AddSuccess = false">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="EditSuccess" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Transaction Edited Successfully</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="EditSuccess = false"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="DeleteSuccess" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Transaction Deleted Successfully</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="DeleteSuccess = false"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon small class="mr-1" @click="viewItem(item)">mdi-eye</v-icon>
      <v-icon small class="mr-1" @click="editItem(item)">mdi-pencil</v-icon>
      <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary">no Data available</v-btn>
    </template>
  </v-data-table>
</template>
<script>
import Add from "./partials/Add.vue";
import Edit from "./partials/Edit.vue";
import Details from "./partials/Details.vue";
import axios from "axios";

export default {
  components: {
    Add,
    Edit,
    Details,
  },

  data: () => ({
    dialogEdit: false,
    dialogView: false,
    dialogDelete: false,

    AddSuccess: false,
    EditSuccess: false,
    DeleteSuccess: false,

    headers: [
      { text: "Client", value: "client.name" },
      { text: "Provider", value: "provider.name" },
      { text: "Total", value: "total" },
      { text: "Date", value: "created_at" },
      { text: "Actions", value: "actions", sortable: false },
    ],

    transactions: [],

    editedIndex: -1,
    currentItem: {},
    defaultItem: {},
  }),

  mounted() {
    this.getTransactions();

    this.$bus.on("add", () => {
      (this.AddSuccess = true), this.getTransactions();
    });

    this.$bus.on("edit", () => {
      (this.EditSuccess = true), this.getTransactions();
    });
  },

  methods: {
    async getTransactions() {
      return new Promise((resolve, reject) => {
        axios
          .get("transactions")
          .then((res) => {
            this.transactions = res.data;
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },

    editItem(item) {
      this.editedIndex = this.transactions.indexOf(item);
      this.currentItem = Object.assign({}, item);
      this.dialogEdit = true;
    },

    viewItem(item) {
      this.editedIndex = this.transactions.indexOf(item);
      this.currentItem = Object.assign({}, item);
      this.dialogView = true;
    },

    deleteItem(item) {
      this.editedIndex = this.transactions.indexOf(item);
      this.currentItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    async deleteItemConfirm() {
      new Promise((resolve, reject) => {
        axios
          .delete(`transactions/${this.transactions[this.editedIndex].id}`)
          .then((res) => {
            this.DeleteSuccess = true;
            this.closeDeleteDialog();
            this.getTransactions();
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },

    close() {
      this.dialogEdit = false;
      this.dialogView = false;
      this.$nextTick(() => {
        this.currentItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDeleteDialog() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.currentItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
  },
};
</script>