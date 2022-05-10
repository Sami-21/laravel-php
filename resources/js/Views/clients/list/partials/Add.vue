<template>
  <v-dialog v-model="dialogOption" max-width="500px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item</v-btn>
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
                <v-text-field v-model="AddedItem.name" name="name" label="name" required></v-text-field>
                <span>{{ errors.first("name") }}</span>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="AddedItem.email"
                  v-validate="'email'"
                  name="email"
                  label="email"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="AddedItem.phone"
                  v-validate="'numeric'"
                  name="phone"
                  label="phone"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="AddedItem.address"
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
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn type="submit" color="blue darken-1" text form="AddClientForm">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>
<script>
import axios from "axios";

export default {
  props: {
    dialog: { type: Boolean },
    close: { type: Function }
  },
  data: () => ({
    dialogOption:false,
    AddedItem: {
      name: "",
      email: "",
      phone: "",
      address: ""
    }
  }),
  methods: {
    async save() {
      new Promise((resolve, reject) => {
        axios
          .post("clients", this.AddedItem)
          .then(res => {
            this.close();
            this.$bus.emit("refresh", this.AddedItem);
            resolve(res);
          })
          .catch(err => {
            console.log(this.AddedItem);
            console.log(err);
            reject(err);
          });
      });
    }
  }
};
</script>

<style>
</style>