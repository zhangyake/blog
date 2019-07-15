
import {
  constantRouterMap,
  asyncRouterMap,
  errorRouterMap
} from '@/router/routes'
import { clearAllCache, getKey, setKey, setToken } from '@/utils/auth'
// import { Notice } from 'iview'
// import * as UUID from 'uuidjs'
import api from '@/api'
import router from './../../router'
const user = {
  state: {
    token: '',
    name: '',
    avatar: 'https://i.loli.net/2017/08/21/599a521472424.jpg',
    roles: [],
    hasMenus: {},
    menuList: [],
    firstPage: '/'
  },
  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_NAME: (state, name) => {
      state.name = name
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar
    },
    SET_MENULIST: (state, routes) => {
      state.menuList = constantRouterMap.concat(routes)
    },
    SET_HASMENUS: (state, menus) => {
      state.hasMenus = menus
    },
    SET_FIRSTPAGE: (state, firstPage) => {
      state.firstPage = firstPage
    }
  },
  actions: {
    // 获取用户菜单
    getUserMenu: ({ commit }) => {
      return new Promise((resolve) => {
        // 暂时无权限控制 分配所有菜单路由
        let routes = asyncRouterMap
        commit('SET_NAME', getKey('user_name'))
        commit('SET_MENULIST', routes)
        router.addRoutes(routes.concat(errorRouterMap))
        resolve()
        // let routes = []
        // // const userMenus = state.hasMenus
        // const userMenus = JSON.parse(getKey('hasMenus'))

        // asyncRouterMap.forEach(item => {
        //   if (userMenus.hasOwnProperty(item.name) && userMenus[item.name]) {
        //     if (item.children && item.children.length) {
        //       let children = item.children.filter(element => {
        //         return userMenus.hasOwnProperty(element.name) && userMenus[element.name]
        //       })
        //       item.children = children
        //     }
        //     routes.push(item)
        //   }
        // })
        // commit('SET_MENULIST', routes)
        // router.addRoutes(routes.concat(errorRouterMap))
        // resolve()
        //     router.addRoutes(routes.concat(errorRouterMap))
        // api.getUserInfo().then(res => {
        //   if (res && res.data) {
        //     const user = res.data
        //     commit('SET_HASMENUS', res.data.menus)
        //     commit('SET_NAME', user.name)
        //     commit('SET_AVATAR', user.avatar)
        //     const userMenus = res.data.menus

        //     //  设置左侧可显示菜单
        //     let routes = []
        //     if (!user.is_admin) {
        //       asyncRouterMap.forEach(item => {
        //         if (userMenus.hasOwnProperty(item.name) && userMenus[item.name]) {
        //           if (item.children && item.children.length) {
        //             let children = item.children.filter(element => {
        //               return userMenus.hasOwnProperty(element.name) && userMenus[element.name]
        //             })
        //             item.children = children
        //           }
        //           routes.push(item)
        //         }
        //       })
        //     } else {
        //       routes = asyncRouterMap
        //     }
        //     commit('SET_MENULIST', routes)
        //     router.addRoutes(routes.concat(errorRouterMap))
        //   }
        //   resolve()
        // }).catch(error => {
        //   reject(error)
        // })
      })
    },
    // 退出登录
    logOut({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '')
        clearAllCache()
        resolve()
      })
    },
    // 前端 登出
    fedLogOut({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '')
        clearAllCache()
        resolve()
      })
    }
  }
}

export default user
