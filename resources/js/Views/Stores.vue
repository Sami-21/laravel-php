<template>
  <v-container>
    <v-form v-model="valid">
      <v-container>
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="name"
              :rules="StoreNameRules"
              label="Store name"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field
              v-model="address"
              :rules="StoreAddressRules"
              label="store address"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="12" md="4">
            <v-btn
              dark
              @click="submit"
              class="add-btn"
              color="green"
              elevation="2"
            >
              <v-icon>mdi-plus</v-icon>
              add store</v-btn
            >
          </v-col>
        </v-row>
      </v-container>
    </v-form>
    <Stores-Data></Stores-Data>
  </v-container>
</template>
<script>
import StoresData from "../components/StoresData.vue";
import axios from "axios";

export default {
  components: { StoresData },

  methods: {
    async submit() {
      new Promise((resolve, reject) => {
        axios
          .post("stores", {
            name: this.name,
            address: this.address,
          })
          .then((res) => {
            this.$bus.emit("refresh-stores");
            this.name = "";
            this.address = "";
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },
  },
  data: () => ({
    valid: false,
    name: "",
    address: "",

    StoreNameRules: [
      (v) => !!v || "Store name is required",
      (v) => v.length >= 3 || "Name must be more than 2 characters",
    ],
    StoreAddressRules: [
      (v) => !!v || "Store address is required",
      (v) => v.length >= 5 || "address must be more than 4 characters",
    ],
  }),
};
</script>

<style>
.add-btn {
  position: relative;
  top: 15px;
  left: 15px;
}
</style>