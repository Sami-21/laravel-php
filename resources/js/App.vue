<template>
  <v-app>
    <div>
      <router-link to="/">
        <v-btn color="primary" elevation="3" small>home</v-btn>
      </router-link>
      <router-link to="/about">
        <v-btn color="primary" elevation="3" small>about</v-btn>
      </router-link>
    </div>

    <div>
      <v-btn class="mx-2" fab dark small color="primary">
        <v-icon dark> mdi-minus </v-icon>
      </v-btn>

      <v-btn class="mx-2" fab dark small color="pink">
        <v-icon dark> mdi-heart </v-icon>
      </v-btn>

      <v-btn class="mx-2" fab dark color="indigo">
        <v-icon dark> mdi-plus </v-icon>
      </v-btn>

      <v-btn class="mx-2" fab dark color="teal">
        <v-icon dark> mdi-format-list-bulleted-square </v-icon>
      </v-btn>

      <v-btn class="mx-2" fab dark large color="cyan">
        <v-icon dark> mdi-pencil </v-icon>
      </v-btn>

      <v-btn class="mx-2" fab dark large color="purple">
        <v-icon dark> mdi-android </v-icon>
      </v-btn>
    </div>
    <router-view />
  </v-app>
</template>
<script>
export default {};
</script>
