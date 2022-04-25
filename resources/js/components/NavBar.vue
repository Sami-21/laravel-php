<template>
  <nav>
    <div class="logo">
      <v-icon x-large dark>mdi-music-note</v-icon><br />
      <span>Musicology</span>
    </div>
    <ul class="navItems">
      <!-- <li v-for="item in NavBarItems" :key="NavBarItems.indexOf(item)">1</li> -->
      <li>HOME</li>
      <li>PRODUCT</li>
      <li>PROMO</li>
      <li>ABOUT</li>
      <li>CONTACT</li>
    </ul>
    <div class="search"><v-icon dark large>mdi-magnify</v-icon></div>
  </nav>
</template>

<script>
export default {
  data: () => ({
    NavBarItems: ["test1", "test2", "test3", "test4", "test5"],
  }),
};
</script>

<style>
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-left: 75px;
  padding-right: 75px;
  position: absolute;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100px;
  background-color: #2c2c2c;
  color: white;
}
.navItems {
  width: 600px;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  list-style: none;
  margin-bottom: 0;
  font-weight: bold;
  font-size: 20px;
}
.logo {
  text-align: center;
}
</style>