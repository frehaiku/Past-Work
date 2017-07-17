import 'babel-polyfill'
// es6对象数组方法的polyfill
import 'core-js'

import Vue from 'vue'
import Router from 'vue-router'
// import {toast} from './plugins/toast/index'
import {config} from './libs/config'
import {interfaces} from './api'

import fc from 'fastclick'
// fastclick
fc.attach(document.body)
import store from './store'
import App from './App.vue'
import {routes} from './router.config'

import './libs/rem.js'
import './assets/css/reset.css'

// import 'vconsole/dist/vconsole.min'

// import { ToastPlugin } from './plugins/vux-toast'
// Vue.use(ToastPlugin)

Vue.use(Router)
Vue.use(config)
Vue.use(interfaces)
// console.log(toast)
// Vue.use(toast)

const router = new Router({
  routes
});

router.beforeEach((to, form, next) => {
  store.commit('SHOW_LOADING')
  next()
})
router.afterEach(route => {
  store.commit('HIDE_LOADING')
})

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
