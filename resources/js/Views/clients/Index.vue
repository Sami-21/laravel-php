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
        <v-dialog v-model="dialog" max-width="500px">

          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New Item
            </v-btn>
          </template>
                  <v-form @submit.prevent="save" id="AddClientForm">

          <v-card>
            <v-card-title>
              <span class="text-h5">New Client</span>
            </v-card-title>

            <v-card-text>
              <v-container>

                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.name"
                      name='name'
                      label="name"
                      required
                    ></v-text-field>
                    <span>{{ errors.first('name') }}</span>

                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.email"
                        v-validate="'email'" 
                        name="email"
                      label="email"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.phone"
                        v-validate="'numeric'" 
                        name="phone"
                      label="phone"
                      required

                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.address"
                        v-validate="'alpha'" 
                        name="address"
                      label="address"
                      required

                    ></v-text-field>
                  </v-col>
                </v-row>

              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn type="submit" color="blue darken-1" text form="AddClientForm"> Save </v-btn>
            </v-card-actions>
          </v-card>
                  </v-form>
          
        </v-dialog>







            <v-dialog v-model="dialogEdit" max-width="500px">
                  <v-form @submit.prevent="editItemConfirm" id="UpdateClientForm">

          <v-card>
            <v-card-title>
              <span class="text-h5">Edit Client</span>
            </v-card-title>

            <v-card-text>
              <v-container>

                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.name"
                      name='name'
                      label="name"
                      required
                    ></v-text-field>
                    <span>{{ errors.first('name') }}</span>

                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.email"
                        v-validate="'email'" 
                        name="email"
                      label="email"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.phone"
                        v-validate="'numeric'" 
                        name="phone"
                      label="phone"
                      required

                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="selectedItem.address"
                        v-validate="'alpha'" 
                        name="address"
                      label="address"
                      required

                    ></v-text-field>
                  </v-col>
                </v-row>

              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn type="submit" color="blue darken-1" text form="UpdateClientForm"> Save </v-btn>
            </v-card-actions>
          </v-card>
                  </v-form>
          
        </v-dialog>





        <v-dialog v-model="dialogView" max-width="500px">
         
          <v-card>
            <v-card-title>
              <span class="text-h5">client info</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-account</v-icon>

                     name : {{selectedItem.name}}
                      
                      
                    </h1>
                  </v-row>
                  <v-row>

                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-email</v-icon>
                      email : {{selectedItem.email}}
                    </h1>
                  </v-row>
                  <v-row>
                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-phone</v-icon>
                      phone : {{selectedItem.phone}}                      
                    </h1>
                  </v-row>
                  <v-row>
                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-map-marker</v-icon>
                  address : {{selectedItem.address}}
                    </h1>

                  </v-row>
                  
                <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> close </v-btn>
            </v-card-actions>
              </v-container>
            </v-card-text>

        
          </v-card>
          
        </v-dialog>
        
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
import axios from 'axios';
export default {
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
    clientsNames:[],
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
 

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    async initialize() {
      new Promise((resolve,reject) => {
        axios.get('clients').then(res => {
          this.clients = res.data; 
          resolve(res);
        }).catch(err =>{
          console.log(err);
          reject(err);
        } )
      })
     
      this.clientsNames=this.clients.map((el) => {return el.name});
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
      this.initialize();
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
          resolve(res);
        }).catch(err => {
          console.log(err);
          reject(err);
        })
      })
      this.clients.splice(this.editedIndex, 1);
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

    async save() {
     new Promise((resolve, reject) => {
       axios.post('clients',this.selectedItem).then(res => {
         this.close();
         resolve(res);
       }).catch(err => {
         console.log(this.selectedItem);
         console.log(err);
         reject(err);
       })
     })
    },
  },
};
</script>