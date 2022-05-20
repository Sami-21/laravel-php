<template>
  <v-dialog v-model="dialogEdit" max-width="500px">
    <v-form @submit.prevent="confirmEdit" id="UpdateClientForm">
      <v-card>

        <v-card-title>
          <span class="text-h5">Edit Transaction</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                 <v-select
          :items="items"
          label="Client"
        ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                 <v-select
          :items="items"
          label="Provider"
        ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                 <v-select
          :items="items"
          label="Product"
        ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn type="submit" color="green darken-1" text form="UpdateClientForm">Save</v-btn>
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
    close: { type: Function }
  },

  data(){
    return {
      newClient:{},
      items:['1','2','3','4'],
    }
  },

  mounted(){
      this.setNewClient();
  },

  methods: {

    setNewClient(){
      this.newClient = Object.assign({}, this.newClient, this.current)
    },

    async confirmEdit() {
        this.$validator.validateAll().then(result => {
        if(result){
          new Promise((resolve, reject) => {
        axios
          .put(`clients/${this.current.id}`, this.newClient)
          .then(res => {
            this.$bus.emit("edit", this.client);
            this.close();
            resolve(res);
          })
          .catch(err => {
            console.log(err);
            this.close();
            reject(err);
          });
      });
        }
      })
    },

  }
};
</script>
<style scoped>
.validation-error{
  color:#f00;
}
</style>