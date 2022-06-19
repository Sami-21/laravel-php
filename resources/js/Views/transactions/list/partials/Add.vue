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
                  v-model="Transaction.client_id"
                  :items="clients"
                  item-text="name"
                  item-value="id"
                  label="Client"
                  name="Client"
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error">{{
                  errors.first("Client")
                }}</span>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="Transaction.provider_id"
                  :items="providers"
                  item-text="name"
                  item-value="id"
                  label="Provider"
                  name="Provider"
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error">{{
                  errors.first("Provider")
                }}</span>
              </v-col>
            </v-row>

            <v-row
              class="addProduct"
              v-for="(product, index) in Transaction.products"
              :index="index"
              :key="index"
            >
              <v-col cols="4">
                <v-select
                  v-model="product.product"
                  :items="availableProductsList(index)"
                  label="product"
                  name="name"
                  item-text="name"
                  hide-selected
                  return-object
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error" v-show="errors.has('product')">{{
                  errors.first("product")
                }}</span>
              </v-col>

              <v-col cols="2">
                <v-text-field
                  v-model="product.quantity"
                  label="quantity"
                  name="quantity"
                  :disabled="product.product == null"
                  :min="0"
                  v-validate="
                    `required|min_value:1|max_value:${maxQuantity(
                      product.product
                    )}`
                  "
                  type="number"
                >
                </v-text-field>
                <span
                  class="validation-error"
                  v-show="
                    product.quantity == null ||
                    product.quantity == 0 ||
                    product.quantity > product.product.quantity
                  "
                >
                  {{ errors.first("quantity") }}
                </span>
              </v-col>

              <v-col cols="3">
                <v-text-field
                  label="total"
                  type="text"
                  readonly
                  :value="`${productTotal(product)} DA`"
                >
                </v-text-field>
              </v-col>

              <v-col class="product-btns" cols="3">
                <v-btn
                  v-if="Transaction.products.length >= 2"
                  @click="removeProduct(index)"
                  color="red"
                  dark
                  small
                  fab
                >
                  <v-icon>mdi-minus</v-icon>
                </v-btn>
                <v-btn
                  v-if="
                    index === Transaction.products.length - 1 &&
                    Transaction.products.length < products.length
                  "
                  color="green"
                  dark
                  small
                  fab
                  @click="addProduct()"
                >
                  <v-icon>mdi-plus</v-icon>
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions class="Total-container">
          <h2 class="pl-4">
            total : <span class="bold">{{ transactionTotal }}</span> DA
          </h2>
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
    Transaction: {
      client_id: null,
      provider_id: null,
      total: 0,
      products: [
        {
          product: null,
          quantity: 0,
        },
      ],
    },
  }),

  mounted() {
    this.getClients();

    this.getProviders();

    this.getProducts();
  },

  computed: {
    availableProducts() {
      return this.products.filter((product) => {
        let SelectedProducts = this.Transaction.products.map((el) => {
          if (el.product) {
            return el.product;
          }
        });

        return !SelectedProducts.includes(product);
      });
    },

    transactionTotal() {
      this.Transaction.total = parseFloat(
        this.Transaction.products.reduce((total, product) => {
          if (product.product) {
            // is not null
            return (total += product.product.price * product.quantity);
          } else {
            return 0;
          }
        }, 0)
      ).toFixed(2);

      return this.Transaction.total;
    },
  },

  methods: {
    async getClients() {
      // Getting All Clients

      new Promise((resolve, reject) => {
        axios
          .get("/clients")
          .then((res) => {
            this.clients = res.data;
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },

    async getProviders() {
      // Getting All Providers

      new Promise((resolve, reject) => {
        axios
          .get("/providers")
          .then((res) => {
            this.providers = res.data;
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },

    async getProducts() {
      // Getting All Products

      new Promise((resolve, reject) => {
        axios
          .get("/products")
          .then((res) => {
            this.products = res.data;
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },

    availableProductsList(index) {
      return [
        ...this.availableProducts,
        this.Transaction.products[index].product,
      ];
    },

    maxQuantity(product) {
      if (product) {
        return product.quantity;
      }
    },

    productTotal(product) {
      if (product.product) {
        let total = product.product.price * product.quantity;
        return total.toFixed(2);
      } else {
        return 0;
      }
    },

    close() {
      this.dialogAdd = false;
    },

    addProduct() {
      this.Transaction.products.push({
        product: null,
        quantity: 0,
      });
    },

    removeProduct(index) {
      this.Transaction.products.splice(index, 1);
    },

    async save() {
      let products = [];
      this.Transaction.products.forEach((product) => {
        products.push({
          product_id: product.product.id,
          price: parseFloat(product.product.price),
          quantity: product.quantity,
        });
      });

      this.$validator.validateAll().then((result) => {
        if (result) {
          console.log(
            this.Transaction.client_id,
            this.Transaction.provider_id,
            this.Transaction.total,
            products
          );
          new Promise((resolve, reject) => {
            axios
              .post("/transactions", {
                client_id: this.Transaction.client_id,
                provider_id: this.Transaction.provider_id,
                total: this.Transaction.total,
                products: products,
              })
              .then((res) => {
                console.log("data", res);
                resolve(res);
              })
              .catch((err) => {
                console.log(err.response);
                reject(err);
              });
          });
        }
      });
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
  font-size: 10px;
}

.product-btns {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-around;
}

.bold {
  font-weight: bold;
}
</style>




