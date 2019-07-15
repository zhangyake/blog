<!-- 中间主要布局 -->
<template>
  <div class="layout-content">
    <keep-alive>
      <router-view v-if="$route.meta.keepAlive"></router-view>
    </keep-alive>
    <router-view v-if="!$route.meta.keepAlive"></router-view>
  </div>
</template>

<script>

export default {
  // name: "content",
  components: {

  },
  data () {
    return {}
  },
  props: {},
  computed: {},
  methods: {},
  watch: {},
  created () { }
}
</script>

<style lang="less" scoped>
.layout-content {
  padding: 10px;
  // margin: 10px;
}
</style>
