<template>
  <div class="home">
    <NavBar></NavBar>
  </div>
</template>
<script>
import NavBar from "../components/NavBar.vue";

export default {
  components: { NavBar },
};
</script>

<style>
.home {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100vw;
  min-height: 100vh;
  background-color: black;
}
</style>