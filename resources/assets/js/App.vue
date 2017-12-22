<template>
    <div id="app">
        <Sider></Sider>
     <router-view></router-view>
    </div>

</template>
<script>
    import Sider from './components/common/Sider.vue'
    export default {
       name:'app',
        components: {Sider}


    }
</script>
<style>


</style>

