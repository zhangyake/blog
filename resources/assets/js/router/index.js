import Vue from 'vue'
import Router from 'vue-router'
import baseRoutes from './baseRoutes'

Vue.use(Router)

const router = new Router({
    // mode: 'history',
    routes: [
        ...baseRoutes
    ],
    // scrollBehavior (to, from, savedPosition) {
    //     return { x: 0, y: 0 }
    // }
})

router.beforeEach((to, from, next) => {
    // 访问的路由没有定义 直接404页面
    if (!to.name) {
        next('404')
    } else {
        next()
    }
})

export default router