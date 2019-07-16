import login from '@/views/login'
import page404 from '@/views/error-page/404.vue'

const layout = () => import(/* webpackChunkName: "group-index" */ '@/views/layout')

// 错误页面路由
export const errorRouterMap = [
  {
    path: '/403',
    meta: {
      title: '403-权限不足'
    },
    name: 'error-403',
    component: () => import('@/views/error-page/403.vue')
  },
  {
    path: '/500',
    meta: {
      title: '500-服务端错误'
    },
    name: 'error-500',
    component: () => import('@/views/error-page/500.vue')
  },
  { path: '/*', name: '404', hidden: true, component: page404 }
]

/**
* hidden: true                   如果hidden为true则不在左侧菜单栏展示，默认为false
* name:'router-name'             路由名称，必须填写
* meta : {
    title: 'title'               对应路由在左侧菜单栏的标题名称
    icon: 'icon-class'             对应路由在左侧菜单栏的图标样式，样式使用iconfont图标库，见assest/iconfont文件夹
  }
  children 下要显示的只有一个 则不会显示二级菜单 只显示该菜单 此时建议上级meta的title为''
**/
export const asyncRouterMap = [
    {
        path: '/',
        name: 'home',
        redirect: '/home',
        hidden: true,
        meta: { title: '', icon: 'ios-paw' },
        component: layout,
        children: [
            { path: 'home', name: 'home_index', meta: { title: '首页', icon: 'ios-paw' }, component: () => import(/* webpackChunkName: "group-index" */'@/views/home') }
        ]
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        meta: { title: '', icon: 'ios-flask-outline' },
        hidden: false,
        component: layout,
        children: [
            { path: 'index', meta: {title: '面板', icon: 'ios-flask-outline'}, name: 'dashboard_index', component: () => import('@/views/dashboard/dashboard') }
        ]
    },
    {
        path: '/articles',
        name: 'articles',
        meta: { title: '文章管理', icon: 'android-menu' },
        component: layout,
        children: [
            { path: 'index', meta: { title: '文章列表', icon: 'document-text' }, name: 'articles_index', component: () => import('@/views/articles/articles') },
            { path: 'create', meta: { title: '发布文章', icon: 'document-text' },  name: 'articles_add', component: () => import('@/views/articles/add-article') },
        ]
    },
    {
        path: '/users',
        name: 'users',
        meta: { title: '', icon: 'person-stalker' },
        component: layout,
        children: [
            { path: 'index', meta: { title: '用户管理', icon: 'person-stalker' }, name: 'users_index', component: () => import('@/views/users/users') }
        ]
    },
    {
        path: '/tags',
        name: 'tags',
        meta: { title: '', icon: 'pricetags' },
        component: layout,
        children: [
            { path: 'index', meta: { title: '标签管理', icon: 'pricetags' }, name: 'tags_index', component: () => import('@/views/tags/tags') }
        ]
    },
    {
        path: '/categories',
        name: 'categories',
        meta: { title: '', icon: 'android-menu' },
        component: layout,
        children: [
            { path: 'index', meta: { title: '分类管理', icon: 'ios-list' }, name: 'categories_index', component: () => import('@/views/categories/categories') }
        ]
    },
  
    {
        path: '/friendslinks',
        name: 'friendslinks',
        meta: { title: '', icon: 'ios-world' },
        component: layout,
        children: [
            { path: 'index', meta: { title: '友链管理', icon: 'ios-world' }, name: 'friendslinks_index', component: () => import('@/views/friendslinks/friendslinks') }
        ]
    }

]
/**
 * 登陆路由
 */
export const constantRouterMap = [
    { path: '/login', name: 'login', hidden: true, meta: { title: '系统登录' }, component: login },
    { path: '/preview', meta: { title: '创建2', icon: 'document-text' }, hidden: true, name: 'preview_article', component: () => import('@/views/articles/preview') }
]
