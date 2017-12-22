import Vue from 'vue'
import Article from '../components/Article.vue'
import ArticleDetail from '../components/ArticleDetail.vue'
import About from '../components/About.vue'
import Type from '../components/Type.vue'
import Tag from '../components/Tag.vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: 'Home',
            path: '/',
            component: Article
        },
        {
            name: 'Tag',
            path: '/tag',
            component: Tag

        },
        {
            name: 'Type',
            path: '/type',
            component: Type
        },
        {
            name: 'About',
            path: '/about',
            component: About
        },
        {
            name: 'Article',
            path: '/article/:id',
            component: ArticleDetail
        },
    ]
});