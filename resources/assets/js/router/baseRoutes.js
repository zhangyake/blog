
import Index from '../views/blog'
import Home from '../views/blog/home.vue'
import Article from '../views/blog/article.vue'
import Archives from '../views/blog/archives.vue'
import Tags from '../views/blog/tags.vue'
import About from '../views/blog/about.vue'
import Chat from '../views/blog/chat.vue'

// import NotFound from '@/views/error/404'

export default [
  {
    path: '/',
    name: 'Index',
    component: Index,
    children: [
      {
        path: '/',
        name: 'Home',
        component: Home
      },
      {
        path: '/article/:id',
        name: 'Article',
        component: Article
      },
      {
        path: '/archives/:tag_id',
        name: 'Archives',
        component: Archives
      },
      {
        path: '/tags',
        name: 'Tags',
        component: Tags
      },
      {
        path: '/about',
        name: 'About',
        component: About
      }
    ]
  },
    {
        path: '/chat',
        name: 'Chat',
        component: Chat
    },
  {
    path: '/404',
    redirect: { name: 'Home' }
  }
]
