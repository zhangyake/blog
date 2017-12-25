<template>

        <div class="demo-infinite-container">
            <mu-list>
                <div class="article" v-for="(item,index) in list" :key="'mu-card'+index">
                    <router-link :to="'/article/'+item.id">
                        <div class="title" v-text="item.title"></div>
                    </router-link>
                    <span class="date" v-text="item.created_at"></span>
                    <div v-html="item.content.slice(0,item.content.indexOf('MORE'))"></div>
                    <div class="show-all">
                        <router-link :to="'/article/'+item.id">
                            查看全文
                        </router-link>
                    </div>

                </div>
            </mu-list>
            <mu-infinite-scroll :scroller="scroller" :loading="loading" @load="loadMore"> </mu-infinite-scroll>
            <div v-if="noArticle" class="dixian"> ~ ~ 我是有底线的 ~ ~ </div>
        </div>


</template>
<script>
//    import Footer from './common/Footer.vue'

    export default {
        data() {
            return {
                list: [],
                loading: false,
                page: 1,
                scroller: null,
                noArticle: false
            }
        }, components: {
//            Footer
        },
        mounted() {
            this.scroller = this.$el;
            axios.get('/api/_articles').then((response) => {
                let list = response.data.data.articles.list;
                for (let i = 0; i < list.length; i++) {
                    this.list.push(list[i])
                }
            })
        },
        methods: {

            loadMore() {
                this.page = this.page + 1;
                if (!this.noArticle) {
                    axios.get('/api/_articles?page=' + this.page).then((response) => {
                        let list = response.data.data.articles.list;
                        if (list && list.length) {
                            this.loading = true;
                            setTimeout(() => {
                                for (let i = 0; i < list.length; i++) {
                                    this.list.push(list[i])
                                }
                                this.loading = false;
                            }, 2000);

                        } else {
                            this.noArticle = true;
                        }


                    })
                }


            }
        }
    }
</script>
<style scoped>

    .demo-infinite-container {
        margin-top: 50px;
        width: 100%;
        height: 100%;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
    }

    .article {
        padding: 10px;
        border-bottom: solid 1px #ebebeb;
    }

    .article a {
        color: #42b983;
    }

    .title {
        font-size: 25px;
    }

    .date {
        color: #7f8c8d;
        font-size: 13px;
    }

    .show-all {
        text-align: right;
    }

    .dixian {
        text-align: center;
        color: #42b983;
        margin: 10px 0 30px 0;
        font-size: 18px;
    }
</style>