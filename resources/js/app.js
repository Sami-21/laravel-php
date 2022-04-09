window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router'
import routes from './routes/index.js'
import Vuetify from 'vuetify'
import VueBus from 'vue-bus';
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader


Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(VueBus);


Vue.component('Products-Data', require('./components/ProductsData.vue').default);
Vue.component('Stores-Data', require('./components/StoresData.vue').default);
Vue.component('app', require('./App.vue').default);


const router = new VueRouter({
    routes:routes,
})
 
const app = new Vue({
    router,
    vuetify:new Vuetify(),
    el: '#app',
});