// ie polyfill
import '@babel/polyfill'

import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/'
import api from './api'
import bootstrap from './core/bootstrap'
import './core/use'

import './utils/filter' // global filter
import i18n from './locales'

Vue.config.productionTip = false
Vue.prototype.$api = api

new Vue({
  router,
  store,
  i18n,
  created: bootstrap,
  render: h => h(App)
}).$mount('#app')
