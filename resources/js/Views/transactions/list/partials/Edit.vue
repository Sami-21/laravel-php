<template>
  <v-dialog v-model="dialogEdit" max-width="600px">
    <v-form @submit.prevent="saveTransaction" id="addtransactionForm">
      <v-card>
        <v-card-title>
          <span class="text-h5">Edit Transaction</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="transaction.client_id"
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
                  v-model="transaction.provider_id"
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
              v-for="(product, index) in transaction.products"
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
                    `required|min_value:1|max_value:${productMaxQuantity(
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
                    product.quantity > product.product.maxQuantity
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
                  v-if="transaction.products.length > 1"
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
                    index === transaction.products.length - 1 &&
                    transaction.products.length < products.length
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
              form="addtransactionForm"
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
  props: {
    dialogEdit: Boolean,
    current: Object,
    close: { type: Function },
  },
  data: () => ({
    clients: [],
    providers: [],
    products: [],
    transaction: {
      client_id: null,
      provider_id: null,
      total: 0,
      products: [],
    },
  }),

  created() {
    this.getClients();

    this.getProviders();

    this.getProducts();

    this.initializeTransaction();
  },

  computed: {
    availableProducts() {
      return this.products.filter((product) => {
        return !this.transaction.products.find((transactionProduct) => {
          if (transactionProduct.product)
            return product.name === transactionProduct.product.name;
        });
      });
    },

    transactionTotal() {
      this.transaction.total = parseFloat(
        this.transaction.products.reduce((total, product) => {
          if (product.product) {
            return (total += product.product.price * product.quantity);
          } else {
            return 0;
          }
        }, 0)
      ).toFixed(2);

      return this.transaction.total;
    },
  },

  methods: {
    initializeTransaction() {
      this.transaction.client_id = this.current.client_id;
      this.transaction.provider_id = this.current.provider_id;
      this.transaction.total = this.current.total;
      this.current.products.forEach((product) => {
        this.transaction.products.push({
          product: {
            id: product.id,
            name: product.name,
            price: product.price,
            maxQuantity: product.quantity,
          },
          quantity: product.pivot.quantity,
        });
      });
    },

    async getClients() {
      // Getting All Clients

      return new Promise((resolve, reject) => {
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

      return new Promise((resolve, reject) => {
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

      return new Promise((resolve, reject) => {
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

    productMaxQuantity(product) {
      if (product) {
        return product.maxQuantity;
      } else {
        return 0;
      }
    },

    availableProductsList(index) {
      return [
        ...this.availableProducts,
        this.transaction.products[index].product,
      ];
    },

    productTotal(product) {
      if (product.product) {
        let total = product.product.price * product.quantity;
        return total.toFixed(2);
      } else {
        return 0;
      }
    },

    addProduct() {
      this.transaction.products.push({
        product: null,
        quantity: 0,
      });
    },

    removeProduct(index) {
      this.transaction.products.splice(index, 1);
    },

    async saveTransaction() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          console.log(this.transaction);
          let newProducts = [];
          this.transaction.products.forEach((product) => {
            newProducts.push({
              product_id: product.id,
              price: parseFloat(product.price),
              quantity: product.quantity,
            });
          });

          new Promise((resolve, reject) => {
            axios
              .put("/transactions", {
                client_id: this.transaction.client_id,
                provider_id: this.transaction.provider_id,
                total: this.transaction.total,
                products: newProducts,
              })
              .then((res) => {
                this.closeDialog();
                this.transaction = {};
                this.$bus.emit("edit", this.transaction);
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




