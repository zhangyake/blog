<template>
    <div>
        <div class="demo-infinite-container">
            <mu-card class="article-detail">
                <mu-card-title :title="article.title"/>
                <mu-card-text v-html="article.content">

                </mu-card-text>
            </mu-card>


        </div>
        <footer class="copyright"> Copyrights申请中... Use <a href="https://cn.vuejs.org/" target="_blank">Vue.js </a>
            and <a href="http://www.muse-ui.org/" target="_blank">Muse-UI</a>. </footer>
    </div>

</template>
<script>
    export default {
        data() {
            return {
                article: {},
            }
        }, mounted() {

            if (this.$route.params.id) {
                let articleId = this.$route.params.id;
                axios.get('/api/_articles/' + articleId).then((response) => {
                    let article = response.data.data.article;
                    if (article) {
                        article.content = article.content.replace('MORE', '');
                        this.article = article;
                    }


                })
            }

        },
        methods: {
            loadMore() {


            }
        }
    }
</script>
<style scoped>

    .demo-infinite-container {
        margin-top: 50px;
        margin-left: 3px;
        margin-right: 3px;
        width: 100%;
        height: 100%;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        /*padding-bottom:50px;*/
        /*border-bottom: 1px solid #ebebeb;*/

    }
    .article-detail{
      padding-bottom: 10px;
    }
    .copyright{
        margin:0 20px;
        border-top: 1px solid #ebebeb;
        padding-top: 20px;
        padding-bottom: 20px;
        text-align: center;
    }
    .copyright a{
        color: #5cc68a;
    }
</style>