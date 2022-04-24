<template>
  <v-app>
    <!-- <div class="navbar">
      <router-link to="/stores">
        <v-btn color="primary" elevation="3" small>Add Stores</v-btn>
      </router-link>
      <router-link to="/products">
        <v-btn color="primary" elevation="3" small>Add products</v-btn>
      </router-link>
    </div> -->
    <router-view />
  </v-app>
</template>
<script>
export default {};
</script>
<style>
.navbar {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  width: 100vw;
  height: 100px;
  padding-right: 25px;
  padding-left: 25px;
}
</style>