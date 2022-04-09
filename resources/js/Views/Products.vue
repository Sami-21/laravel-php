<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-text-field
        v-model="ProuctName"
        :rules="PtoductNameRules"
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
        :rules="emailRules"
        label="Price"
        required
      ></v-text-field>

      <v-select
        v-model="select"
        :items="items"
        :rules="[(v) => !!v || 'Item is required']"
        label="Item"
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
    <Products-Data></Products-Data>
  </v-container>
</template>


<script>
import ProductsData from "../components/ProductsData.vue";

export default {
  components: { ProductsData },
  data: () => ({
    items: ["test1", "test2", "test3"],
    valid: true,
    ProuctName: "",
    PtoductNameRules: [
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

  methods: {
    submit() {
      console.log("form submitted");
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