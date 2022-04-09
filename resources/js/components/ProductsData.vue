<template>
  <v-form v-model="valid">
    <v-container>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="ProuctName"
            :rules="PtoductNameRules"
            label="Product Name"
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="Quantity"
            :rules="QuantityRules"
            label="Quantity"
            required
          ></v-text-field>
        </v-col>

        <v-col cols="8" md="3">
          <v-text-field
            v-model="Price"
            :rules="emailRules"
            label="Price"
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-btn dark class="add-btn" color="green" elevation="2">
            <v-icon>mdi-pencil</v-icon>
          </v-btn>
          <v-btn dark class="add-btn" color="green" elevation="2">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
export default {
  data: () => ({
    valid: false,
    id: "",
    StoreName: "",
    StoreAddress: "",
    StoreNameRules: [
      (v) => !!v || "Store Name is required",
      (v) => v.length >= 3 || "Store Name must be atleast 3 characters",
    ],
    StoreAddressRules: [
      (v) => !!v || "Store Name is required",
      (v) => v.length >= 3 || "Store Name must be atleast 3 characters",
    ],
  }),
};
</script>

<style >
</style>