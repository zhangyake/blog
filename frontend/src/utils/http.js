import axios from 'axios'
import store from '@/store'
import { Message } from 'iview'
import { getToken } from '@/utils/auth'
/**
 * http请求工具类
 * 请求拦截器 负责将客户端标识token值存储并放置在头部提交给服务端
 *
 * 响应拦截器 负责全局处理业务请求的网络或者业务错误
 */

// 创建一个axios实例
const http = axios.create({
  baseURL: process.env.BASE_API, // 基础URL
  timeout: 25000 // 超时时间
})

const loginUrls = ['/api/login']

// 请求拦截
http.interceptors.request.use(config => {
  if (getToken()) {
    config.headers['Authorization'] = 'Bearer ' + getToken() // 让每个请求携带token-- ['X-Token']为自定义key 请根据实际情况自行修改
  }
  return config
}, err => {
  console.log(err)
  Promise.reject(err)
})

// 响应拦截
http.interceptors.response.use(response => {
  /**
     * 通过response自定义errCode来标示请求状态
     */
  const status = response.status
  if (status === 200 || status === 201 || status === 204) {
   
    
    return response.data
  } else {
    return Promise.reject(new Error('error'))
  }
}, err => {
  console.log(JSON.stringify(err))
  let msg = ''
  if (err.code && err.code === 'ECONNABORTED') {
    msg = '请求超时!'
    Message.error({
      content: msg,
      duration: 5
    })
  }
  if (err.config && loginUrls.includes(err.config.url)) {
    return Promise.reject(err)
  } else {
    const response = err.response

    if (response) {
      msg = (response.data && response.data.message) ? response.data.message : ''
      if (response.status === 400) {
        msg = msg || 'Bad Request!'
      } else if (response.status === 401) {
        Message.error({
          content: '登录认证已失效，重新登录!',
          duration: 3
        })
           setTimeout(() => {
        store.dispatch('logOut').then(() => {
          location.reload()
        })
      }, 1000)
      return false;
      } else if (response.status === 403) {
        msg = msg || 'Forbidden!'
      } else if (response.status === 404) {
        msg = msg || 'Not Found !'
      } else if (response.status === 405) {
        msg = msg || 'Method Not Allowed!'
      } 
      else if (response.status === 422) {
        msg = msg || '系统繁忙,稍后再试!'
      } 
      else {
        msg = '系统繁忙,稍后再试!'
      }
      Message.error({
        content: msg,
        duration: 5
      })
    }
    return Promise.reject(err)
  }
})

export default http
