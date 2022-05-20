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
                     <h1 class="text-black ">
                     {{this.client.name}}                      
                    </h1>
                  </v-col> 
                  <v-col>
                     <h1 class="text-black  TL">
                      {{this.provider.name}}                      
                    </h1>
                  </v-col>
                  </v-row>

                 <v-row>
                 
                  <v-col>
                     <h1 class="text-black ">
                      {{this.client.email}}                      
                    </h1>
                  </v-col>
                  <v-col>
                     <h1 class="text-black  TL">
                      {{this.provider.email}}                      
                    </h1>
                  </v-col>
                  </v-row>
                   <v-row>
                  <v-col>
                     <h1 class="text-black ">
                     {{this.client.phone}}                      
                    </h1>
                  </v-col>
                  <v-col>
                     <h1 class="text-black  TL">
                     {{this.provider.phone}}                      
                    </h1>
                  </v-col>
                  </v-row>
                  
                  <v-row>
  <v-simple-table class="products-container">
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            Product
          </th>
          <th class="text-left">
            Price
          </th>
          <th class="text-left">
            Quantity
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in products"
          :key="item.name"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.price }} $</td>
          <td>{{ item.quantity }}</td>
        </tr>
        <tr>
          <td></td>
          <td>total : </td>
          <td> {{productsTotal}} $</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
                  </v-row>

                <v-card-actions class="btn-container">
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> close </v-btn>
              <v-btn color="orange darken-1" text >
                 print 
                 <v-icon class="file-icon" color="orange darken-1" small>mdi-file-outline</v-icon>
                 </v-btn>
            </v-card-actions>
            
              </v-container>
            </v-card-text>    
          </v-card>          
        </v-dialog>
</template>

<script>

import axios from 'axios';

export default {
    props:{
        dialogView:Boolean,
        item:Object,
        close:{type:Function},
    },
    data:() => ({
      client:{
        name:"sami",
        email:'sami@sami.com',
        phone:'+213999999999'
      },
      provider:{
        name:"test",
        email:'test@test.com',
        phone:'+213999999999'
      },
      products:[
        {name:'product1',price:10,quantity:10},
        {name:'product2',price:20,quantity:10},
        {name:'product3',price:30,quantity:10},
        {name:'product4',price:40,quantity:10},
        {name:'product5',price:50,quantity:10}
      ]
    }),
    computed:{
      productsTotal(){
        return this.products.reduce((total , currentProduct) => {
          return total + (currentProduct.price * currentProduct.quantity);
        },0);
      },

    },
}
</script>

<style scoped>
.TL{
  text-align:right;
}
.file-icon{
  position:relative;
  bottom:1px;
  left:4px;  
}
.products-container{
  width:100%;
}
.btn-container{
  position:relative;
  top:25px;
}

</style>