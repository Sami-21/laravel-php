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
@import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap");
body {
  font-family: Bebas Neue, sans-serif;
}
</style>