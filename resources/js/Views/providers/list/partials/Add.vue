<template>
  <v-dialog v-model="dialogAdd" max-width="500px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="green" dark class="mb-2" v-bind="attrs" v-on="on">
        <v-icon large>mdi-plus</v-icon>
      </v-btn>
    </template>
    <v-form @submit.prevent="save" id="AddProviderForm">
      <v-card>
        <v-card-title>
          <span class="text-h5">New Provider</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="AddedItem.name"
                  name="name"
                  label="name"
                  v-validate="'alpha_spaces|required'"
                ></v-text-field>
                <span class="validation-error">{{ errors.first('name') }}</span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="AddedItem.email"
                  name="email"
                  label="email"
                  v-validate="'required|email'"
                ></v-text-field>
                <span class="validation-error">{{ errors.first('email') }}</span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="AddedItem.phone"
                  v-validate="{ required: true, regex:/^(00213|\+213|0)(5|6|7)[0-9]{8}$/ }"
                  name="phone"
                  label="phone"
                ></v-text-field>
                <span class="validation-error">{{ errors.first('phone') }}</span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="AddedItem.address"
                  v-validate="'required'"
                  name="address"
                  label="address"
                ></v-text-field>
                <span class="validation-error">{{ errors.first('address') }}</span>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn type="submit" color="green darken-1" text form="AddProviderForm">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>
<script>
import axios from "axios";

export default {
  data: () => ({
    dialogAdd: false,
    AddedItem: {
      name: "",
      email: "",
      phone: "",
      address: ""
    }
  }),

  methods: {
    async save() {
      this.$validator.validateAll().then(result => {
        if (result) {
          new Promise((resolve, reject) => {
            axios
              .post("providers", this.AddedItem)
              .then(res => {
                this.close();
                this.AddedItem={};
                this.$bus.emit("add", this.AddedItem);
                resolve(res);
              })
              .catch(err => {
                console.log(err);
                reject(err);
              });
          });
        }
      });
    },

    close() {
      this.dialogAdd = false;
    }
  }
};
</script>

<style scoped>
.validation-error {
  color: #f00;
}
</style>