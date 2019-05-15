/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import {routes} from './routes'
import MainApp from './components/MainApp.vue'
import StoreData from './store'
import Vuetify from 'vuetify'
import Axios from 'axios';


Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(Vuex)

const store = new Vuex.Store(StoreData)

const router = new VueRouter({
  routes,
  store,
  mode: 'history'
})
router.beforeEach((to, from, next)=>{
    const requiresAuth = to.matched.some(record=>record.meta.requiresAuth)

    const currentUser = store.state.currentUser

    if(requiresAuth && !currentUser){
        next('/')
    }
    else if(to.path == '/'&& currentUser){
        next('/events')
    }
    else{
        next()
    }


})

// Axios.defaults.headers.common["Authorization"] = `Bearer ${store.getters.currentUser.token}`

const app = new Vue({
    el: '#app',router,
    store,
    components:{
        MainApp
    }
});
