export default {
  // 后台登录
  login: {
    url: '/api/auth/login',
    method: 'post'
  },
  // 后台登录
  getInfo: {
    url: '/api/auth/me',
    method: 'post'
  },
  // 退出登录
  logout: {
    url: '/api/auth/logout',
    method: 'post'
  },
  //   查询文章
  getArticleList: {
    url: '/api/articles',
    method: 'get'
  },
  //   get文章
  getArticleDetail: {
    url: '/api/articles/{id}',
    method: 'get'
  },
  //   新增文章
  insertArticle: {
    url: '/api/articles',
    method: 'post'
  },
  //   更新文章
  updateArticle: {
    url: '/api/articles/{id}',
    method: 'put'
  },
  //   删除文章
  deleteArticle: {
    url: '/api/articles/{id}',
    method: 'delete'
  },
  //   查询标签
  getAllTags: {
    url: '/api/tags/all',
    method: 'get'
  },
  //   新增标签
  insertTag: {
    url: '/api/tags',
    method: 'post'
  },
  //   更新标签
  updateTag: {
    url: '/api/tags/{id}',
    method: 'put'
  }

}
