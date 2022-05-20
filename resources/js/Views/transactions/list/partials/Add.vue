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
                  v-model="addedItem.client.name"
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
                  v-model="addedItem.provider.name"
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
              v-for="product in addedProducts"
              :key="product.key"
            >
              <v-col cols="4">
                <v-select
                  v-model="product.name"
                  :items="availableProducts"
                  label="Product"
                ></v-select>
              </v-col>
              <v-col cols="3">
                <v-text-field
                  v-model="product.quantity"
                  label="quantity"
                  :min="0"
                  :max="10"
                  type="number"
                >
                </v-text-field>
              </v-col>
              <v-col cols="3">
                <v-text-field label="total" type="text" readonly :value="100">
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
            <v-row v-if="this.products.length != this.addedProducts.length">
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
    addedItem: {
      client: {},
      provider: {},
    },
    key: 0,
    addedProducts: [],
    availableProducts: [],
    emptyProduct: {
      key: 0,
      name: "",
      price: 0,
      quantity: 0,
    },
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
          this.availableProducts = res.data.map((product) => {
            return product.name;
          });
          console.log(this.products);
          resolve(res);
        })
        .catch((err) => {
          console.log(err.response);
          reject(err);
        });
    });
  },
  // computed:{
  //   availableProducts(){

  //   },
  // },
  methods: {
    async save() {
      console.log(this.addedItem);
      // this.$validator.validateAll().then(result => {
      //   if (result) {
      //     new Promise((resolve, reject) => {
      //       axios
      //         .post("transactions", this.addedItem)
      //         .then(res => {
      //           this.close();
      //           this.addedItem={};
      //           this.$bus.emit("add", this.addedItem);
      //           resolve(res);
      //         })
      //         .catch(err => {
      //           console.log(err);
      //           reject(err);
      //         });
      //     });
      //   }
      // });
    },
    setProduct(product) {},
    close() {
      this.dialogAdd = false;
    },
    addProduct() {
      this.addedProducts.push({
        key: this.key,
        name: "",
        price: 0,
        quantity: 0,
      });
      this.key++;
      console.log(this.addedProducts);
    },
    removeProduct(item) {
      let itemIndex = this.addedProducts.indexOf(item);
      console.log(itemIndex);
      this.addedProducts.splice(itemIndex, 1);
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