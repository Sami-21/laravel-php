<template>
  <v-dialog v-model="dialogView" max-width="600px">
    <v-card>
      <v-card-title>
        <span class="text-h5">Transaction Details</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col>
              <h1 class="text-black">
                {{ this.item.client.name }}
              </h1>
            </v-col>
            <v-col>
              <h1 class="text-black TL">
                {{ this.item.provider.name }}
              </h1>
            </v-col>
          </v-row>

          <v-row>
            <v-col>
              <h1 class="text-black">
                {{ this.item.client.email }}
              </h1>
            </v-col>
            <v-col>
              <h1 class="text-black TL">
                {{ this.item.provider.email }}
              </h1>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <h1 class="text-black">
                {{ this.item.client.phone }}
              </h1>
            </v-col>
            <v-col>
              <h1 class="text-black TL">
                {{ this.item.provider.phone }}
              </h1>
            </v-col>
          </v-row>

          <v-row>
            <v-simple-table class="products-container">
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Product</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in item.products" :key="index">
                    <td>{{ item.name }}</td>
                    <td>{{ item.price }} DA</td>
                    <td>{{ item.pivot.quantity }}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>total :</td>
                    <td class="bold">{{ productsTotal }} DA</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-row>

          <v-card-actions class="btn-container">
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close"> close </v-btn>
            <v-btn color="orange darken-1" text>
              print
              <v-icon class="file-icon" color="orange darken-1" small
                >mdi-file-outline</v-icon
              >
            </v-btn>
          </v-card-actions>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    dialogView: Boolean,
    item: Object,
    close: { type: Function },
  },

  data(){
    return {
      
    }
  },

  computed: {
    productsTotal() {
      return this.item.products.reduce((total, currentProduct) => {
        return total + currentProduct.price * currentProduct.pivot.quantity;
      }, 0);
    },
  },
};
</script>

<style scoped>
.TL {
  text-align: right;
}
.file-icon {
  position: relative;
  bottom: 1px;
  left: 4px;
}
.bold{
  font-weight:bold;
}
.products-container {
  width: 100%;
}
.btn-container {
  position: relative;
  top: 25px;
}
</style>