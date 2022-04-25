<template>
  <div class="cardContainer">
  <div class="imageContainer"></div>
  <div class="textContainer">
  <h2>{{CardTitle}}</h2>
  <p>lorem</p>
  </div>
  </div>
</template>

<script>
export default {
  props:{
    ImageURL:String,
    CardTitle:String
  }
};
</script>

<style scoped>
.cardContainer {
  width: 100%;
  height:450px;
}
.imageContainer{
  width: 100%;
  height:300px;
  background: url("../assets/images.png");
  background-size:cover;
}
.textContainer{
width:100%;
height:150px;
background:#333;
}

</style>