<template>

  <div class="page-header-index-wide antd-pro-pages-home ">

    <a-row :gutter="24">

      <a-col :md="24" :lg="18">
        <a-card :bordered="false" :bodyStyle="{ padding: '16px 24px', height: '100%' }" style="margin-bottom: 18px">

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
                <a-list-item-meta style="align-content:center;" @click="$router.push({name:'article',params:{id:item.id}})">
                  <a-avatar slot="avatar" :src="item.avatar" />

                  <span slot="title" >{{ item.title }}</span>

                </a-list-item-meta>

              </a-skeleton>
            </a-list-item>
          </a-list>
        </a-card>
      </a-col>

      <a-col :md="24" :lg="6">
        <a-card :bordered="false" style="margin-bottom: 18px" :bodyStyle="{padding:'14px 24px'}" >
          <template slot="title" >社区规范</template>
          <div style="min-height: 120px;">
            Laravel 是优雅的 PHP Web 开发框架。具有高效、简洁、富于表达力等优点。采用 MVC 设计，是崇尚开发效率的全栈框架。是最受关注的 PHP 框架。
          </div>
          <a-row type="flex" justify="space-around">
            <a-col span="12">
              <a-button icon="share-alt">分享动态</a-button>
            </a-col>
            <a-col span="12">
              <a-button icon="edit">发布文章</a-button>
            </a-col>

          </a-row>
        </a-card>

        <a-card title="友情推荐" style="margin-bottom: 18px" :bordered="false" :body-style="{ padding: 0 }">
          <div style="min-height: 400px;">

          </div>
        </a-card>

        <a-card :loading="loading" title="团队" :bordered="false">
          <div class="members">
            <a-row>
              <a-col :span="12" v-for=" index in 1" :key="index">

              </a-col>
            </a-row>
          </div>
        </a-card>
      </a-col>

    </a-row>

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
  //  @import url('../../components/global.less');
  .antd-pro-pages-home {

    /deep/ .ant-card-head {
      // border-top: 2px  solid @primary-color ;
      // border-radius: 5px 5px 0 0;
      min-height: 44px;
       .ant-card-head-title {
         padding: 8px 0;
       }
    }
  }

</style>
