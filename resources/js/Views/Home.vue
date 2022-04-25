<template>
  <div class="home">
    <NavBar></NavBar>
    <section id="IntroSection">
      <div class="contentContainer">
        <div class="TextBox">
          <h1>Title Here</h1>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat
            nostrum excepturi deserunt blanditiis ipsam possimus ipsa magnam ab
            impedit eum?
          </p>
          <button id="register-btn">REGISTER NOW</button>
        </div>
      </div>
    </section>

    <section id="DanceTour">
      <div class="contentContainer">
        <div class="textContainer">
          <h1>Dance Tour</h1>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
            temporibus, et mollitia itaque quaerat in.
          </p>
        </div>
        <div class="cardsContainer">
          <Card CardTitle="america"  imageURL="../assets/images.png"></Card>
          <Card  CardTitle="asia"  imageURL="../assets/images.png"></Card>
          <Card  CardTitle="australia"  imageURL="../assets/images.png"></Card>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import NavBar from "../components/NavBar.vue";
import Card from "../components/Card.vue";

export default {
  components: { NavBar, Card },
};
</script>

<style>
.home {
  width: 100vw;
  min-height: 100vh;
  background-color: black;
  padding-top: 100px;
}
section {
  position: relative;
  width: 100vw;
  min-height: 100vh;
  color: white;
  padding-right: 75px;
  padding-left: 75px;
}
#IntroSection {
  background: url("../assets/featured_image-8.png");
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
}
#DanceTour {
  padding-top: 75px;
  padding-bottom: 75px;
  text-align: center;
  background-image: repeating-linear-gradient(
      112.5deg,
      rgb(240, 97, 48) 0px,
      rgb(240, 97, 48) 20px,
      transparent 20px,
      transparent 22px
    ),
    repeating-linear-gradient(
      22.5deg,
      rgb(240, 97, 48) 0px,
      rgb(240, 97, 48) 20px,
      transparent 20px,
      transparent 22px
    ),
    linear-gradient(90deg, rgb(0, 0, 0), rgb(0, 0, 0));
}
#DanceTour .textContainer {
  width: 100%;
  padding: 0 150px;
  margin-bottom: 50px;
}
#DanceTour h1 {
  font-size: 72px;
  font-weight: bold;
}
#DanceTour p {
  font-size: 32px;
  font-weight: light;
  margin: 25px 0;
}
#DanceTour .cardsContainer{
width:100%;
display:grid;
grid-template-columns:repeat(3,1fr);
column-gap:40px;
}

.contentContainer {
  width: 100%;
  height: 100%;
}
.TextBox {
  width: 50%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
}
.TextBox h1 {
  font-size: 64px;
  font-weight: bold;
}
.TextBox p {
  font-size: 20px;
  font-weight: light;
  line-height: 20px;
}
#register-btn {
  padding: 5px 40px;
  border-radius: 2.5px;
  font-size: 24px;
  background-color: #f06130;
}
</style>