import Vue from 'vue'

import { ACCESS_TOKEN } from '@/store/mutation-types'
import { welcome } from '@/utils/util'
import api from '@/api'
const user = {
  state: {
    token: '',
    name: '',
    welcome: '',
    avatar: 'https://preview.pro.loacg.com/avatar2.jpg',
    roles: [],
    info: {}
  },

  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_NAME: (state, { name, welcome }) => {
      state.name = name
      state.welcome = welcome
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles
    },
    SET_INFO: (state, info) => {
      state.info = info
    }
  },

  actions: {
    // 登录
    Login ({ commit }, data) {
      return new Promise((resolve, reject) => {
        api.login(data).then(response => {
          Vue.ls.set(ACCESS_TOKEN, response.token_type + ' ' + response.access_token, response.expires_in * 1000)
          commit('SET_TOKEN', response.access_token)
          commit('SET_AVATAR', 'https://preview.pro.loacg.com/avatar2.jpg')
          resolve()
        }).catch(error => {
          console.log(error)
          reject(error)
        })
      })
    },

    // 获取用户信息
    GetInfo ({ commit }) {
      return new Promise((resolve, reject) => {
        api.getInfo().then(response => {
          console.log(response)
          console.log('--')
          commit('SET_NAME', { name: response.username, welcome: welcome() })
          commit('SET_AVATAR', 'https://preview.pro.loacg.com/avatar2.jpg')
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },

    // 登出
    Logout ({ commit, state }) {
      return new Promise((resolve) => {
        api.logout().then(() => {
          resolve()
        }).catch(() => {
          resolve()
        }).finally(() => {
          commit('SET_TOKEN', '')
          commit('SET_ROLES', [])
          Vue.ls.remove(ACCESS_TOKEN)
        })
      })
    }

  }
}

export default user
