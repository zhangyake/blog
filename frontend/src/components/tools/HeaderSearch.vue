<template>
  <span class="header-search">

    <a-input-search placeholder="搜索" style="width: 200px;" @search="onSearch" />

  </span>
</template>

<script>
export default {
  name: 'HeaderSearch',
  data () {
    return {

    }
  },
  methods: {
    enterSearchMode () {

    },
    onSearch () {

    }
  }
}
</script>

<style lang="less">
  .header-search{
   /deep/ .ant-input {
    border-radius: 25px;
   }
  }
</style>
