// eslint-disable-next-line
import {UserLayout, BasicLayout, RouteView, BlankLayout, PageView} from '@/layouts'
import {bxAnaalyse} from '@/core/icons'

export const asyncRouterMap = [

    {
        path: '/',
        name: 'index',
        component: BasicLayout,
        meta: {title: '首页'},
        redirect: '/dashboard/analysis',
        children: [
            // dashboard
            {
                path: '/dashboard',
                name: 'dashboard',
                redirect: '/dashboard/analysis',
                component: RouteView,
                meta: {title: '仪表盘', keepAlive: true, icon: bxAnaalyse, permission: ['dashboard']},
                children: [
                    {
                        path: '/dashboard/analysis',
                        name: 'Analysis',
                        component: () => import('@/views/dashboard/Analysis'),
                        meta: {title: '分析页', keepAlive: false, permission: ['dashboard']}
                    }
                ]
            },
            // list
            {
                path: '/list/article',
                name: 'articleList',
                hideChildrenInMenu: true, // 强制显示 MenuItem 而不是 SubMenu
                component: () => import('@/views/article/Create'),
                meta: {title: '创建文章', keepAlive: true, icon: 'appstore'}
            },
            {
                path: '/article',
                name: 'article',
                hideChildrenInMenu: true, // 强制显示 MenuItem 而不是 SubMenu
                component: () => import('@/views/search/Projects'),
                meta: {title: '文章列表', keepAlive: true, icon: 'appstore'}
            },
            // list
            {
                path: '/list/user',
                name: 'userList',
                hideChildrenInMenu: true, // 强制显示 MenuItem 而不是 SubMenu
                component: () => import('@/views/user/List'),
                meta: {title: '会员管理', keepAlive: true, icon: 'appstore'}
            },


            {
                path: '/list/tag',
                name: 'tags',
                hideChildrenInMenu: true, // 强制显示 MenuItem 而不是 SubMenu
                component: () => import('@/views/tag/List'),
                meta: {title: '标签管理', keepAlive: true, icon: 'appstore'}
            },

            {
                path: '/list/admin-list',
                name: 'AdminUserListWrapper',
                hideChildrenInMenu: true, // 强制显示 MenuItem 而不是 SubMenu
                component: () => import('@/views/adminUser/List'),
                meta: {title: '后台账号', keepAlive: true, icon: 'appstore'}
            }

        ]
    },
    {
        path: '*', redirect: '/404', hidden: true
    }
]

/**
 * 基础路由
 * @type { *[] }
 */
export const constantRouterMap = [
    {
        path: '/user',
        component: UserLayout,
        redirect: '/user/login',
        hidden: true,
        children: [
            {
                path: 'login',
                name: 'login',
                component: () => import(/* webpackChunkName: "login" */ '@/views/login/Login')
            },
            {
                path: 'register',
                name: 'register',
                component: () => import(/* webpackChunkName: "login" */ '@/views/login/Register')
            },
            {
                path: 'register-result',
                name: 'registerResult',
                component: () => import(/* webpackChunkName: "login" */ '@/views/login/RegisterResult')
            }
        ]
    },

    {
        path: '/404',
        component: () => import(/* webpackChunkName: "fail" */ '@/views/exception/404')
    }

]
