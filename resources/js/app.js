require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify';
import VueSimplemde from 'vue-simplemde';
import AppHome from './components/AppHome.vue';
import router from './router/router.js';
import User from './helpers/User';
import Exception from './helpers/Exception';
import md from 'marked';
import VueSimpleAlert from 'vue-simple-alert';
import '@mdi/font/css/materialdesignicons.css';

window.User = User;
window.Exception = Exception;
window.EventBus = new Vue();
window.md = md;

User.isToken();

Vue.use(Vuetify);
Vue.use(VueSimplemde);
Vue.use(VueSimpleAlert);

Vue.component('app-home', AppHome);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
        icons: {
            iconfont: 'mdi'
        }
    }),
    router
});
