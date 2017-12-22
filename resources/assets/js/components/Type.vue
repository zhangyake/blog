<template>
    <div class="time-line-demo">
        <br>
        <br>
        <br>

        <mu-timeline iconColor="#42b983">
            <mu-timeline-item v-for="(item, index) in articles" :key="'paper'+index" >
                <span slot="time" v-text="item.created_at"></span>
                <span slot="des"  class="des" v-text="item.title" @click="toArticle(item.id)"></span>
            </mu-timeline-item>
        </mu-timeline>

    </div>

</template>
<script>
    import  axios from  'axios'
    export default {
        data() {
            return {
                articles:[]
            }
        },
        mounted(){
            axios.get('/api/_articles').then((response)=>{
                console.log(response.data);
                this.articles = response.data.data.articles.list;
            })
        },
        methods: {
            toArticle(id){
                this.$router.push({ name: 'Article', params: { id }})
            }
        }
    }
</script>
<style scoped>
    .demo-paper {
        display: inline-block;
        height: 20px;
        width: 100px;
        margin: 20px;
        text-align: center;
    }
    .time-line-demo{
        margin-left:10px;
        padding: 10px;
    }
    .des{
        color: #42b983;
    }

</style>