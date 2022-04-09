<template>
  <v-container>
    <v-form v-for="store in this.stores" :key="store.id">
      <v-container>
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field v-model="store.name"></v-text-field> </v-col
          ><v-col cols="12" md="4">
            <v-text-field v-model="store.address"></v-text-field>
          </v-col>

          <v-col cols="12" md="4">
            <v-btn
              @click="update(store)"
              dark
              class="add-btn"
              color="primary"
              elevation="2"
            >
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn
              @click="remove(store.id)"
              dark
              class="add-btn"
              color="red darken-3"
              elevation="2"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data: () => {
    return {
      valid: true,
      stores: null,
    };
  },

  mounted() {
    this.getStores();
    this.$bus.on("refresh-stores", this.getStores);
  },

  methods: {
    // Getting all Stores
    async getStores() {
      new Promise((resolve, reject) => {
        axios
          .get("/stores")
          .then((res) => {
            this.stores = res.data;
            resolve(res);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    // Updating a store
    async update(store) {
      new Promise((resolve, reject) => {
        axios
          .put("stores", store)
          .then((res) => {
            this.getStores();
            resolve(res);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    // Delete a single store
    async remove(id) {
      new Promise((resolve, reject) => {
        axios
          .delete(`/store/${id}`)
          .then((res) => {
            this.getStores();
            resolve(res);
          })
          .catch((err) => {
            console.log(err);
            reject(err);
          });
      });
    },
  },
};
</script>

<style >
</style>