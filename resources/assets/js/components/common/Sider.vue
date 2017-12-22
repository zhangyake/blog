<template>
    <div>
        <mu-appbar title="" class="app-bar">
            <mu-icon-button icon="menu" slot="left" label="toggle drawer" @click="toggle(true)"/>
            <mu-avatar src="/images/uicon.jpg" slot="right"/>
            <span slot="left">Yake's Blog</span>
        </mu-appbar>
        <mu-drawer :open="open" :docked="docked" @close="toggle()" width="40%">
            <mu-menu>
                <mu-menu-item title="主页" leftIcon="home" @click="routerTo('Home')"/>
                <mu-menu-item title="标签" leftIcon="label" @click="routerTo('Tag')"/>
                <mu-menu-item title="归档" leftIcon="content_copy" @click="routerTo('Type')"/>
                <mu-divider/>
                <mu-menu-item title="关于" leftIcon="person" @click="routerTo('About')"/>
            </mu-menu>
        </mu-drawer>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                open: false,
                docked: true,
            }
        },
        methods: {
            toggle(flag) {
                this.open = !this.open;
                this.docked = !flag;
            },
            routerTo(name) {
                this.$router.push({name});
                this.open = false;
            }
        }
    }
</script>
<style lang="less" scoped>

    .demo-infinite-container {
        width: 100%;
        height: 100%;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #d9d9d9;
    }

    .app-bar {
        position: fixed;
        top: 0;
    }
</style>