<template>
  <v-dialog v-model="dialogAdd" max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="green" dark class="mb-2" v-bind="attrs" v-on="on">
        <v-icon large>mdi-plus</v-icon>
      </v-btn>
    </template>
    <v-form @submit.prevent="save" id="addTransactionForm">
      <v-card>
        <v-card-title>
          <span class="text-h5">New Transaction</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="addedTransaction.client.name"
                  :items="
                    clients.map((client) => {
                      return client.name;
                    })
                  "
                  label="Client"
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="addedTransaction.provider.name"
                  :items="
                    providers.map((provider) => {
                      return provider.name;
                    })
                  "
                  label="Provider"
                ></v-select>
              </v-col>
            </v-row>
            <v-row
              class="addProduct"
              v-for="product in selectedProducts"
              :key="product.id"
            >
              <v-col v-if="product.name != ''" cols="4">
                <v-select
                  v-model="product.name"
                  :items="availableProductsNames.push()"
                  label="Product"
                  clearable
                  hide-selected
                ></v-select>
              </v-col>
              <v-col v-else cols="10">
                <v-select
                  v-model="product.name"
                  :items="availableProductsNames.push(this.products[gettingIndex(product)])"
                  label="Product"
                  hide-selected
                  @change="setProduct(product)"
                ></v-select>
              </v-col>
              <v-col v-if="product.name != ''" cols="3">
                <v-text-field
                  v-model="product.quantity"
                  label="quantity"
                  :min="0"
                  :max="product.maxQuantity"
                  type="number"
                >
                </v-text-field>
              </v-col>
              <v-col v-if="product.name != ''" cols="3">
                <v-text-field
                  label="total"
                  type="text"
                  readonly
                  :value="(product.quantity * product.price).toFixed(2)"
                >
                </v-text-field>
              </v-col>
              <v-col cols="2">
                <v-btn color="red" dark small rounded>
                  <v-icon x-small @click="removeProduct(product)"
                    >mdi-minus</v-icon
                  >
                </v-btn>
              </v-col>
            </v-row>
            <v-row v-if="this.products.length != this.selectedProducts.length">
              <v-col cols="12">
                <v-btn color="green" dark @click="addProduct()">
                  <v-icon>mdi-plus</v-icon>
                  add product
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions class="Total-container">
          <h2 class="pl-4">total :</h2>
          <div>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn
              type="submit"
              color="green darken-1"
              text
              form="addTransactionForm"
              >Save</v-btn
            >
          </div>
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
    clients: [],
    providers: [],
    products: [],
    addedTransaction: {
      client: {},
      provider: {},
    },
    selectedProducts: [],
  }),

  async mounted() {
    // Getting All Clients
    new Promise((resolve, reject) => {
      axios
        .get("clients")
        .then((res) => {
          this.clients = res.data;
          resolve(res);
        })
        .catch((err) => {
          console.log(err.response);
          reject(err);
        });
    });

    // Getting All Providers
    new Promise((resolve, reject) => {
      axios
        .get("providers")
        .then((res) => {
          this.providers = res.data;
          resolve(res);
        })
        .catch((err) => {
          console.log(err.response);
          reject(err);
        });
    });

    // Getting All Products
    new Promise((resolve, reject) => {
      axios
        .get("products")
        .then((res) => {
          this.products = res.data;
          console.log(this.products);
          resolve(res);
        })
        .catch((err) => {
          console.log(err.response);
          reject(err);
        });
    });
  },

  computed: {
    availableProductsNames() {
      return this.products.map((product) => {
        if (
          this.selectedProducts
            .map((el) => {
              return el.name;
            })
            .includes(product.name) === false
        ) {
          return product.name;
        }
      });
    },
  },

  methods: {
    gettingIndex(product) {
      return this.products.indexOf(product);
    },

    setProduct(product) {
      let itemIndex = this.selectedProducts.indexOf(product);
      this.selectedProducts[itemIndex].name = product.name;
      this.selectedProducts[itemIndex].maxQuantity = this.products.find(
        (item) => {
          return item.name === product.name;
        }
      ).quantity;
      this.selectedProducts[itemIndex].price = this.products.find((item) => {
        return item.name == product.name;
      }).price;
      console.log(this.selectedProducts);
    },

    close() {
      this.dialogAdd = false;
    },

    addProduct() {
      this.selectedProducts.push({
        name: "",
        price: 0,
        quantity: 0,
        maxQuantity: 0,
      });
    },

    removeProduct(item) {},

    async save() {
      console.log(this.addedTransaction);
    },
  },
};
</script>

<style scoped>
.addProduct {
  align-items: center;
}

.Total-container {
  width: 100%;
  display: flex;
  justify-content: space-between;
}

.validation-error {
  color: #f00;
}
</style>