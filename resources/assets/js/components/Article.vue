<template>
    <div>
        <div class="demo-infinite-container">
            <mu-list>
                <article v-for="(item,index) in list" :key="'mu-card'+index">
                    <router-link :to="'/article/'+item.id">
                        <div class="title" v-text="item.title"></div>
                    </router-link>
                    <span class="date" v-text="item.created_at"></span>
                    <div v-html="item.content.slice(0,item.content.indexOf('MORE'))">
                    </div>
                    <div class="show-all">
                        <router-link :to="'/article/'+item.id">
                            查看全文
                        </router-link>
                    </div>

                </article>
            </mu-list>
            <mu-infinite-scroll :scroller="scroller" :loading="loading" @load="loadMore"/>

        </div>
        <!--<Footer></Footer>-->
    </div>

</template>
<script>
    import Footer from './common/Footer.vue'
    export default {
        data() {
            return {
                list: [],
                loading: false,
                page:1,
                scroller: null
            }
        }, components:{
            Footer
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
                this.loading = true;

                setTimeout(() => {
                    this.page = this.page+1;
                    axios.get('/api/_articles?page='+this.page).then((response) => {
                        console.log(response.data);
                        let list = response.data.data.articles.list;
                        for (let i = 0; i < list.length; i++) {
                            this.list.push(list[i])
                        }
                        this.loading = false
                    })
                }, 1000)
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

    article {
        padding: 10px;
        border-bottom: solid 1px #ebebeb;
    }

    article a {
        color: #42b983;
    }

    .title {
        font-size: 25px;
    }

    .date {
        color: #7f8c8d;
        font-size: 13px;
    }
    .show-all{
        text-align: right;
    }
</style>