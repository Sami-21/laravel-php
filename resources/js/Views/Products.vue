<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-text-field
        v-model="Name"
        :rules="NameRules"
        label="Product Name"
        required
      ></v-text-field>

      <v-text-field
        v-model="Quantity"
        :rules="QuantityRules"
        label="Quantity"
        required
      ></v-text-field>
      <v-text-field
        v-model="Price"
        :rules="PriceRules"
        label="Price"
        required
      ></v-text-field>

      <v-select
        v-model="ProductStore"
        :items="this.stores"
        :rules="[(v) => !!v || 'store is required']"
        label="store"
        required
      ></v-select>

      <v-btn
        :disabled="!valid"
        reverse
        color="success"
        class="mr-4"
        @click="submit"
      >
        add products
      </v-btn>
    </v-form>
    <Products-Data v-bind:availableStores='stores'></Products-Data>
  </v-container>
</template>


<script>
import ProductsData from "../components/ProductsData.vue";
import axios from "axios";

export default {
  components: { ProductsData },
  async mounted() {
    new Promise((reject, resolve) => {
      axios
        .get("stores")
        .then((res) => {
          this.stores = res.data.map((item) => item.name);
          resolve(res);
        })
        .catch((err) => {
          reject(err);
        });
    });
  },
  data: () => ({
    stores: [],
    valid: true,
    Name: "",
    NameRules: [
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
    ProductStore: "",
  }),

  methods: {
    async submit() {
      new Promise((resolve, reject) => {
        axios
          .post("products", {
            name: this.Name,
            quantity: this.Quantity,
            price: this.Price,
            store: this.ProductStore,
          })
          .then((res) => {
            this.$bus.emit("refresh-products");
            this.Name = "";
            this.Quantity = "";
            this.Price = "";
            this.ProductStore = "";
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },
  },
};
</script>
<style>
.add-btn {
  position: relative;
  top: 15px;
  left: 15px;
}
</style>