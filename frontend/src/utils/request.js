import Vue from 'vue'
import axios from 'axios'
import store from '@/store'
import notification from 'ant-design-vue/es/notification'
// import message from 'ant-design-vue/es/message'

import { ACCESS_TOKEN } from '@/store/mutation-types'

// 创建 axios 实例
const http = axios.create({
  // baseURL: process.env.VUE_APP_API_BASE_URL, // api base_url
  timeout: 6000 // 请求超时时间
})
const notHandelUrls = ['/api/login', '/api/auth/login']

const err = (error) => {
  if (error.config && notHandelUrls.includes(error.config.url)) {
    return Promise.reject(error)
  }
  console.log(error.response)
  if (error.response) {
    const data = error.response.data
    if (error.response.status) {
      switch (error.response.status) {
        case 400:
          notification.error({
            message: data.msg
          })
          break
        // 401: 未登录 登录超时
        // 未登录则跳转登录页面，并携带当前页面的路径
        // 在登录成功后返回当前页面，这一步需要在登录页操作。
        // token过期
        // 登录过期对用户进行提示
        // 清除本地token和清空vuex中token对象
        case 401:
          notification.error({
            message: 'Unauthorized',
            description: 'Authorization verification failed'
          })
          store.dispatch('Logout').then(() => {
            setTimeout(() => {
              window.location.reload()
            }, 1500)
          })
          break
          // 403
          // 没有权限
        case 403:
          notification.error({
            message: 'Forbidden',
            description: data.message
          })
          break
          // 404请求不存在
        case 404:
          notification.error({
            message: '404 Not found',
            description: data.message
          })
          break
          // 其他错误，直接抛出错误提示
        default:
          notification.error({
            message: error.response.statusText,
            description: '服务繁忙，请稍后再试!'
          })
      }
      return Promise.reject(error.response)
    }
  }
}

// 请求拦截
http.interceptors.request.use(config => {
  const token = Vue.ls.get(ACCESS_TOKEN)
  if (token) {
    config.headers['Authorization'] = token // 让每个请求携带自定义 token 请根据实际情况自行修改
  }
  return config
}, err => {
  return Promise.reject(err)
})

// response interceptor
http.interceptors.response.use((response) => {
  console.log(response)
  return response.data
}, err)

export default http
