import http from './../utils/request'
import interfaces from './config.js'
const Http = {} // 包裹请求方法的容器
// 请求格式/参数的统一
for (const key in interfaces) {
  const api = interfaces[key] // url method
  // async 作用：避免进入回调地狱
  Http[key] = async function (
    params, // 请求参数 get：url，put，post，patch（data），delete：url
    isFormData = false, // 标识是否是form-data请求
    config = {} // 配置参数
  ) {
    //  content-type是否是form-data的判断
    let requUrl = api.url
    if (params) {
      for (const key in params) {
        if (requUrl.includes(`{${key}}`)) {
          requUrl = requUrl.replace(`{${key}}`, params[key])
        }
      }
      if (isFormData) {
        const newParams = new FormData()
        for (const i in params) {
          newParams.append(i, params[i])
        }
        params = newParams
      }
    }

    // 不同请求的判断
    let response = {} // 请求的返回值
    if (
      api.method === 'put' ||
      api.method === 'post' ||
      api.method === 'patch'
    ) {
      response = await http[api.method](requUrl, params, config)
    } else if (api.method === 'delete' || api.method === 'get') {
      config.params = params

      response = await http[api.method](requUrl, config)
    }

    return response // 返回响应
  }
}
export default Http
