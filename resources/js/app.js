require('./utils/bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMeta from 'vue-meta'
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'
import VueSocialSharing from 'vue-social-sharing'
import VueNumericInput from 'vue-numeric-input';
import VueAwesomeSwiper from 'vue-awesome-swiper'

import router from './router/router'
import store from './store/store'
import Mixin from './utils/mixin'
import init from './plugins/init'
import plugins from './plugins/plugins'
import { i18n } from './plugins/i18n'

import theShop from './components/TheShop';
import DynamicLink from './components/inc/DynamicLink';
import Banner from './components/inc/Banner';
import ProductBox from './components/product/ProductBox';


window.Vue = require('vue');

Vue.use(VueNumericInput)
Vue.use(VueSocialSharing)
Vue.use(VueAwesomeSwiper)
Vue.use(plugins)
Vue.use(VueRouter)
Vue.use(Vuetify)
Vue.use(VueMeta)
Vue.use(Vuelidate)
Vue.mixin(Mixin)
Vue.component('dynamic-link', DynamicLink)
Vue.component('banner', Banner)
Vue.component('product-box', ProductBox)

init(store,router)


const app = new Vue({
    i18n,
    router,
    store,
    vuetify: new Vuetify(),
    el: '#app',
    render: h => h(theShop),
});
