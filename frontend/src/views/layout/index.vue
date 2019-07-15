<template>
  <div class="layout">
    <sidebar class="layout-sidebar"
             :style="{ width: (shrink? '64px' : '256px')}"
             :menu-list="menuList"
             :shrink="shrink"
             :open-names="openedSubmenuArr"
             @on-select="handelSelect"
             @on-open-change="handelOpenChange">
      <div slot="logo"
           class="sidebar-logo"
           v-show="!shrink"> Vue-Blog后台管理系统 </div>
    </sidebar>
    <div class="layout-container"
         :style="{ left: (shrink? '64px' : '256px')}">
      <layout-header class="layout-header"></layout-header>
      <div class="layout-tags">
        <tags-view></tags-view>
      </div>

      <layout-main class="layout-main"></layout-main>
    </div>

  </div>
</template>

<script>
  import layoutMain from './components/main'
  import tagsView from './components/tagsView'
  import layoutHeader from './components/header'
  import sidebar from './components/sidebar'
  export default {
    name: 'layout',
    components: {
      layoutMain,
      tagsView,
      layoutHeader,
      sidebar
    },
    data () {
      return {}
    },
    props: {},
    computed: {
      openedSubmenuArr () {
        return this.$store.state.app.openedSubmenuArr
      },
      menuList () {
        return this.$store.getters.menuList
      },
      shrink () {
        return this.$store.state.app.shrink
      }
    },
    methods: {
      init () {
        this.$store.commit('addOpenSubmenu', this.$route.matched[0].name)
        this.$store.commit('addOpenTag', this.$route)
      },
      handelOpenChange (openNames) {
        this.$store.commit('setOpenSubMenu', openNames)
      },
      handelSelect (name) {
        this.$router.push({ name })
      },
      linkTo (name) {
        this.$router.push({ name })
      }
    },
    watch: {
      $route (to) {
        this.$store.commit('addOpenSubmenu', to.matched[0].name)
        this.$store.commit('addOpenTag', to)
      }
    },
    mounted () {
      this.init()
    },
    created () { }
  }
</script>

<style lang="less" scoped>
  .layout {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    .layout-sidebar {
      position: absolute;
      text-align: left;
      background: #001529;
      top: 0;
      left: 0;
      height: 100%;
      overflow: hidden;
      .sidebar-logo {
        text-align: center;
        line-height: 30px;
        font-size: 15px;
        height: 30px;
        margin: 10px 20px;
        // background: #2d8cf0;
        color: #2d8cf0;
        font-weight: 600;
        // background-image: url('https://iview.github.io/iview-admin/dist/9f35d093728efc834cf6f8b15fd17eea.jpg');
      }
    }
    .layout-container {
      position: absolute;
      background-color: #fff;
      right: 0;
      height: 100%;
      display: flex; /*设为伸缩容器*/
      flex-direction: column;
      .layout-header {
        flex: 0 0 50px;
        box-sizing: border-box;
        border-bottom: 1px solid #ebebeb;
      }
      .layout-tags {
        flex: 0 0 36px;
        background: #ebebeb;
        padding-left: 5px;
      }
      .layout-main {
        flex: 1;
        background-color: #fff;
        overflow: auto;
        padding-left: 20px;
        padding-right: 30px;
        //  padding: 10px;
      }
    }
  }
</style>
