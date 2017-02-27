import Vue from 'vue'
import App from './App'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import CreateCls from './components/CreateCls.vue'
import step1 from './components/CreateCls/step1.vue'
import step2 from './components/CreateCls/step2.vue'
import step3 from './components/CreateCls/step3.vue'
import classDetail from './components/ClassSpecifics'
import ballot from './components/Ballot.vue'

const FastClick = require('fastclick')
FastClick.attach(document.body)
Vue.use(VueRouter)
const router = new VueRouter({
  transitionOnLoad: false
})
Vue.use(VueResource)
Vue.http.options.emulateJSON = true

import {sync} from 'vuex-router-sync'
import store from './vuex/store'

let history = window.sessionStorage
history.clear()
let historyCount = history.getItem('count') * 1 || 0
history.setItem('/', 0)

const commit = store.commit || store.dispatch

router.beforeEach(({ to, from, next }) => {
  // 避免回到首页时多刷新接口
  window.scrollTo(0, 0)
  const toIndex = history.getItem(to.path)
  const fromIndex = history.getItem(from.path)
  if (toIndex) {
    if (toIndex > fromIndex) {
      commit('UPDATE_DIRECTION', 'forward')
    } else {
      commit('UPDATE_DIRECTION', 'reverse')
    }
  } else {
    ++historyCount
    history.setItem('count', historyCount)
    to.path !== '/' && history.setItem(to.path, historyCount)
    commit('UPDATE_DIRECTION', 'forward')
  }
  setTimeout(next, 50)
})

sync(store, router)

Vue.http.interceptors.push((request, next) => {
  commit('UPDATE_LOADING', true)
  console.log()
  next(() => {
    commit('UPDATE_LOADING', false)
  })
})

router.map({
  '/': {
    component: ballot
  },
  '/CreateCls': {
    component: CreateCls,
    subRoutes: {
      '/': {
        component: step1
      },
      '/step1': {
        component: step1
      },
      'step2': {
        component: step2
      },
      'step3': {
        component: step3
      }
    }
  },
  '/ClassSpecifics/category/:clsId': {
    name: 'ClassSpecifics',
    component: classDetail
  },
  '/Ballot': {
    component: ballot
  }
})

router.start(App, '#app')
