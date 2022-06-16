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
                  :items="
                    clients
                  "
                  item-text="name"
                  item-value="id"
                  label="Client"
                  @input="Printing(Transaction.client_id)"
                  name="Client"
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error">{{ errors.first('Client') }}</span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="Transaction.provider_id"
                  :items="
                    providers
                  "
                  item-text="name"
                  item-value="id"
                  label="Provider"
                  name="Provider"
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error">{{ errors.first('Provider') }}</span>
              </v-col>
            </v-row>
            <v-row
              class="addProduct"
              v-for="(product,index) in selectedProducts"
              :index="index"
              :key="index"
            >               
              <v-col cols="4">
                <v-select
                  v-model="product.product"
                  :items="[...availableProductsNames,selectedProducts[index]]"
                  label="product"
                  name="name"
                  item-text="name"
                  item-value="id"
                  hide-selected
                  return-object
                  @input="Printing(product.product)"
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error" v-show="errors.has('product')">{{ errors.first('product') }}</span>
              </v-col>
              <v-col cols="2">
                <v-text-field
                  v-model="product.quantity"
                  label="quantity"
                  name="quantity"
                  :min="0"
                  v-validate="`required|min_value:1 `"
                  type="number"
                >
                </v-text-field>
                <div  class="validation-error" v-show="product.quantity == null || product.quantity == 0  || product.quantity > getMaxQuantity(product)" >{{ errors.first('quantity') }}</div>
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
                <v-btn v-if="(selectedProducts.length >= 2)" @click="removeProduct(index)" color="red" dark small fab>
                  <v-icon small 
                    >mdi-minus</v-icon
                  >
                </v-btn>
                 <v-btn v-if="(index === (selectedProducts.length-1)) && (selectedProducts.length < products.length)" color="green" dark small fab @click="addProduct()">
                  <v-icon>mdi-plus</v-icon>
                </v-btn>
              </v-col>
 
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions class="Total-container">
          <h2 class="pl-4">total : <span class="bold">{{transactionTotal}}</span> DA</h2>
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
      products: [],
    },
    selectedProducts: [
      {
        product: null,
        quantity: 0,
      },
    ],
  }),

  async mounted() {
    // Getting All Clients

    new Promise((resolve, reject) => {
      axios
        .get("clients")
        .then((res) => {
          this.clients = res.data;
          console.log(this.clients);
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
          console.log(this.providers)  ;
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

    transactionTotal() {
      this.Transaction.total = this.selectedProducts
        .reduce((total, product) => {
          return (total += product.price * product.quantity);
        }, 0)
        .toFixed(2);
      return this.Transaction.total;
    },
  },

  methods: {
    Printing(product){
      console.log(product);
    },

    productTotal(product) {
      let total = product.price * product.quantity;
      return total.toFixed(2);
    },

    close() {
      this.dialogAdd = false;
    },

    addProduct() {
      this.selectedProducts.push({
        name,
        price: 0,
        quantity: 0,
      });
    },

    removeProduct(index) {
      this.selectedProducts.splice(index, 1);
    },

    async save() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.selectedProducts.forEach(selectedProduct=>{
            this.Transaction.products.push({
              product_id: selectedProduct.product.id,

            })
          })
          console.log(this.Transaction);
          new Promise((resolve, reject) => {
            axios
              .post("transactions", this.Transaction)
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




