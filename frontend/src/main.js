// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

import Vue from 'vue'
import iView from 'iview'
// import 'iview/dist/styles/iview.css'
import './my-theme/index.less'
import './index.less'

import App from './App'
import router from './router'
import store from './store'
import Qrcode from './components/Qrcode'
import Histogram from 'v-charts/lib/histogram.common'
import VeLine from 'v-charts/lib/line.common'
import api from './api'   //axios实例化后引入取名http

// Vue.prototype.lrz = lrz;
Vue.prototype.api = api   //放入全局
Vue.config.productionTip = false
Vue.component(Histogram.name, Histogram)
Vue.component(VeLine.name, VeLine)



Vue.use(Qrcode)
Vue.use(iView)
/* eslint-disable no-new */
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app")
