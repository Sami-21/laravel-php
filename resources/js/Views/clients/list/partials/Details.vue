<template>
    
        <v-dialog v-model="dialogView" max-width="500px">
         
          <v-card>
            <v-card-title>
              <span class="text-h5">client info</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-account</v-icon>

                     name : {{selectedItem.name}}
                      
                      
                    </h1>
                  </v-row>
                  <v-row>

                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-email</v-icon>
                      email : {{selectedItem.email}}
                    </h1>
                  </v-row>
                  <v-row>
                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-phone</v-icon>
                      phone : {{selectedItem.phone}}                      
                    </h1>
                  </v-row>
                  <v-row>
                    <h1 class="text-black my-2">
                  <v-icon class="mr-4">mdi-map-marker</v-icon>
                  address : {{selectedItem.address}}
                    </h1>

                  </v-row>
                  
                <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> close </v-btn>
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
        selectedItem:Object,
        close:{type:Function},
    },
    data:() => ({
    }),
    methods:{
    
    
    }

}
</script>