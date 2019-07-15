import http from './../utils/http'

export default {
    login (data) {
        return http({
            url: '/api/auth/login',
            method: 'post',
            data
        })
    },
    getUserInfo (data) {
        return http({
            url: '/api/auth/me',
            method: 'post',
            data
        })
    },
    getUserList (params) {
        return http({
            url: '/api/users',
            method: 'get',
            params
        })
    },
    addUser (data) {
        return http({
            url: '/api/users',
            method: 'post',
            data
        })
    },
    updateUser (data) {
        return http({
            url: `/api/users/${data.id}`,
            method: 'put',
            data
        })
    },
    deleteUser (data) {
        return http({
            url: `/api/users/${data.id}`,
            method: 'delete',
            data
        })
    },

    getTagList (params) {
        return http({
            url: '/api/tags',
            method: 'get',
            params
        })
    },
    addTag (data) {
        return http({
            url: '/api/tags',
            method: 'post',
            data
        })
    },
    updateTag (data) {
        return http({
            url: `/api/tags/${data.id}`,
            method: 'put',
            data
        })
    },
    deleteTag (data) {
        return http({
            url: `/api/tags/${data.id}`,
            method: 'delete',
            data
        })
    },

    getLinkList (params) {
        return http({
            url: '/api/links',
            method: 'get',
            params
        })
    },
    addLink (data) {
        return http({
            url: '/api/links',
            method: 'post',
            data
        })
    },
    updateLink (data) {
        return http({
            url: `/api/links/${data.id}`,
            method: 'put',
            data
        })
    },
    deleteLink (data) {
        return http({
            url: `/api/links/${data.id}`,
            method: 'delete',
            data
        })
    },

    getCategoryList (params) {
        return http({
            url: '/api/categories',
            method: 'get',
            params
        })
    },
    addCategory (data) {
        return http({
            url: '/api/categories',
            method: 'post',
            data
        })
    },
    updateCategory (data) {
        return http({
            url: `/api/categories/${data.id}`,
            method: 'put',
            data
        })
    },
    deleteCategory (data) {
        return http({
            url: `/api/categories/${data.id}`,
            method: 'delete',
            data
        })
    },

    getArticleList (params) {
        return http({
            url: '/api/articles',
            method: 'get',
            params
        })
    },
    addArticle (data) {
        return http({
            url: '/api/articles',
            method: 'post',
            data
        })
    },
    updateArticle (data) {
        return http({
            url: `/api/articles/${data.id}`,
            method: 'put',
            data
        })
    },
    deleteArticle (data) {
        return http({
            url: `/api/articles/${data.id}`,
            method: 'delete',
            data
        })
    }
}
