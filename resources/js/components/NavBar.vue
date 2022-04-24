<template>
  <nav>
    <div class="logo"></div>
    <ul class="navItems">
      <!-- <li v-for="item in NavBarItems" :key="NavBarItems.indexOf(item)">1</li> -->
      <li>item 1</li>
      <li>item 2</li>
      <li>item 3</li>
      <li>item 4</li>
      <li>item 5</li>
    </ul>
    <div class="search"></div>
  </nav>
</template>

<script>
export default {
  data: {
    NavBarItems: ["test1", "test2", "test3", "test4", "test5"],
  },
};
</script>

<style>
nav {
  position: absolute;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100px;
  background-color: orange;
}
.logo {
}
</style>