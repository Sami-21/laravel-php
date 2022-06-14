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
                  v-model="addedTransaction.client_id"
                  :items="
                    clients
                  "
                  item-text="name"
                  item-value="id"
                  label="Client"
                  name="Client"
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error">{{ errors.first('Client') }}</span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="addedTransaction.provider_id"
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
               
              </v-col>
              <v-col cols="4">
                <v-select
                  v-model="product.name"
                  :items="[...availableProductsNames,selectedProducts[index]]"
                  label="product"
                  name="product"
                  item-text="name"
                  @input="setProductPrice(product) ;setProductID(product)"
                  hide-selected
                  v-validate="'required'"
                ></v-select>
                <span class="validation-error">{{ errors.first('product') }}</span>
              </v-col>
              <v-col cols="2">
                <v-text-field
                  v-model="product.quantity"
                  label="quantity"
                  name="quantity"
                  :min="0"
                  :max="maxProductQuantity(product) || product.maxQuantity"
                  v-validate="'required|min_value:1'"
                  type="number"
                >
                </v-text-field>
                <span  class="validation-error">{{ errors.first('quantity') }}</span>
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
    addedTransaction: {
      client_id: {},
      provider_id: {},
      total:0,
      products:[],
    },
    selectedProducts: [{
        product_id:0,
        name,
        price: 0,
        quantity: 0,
        maxQuantity: 0,
      }],

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
        this.addedTransaction.total = this.selectedProducts.reduce((total , product) => {
         return total+= product.price * product.quantity
       } ,0).toFixed(2);
       return  this.addedTransaction.total;
    },
   
  },
 

  methods: {

    gettingSelectedProduct(product) {
      if (product) {
        return this.products.find((element) => {
          return element.name === product.name;
        }).name;
      } else {
        return;
      }
    },

   maxProductQuantity(product){
     if(product.name != ''){
        return this.products.find(element => {
        return product.name === element.name
      }).quantity;
     }
    },

  setProductID(product){
      if(product.name != ''){
        product.id = this.products.find(element => {
        return product.name === element.name
      }).id;
      product.quantity = 0;
     }
    },
    setProductPrice(product){
      if(product.name != ''){
        product.price = this.products.find(element => {
        return product.name === element.name
      }).price;
     }
    },

     productTotal(product){
      let total = product.price * product.quantity;
        return total.toFixed(2);
    },

    close() {
      this.dialogAdd = false;
    },

    addProduct() {
      this.selectedProducts.push({
        product_id:0,
        name,
        price: 0,
        quantity: 0,
        maxQuantity: 0,
      });
    },

    removeProduct(index) {
      this.selectedProducts.splice(index,1);
    },

    async save() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.addedTransaction.products = this.selectedProducts;
            new Promise((resolve, reject) => {
          axios
        .post("transactions" , this.addedTransaction )
        .then((res) => {
          console.log(this.addedTransaction);
          resolve(res);
        })
        .catch((err) => {
          console.log(err.response);
          reject(err);
        });
    })
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
  font-size:10px;
}

.product-btns{
  width:100%;
  height:100%;
  display:flex;
  align-items:center;
  justify-content:space-around;
}

.bold{
  font-weight:bold;
}

</style>