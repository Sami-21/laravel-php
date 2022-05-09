window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router'
import routes from './routes/Index.js'
import VeeValidate from 'vee-validate';
import Vuetify from 'vuetify'
import VueBus from 'vue-bus';
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import  "../css/index.css"


Vue.use(VeeValidate);
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(VueBus);


Vue.component('app', require('./App.vue').default);


const router = new VueRouter({
    routes:routes,
})
 
const app = new Vue({
    router,
    vuetify:new Vuetify(),
    el: '#app',
});