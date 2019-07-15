<!-- 底部布局 -->
<template>
  <div class="layout-footer">
    <a class="footer-content"
       href="#">
      底部
    </a>
    <slot></slot>
  </div>
</template>

<script>
export default {
  // name: "footer",
  components: {},
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
.layout-footer {
  text-align: center;
  line-height: 50px;
  bottom: 0;
}
</style>
