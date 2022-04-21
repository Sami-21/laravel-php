<template>
  <v-container>
    <v-form v-for="product in this.products" :key="product.id">
      <v-container>
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="product.name"
              :rules="ProductNameRules"
              label="Product Name"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field
              v-model="product.quantity"
              :rules="QuantityRules"
              label="Quantity"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="6" md="2">
            <v-text-field
              v-model="product.price"
              :rules="PriceRules"
              label="Price"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="6" md="2">
            <v-select
              v-model="product.store"
              :items="availableStores"
              :rules="[(v) => !!v || 'Item is required']"
              label="Item"
              required
            ></v-select>
          </v-col>

          <v-col cols="12" md="4">
            <v-btn
              @click="updateProduct(product)"
              dark
              class="add-btn"
              color="primary"
              elevation="2"
            >
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn
              @click="removeProduct(product.id)"
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
  props: {
    availableStores: {
      type: Array,
    },
  },
  methods: {
    async getProducts() {
      new Promise((resolve, reject) => {
        axios
          .get("products")
          .then((res) => {
            this.products = res.data;
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
            s;
          });
      });
    },
    async removeProduct(id) {
      new Promise((resolve, reject) => {
        axios
          .delete(`product/${id}`)
          .then((res) => {
            this.$bus.emit("refresh-products");
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },
    async updateProduct(product) {
      new Promise((resolve, reject) => {
        axios
          .put(`products`, product)
          .then((res) => {
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },
  },
  mounted() {
    this.getProducts();
    this.$bus.on("refresh-products", this.getProducts);
  },
  data: () => ({
    products: null,
    valid: true,
    ProuctName: "",
    ProductNameRules: [
      (v) => !!v || "Product Name is required",
      (v) => (v && v.length >= 3) || "Product Name must atleast 3 characters",
    ],
    Quantity: "",
    QuantityRules: [
      (v) => !!v || "Quantity is required",
      (v) => v > 0 || "Quantity must be valid",
    ],
    Price: "",
    PriceRules: [
      (v) => !!v || "Price is required",
      (v) => v > 0 || "Price must be valid",
    ],
  }),
};
</script>

<style >
</style>