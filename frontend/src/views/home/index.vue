<template>

  <div class="page-header-index-wide">
    <a-card :bordered="false" :bodyStyle="{ padding: '16px 24px', height: '100%' }" :style="{ height: '100%' }">

      <a-list
        itemLayout="horizontal"
        size="large"
        :dataSource="listData"

      >
        <a-list-item slot="renderItem" slot-scope="item, index" key="item.title">
          <template v-if="!loading" slot="actions" v-for="{type, text} in actions">
            <span :key="type">
              <a-icon :type="type" style="margin-right: 6px" />
              {{ item[text] }}
            </span>
          </template>
          <template v-if="!loading" slot="actions">
            <span>
              {{ item.created_at }}
            </span>
          </template>
          <a-skeleton :loading="loading" active avatar :title="false">
            <a-list-item-meta style="align-content:center;" >
              <a-avatar slot="avatar" :src="item.avatar" />

              <span slot="title" >{{ item.title }}</span>

            </a-list-item-meta>

          </a-skeleton>
        </a-list-item>
      </a-list>
    </a-card>
  </div>

</template>

<script>
import moment from 'moment'
import { mixinDevice } from '@/utils/mixin'

export default {
  data () {
    return {
      loading: true,
      listData: [],
      pagination: {},
      actions: [
        { type: 'star-o', text: 'read_count' },
        { type: 'like-o', text: 'like_count' },
        { type: 'message', text: 'comment_count' }
      ]
    }
  },
  mounted () {
    this.handleQuery()
  },
  methods: {
    onChange (checked) {
      this.loading = !checked
    },
    handleQuery (query) {
      this.loading = true
      this.$api.getArticleList({ }).then(res => {
        this.listData = res.data ? res.data : []
        this.pagination.total = res.meta.total
      }).finally(() => {
        setTimeout(() => {
          this.loading = false
        }, 300)
      })
    }
  }
}
</script>

<style lang="less" scoped>
  .extra-wrapper {
    line-height: 55px;
    padding-right: 24px;

    .extra-item {
      display: inline-block;
      margin-right: 24px;

      a {
        margin-left: 24px;
      }
    }
  }

  .antd-pro-pages-dashboard-analysis-twoColLayout {
    position: relative;
    display: flex;
    display: block;
    flex-flow: row wrap;

    &.desktop div[class^=ant-col]:last-child {
      position: absolute;
      right: 0;
      height: 100%;
    }
  }

  .antd-pro-pages-dashboard-analysis-salesCard {
    height: calc(100% - 24px);
    /deep/ .ant-card-head {
      position: relative;
    }
  }

  .dashboard-analysis-iconGroup {
    i {
      margin-left: 16px;
      color: rgba(0,0,0,.45);
      cursor: pointer;
      transition: color .32s;
      color: black;
    }
  }
  .analysis-salesTypeRadio {
    position: absolute;
    right: 54px;
    bottom: 12px;
  }
</style>
