<template>
  <v-data-table
    :headers="headers"
    :items="clients"
    sort-by="name"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Clients</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-autocomplete clearable ></v-autocomplete>
        <v-spacer></v-spacer>

         <Add :dialog="dialog" :close="close" />

         <Edit :dialogEdit="dialogEdit"  :close="close" :selectedItem="selectedItem" />

         <Details :dialogView="dialogView"  :close="close" :selectedItem="selectedItem" />
           
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-1" @click="viewItem(item)"> mdi-eye </v-icon>
      <v-icon small class="mr-1" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary"> no Data available </v-btn>
    </template>
  </v-data-table>
</template>
<script>
import Add from './partials/Add.vue';
import Edit from './partials/Edit.vue';
import Details from './partials/Details.vue';
import axios from 'axios';
export default {
    components:{Add , Edit , Details},
  data: () => ({
    dialog: false,
    dialogEdit:false,
    dialogView:false,
    dialogDelete: false,
    formRules: {
          name:(value) => {
            const pattern = /[a-zA-Z\s]+/;
            return pattern.test(value) || 'invalid name';
          }
          ,
          required: (value) => !!value || 'Required.',
          email: (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(value) || 'Invalid e-mail.';
          }
          ,
          phone: (value) => {
            const pattern = /^(00213|\+213|0)(5|6|7)[0-9]{8}$/;
            return pattern.test(value) || 'Invalid phone number.';
          },
          },
    headers: [
      {
        text: "Name",
        value: "name",
      },
      { text: "Email", value: "email" },
      { text: "Phone", value: "phone" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    clients: [],
    editedIndex: -1,
    selectedItem: {
      name: "",
   email:"",
          phone:"",
          address:"",
        
    },
    defaultItem: {
      name: "",
      email:"",
          phone:"",
          address:"",
        
    },
  }),
 mounted(){
   this.$bus.on('refresh',() => {
     this.GetClients();
   });
 },

  created() {
    this.GetClients();
  },

  methods: {
    async GetClients() {
      new Promise((resolve,reject) => {
        axios.get('clients').then(res => {
          this.clients = res.data; 
          resolve(res);
        }).catch(err =>{
          console.log(err);
          reject(err);
        } )
      })
    },

   async editItem(item) {
      this.editedIndex = this.clients.indexOf(item);
      this.selectedItem = Object.assign({}, item);
      this.dialogEdit = true;
    },
   async editItemConfirm(){
          console.log(this.selectedItem);
      new Promise((resolve,reject) => {
        axios.put(`clients/${this.selectedItem.id}`,this.selectedItem).then(res => {
          console.log('update successful');
          resolve(res);
        }).catch(err => {
          console.log(err);
          reject(err);
        })
      })
      this.close();
      this.GetClients();
    },
    viewItem(item) {
      this.editedIndex = this.clients.indexOf(item);
      this.selectedItem = Object.assign({}, item);
      this.dialogView = true;
    },

    deleteItem(item) {
      this.editedIndex = this.clients.indexOf(item);
      this.selectedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    async deleteItemConfirm() {
      new Promise((resolve,reject) => {
        axios.delete(`clients/${this.clients[this.editedIndex].id}`).then(res => {
          console.log("delete successful");
          this.GetClients();
          resolve(res);
        }).catch(err => {
          console.log(err);
          reject(err);
        })
      })
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.dialogEdit = false;
      this.dialogView = false;
      this.$nextTick(() => {
        this.selectedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.selectedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

   
  },
};
</script>