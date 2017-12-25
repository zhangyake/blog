<template>
    <div>
        <br/>
        <br/>
        <section>
            <h2>All Tags</h2>
            <p>
                <span class="tag" v-for="(item, index) in tags" :key="'__paper'+index" v-text="item.name"></span>
            </p>
        </section>

    </div>

</template>
<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                tags: []
            }
        },
        mounted() {
            axios.get('/api/_tags').then((response) => {
//                console.log(response.data);
                this.tags = response.data.data.tags;
            })
        },
        methods: {}
    }
</script>
<style scoped>

    h2 {
        margin-left: 10px;
        font-size: 1.6em;
        margin-bottom: 20px;
    }

    .tag {
        float: left;
        color: #42b983;
        margin-left: 10px;
        margin-bottom: 5px;
    }
</style>