<template>
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
                <v-text-field v-model="selectedItem.name" name="name" label="name" required></v-text-field>
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
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn type="submit" color="blue darken-1" text form="UpdateClientForm">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>
<script>
import axios from "axios";

export default {
  props: {
    dialogEdit: Boolean,
    selectedItem: Object,
    close: { type: Function }
  },
  data: () => ({}),
  methods: {
    async editItemConfirm() {
      console.log(this.selectedItem);
      new Promise((resolve, reject) => {
        axios
          .put(`clients/${this.selectedItem.id}`, this.selectedItem)
          .then(res => {
            console.log("update successful");
            this.$bus.emit("refresh", this.selectedItem);
            resolve(res);
          })
          .catch(err => {
            console.log(err);
            reject(err);
          });
      });
      this.close();
    }
  }
};
</script>