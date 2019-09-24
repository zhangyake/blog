<template>
  <page-view>
    <a-card :bordered="false" class="ant-pro-components-tag-select">
      <div class="table-page-search-wrapper">
        <a-form layout="inline">
          <a-row :gutter="48">
            <a-col
                    :md="6"
                    :sm="24"
            >
              <a-form-item label="关键词">
                <a-input v-model="queryParam.keyword" />
              </a-form-item>
            </a-col>
            <a-col
                    :md="6"
                    :sm="24"
            >
              <a-form-item label="文章状态">
                <a-select
                        v-model="queryParam.status"
                        placeholder="请选择文章状态"
                        @change="handleQuery"
                >
                  <!--<a-select-option-->
                          <!--v-for="status in Object.keys(postStatus)"-->
                          <!--:key="status"-->
                          <!--:value="status"-->
                  <!--&gt;{{ postStatus[status].text }}</a-select-option>-->
                </a-select>
              </a-form-item>
            </a-col>
            <a-col
                    :md="6"
                    :sm="24"
            >
              <a-form-item label="分类目录">
                <a-select
                        v-model="queryParam.categoryId"
                        placeholder="请选择分类"
                        @change="handleQuery"
                >
                  <a-select-option
                          v-for="category in categories"
                          :key="category.id"
                  >{{ category.name }}</a-select-option>
                </a-select>
              </a-form-item>
            </a-col>

            <a-col
                    :md="6"
                    :sm="24"
            >
              <span class="table-page-search-submitButtons">
                <a-button
                        type="primary"
                        @click="handleQuery"
                >查询</a-button>
                <a-button
                        style="margin-left: 8px;"
                        @click="handleResetParam"
                >重置</a-button>
              </span>
            </a-col>
          </a-row>
        </a-form>
      </div>


    </a-card>

    <div class="ant-pro-pages-list-projects-cardList">
      <a-list :loading="loading" :data-source="data" :grid="{ gutter: 24, xl: 4, lg: 3, md: 3, sm: 2, xs: 1 }">
        <a-list-item slot="renderItem" slot-scope="item">
          <a-card class="ant-pro-pages-list-projects-card" hoverable>
            <img slot="cover" src="http://lorempixel.com/400/200/" :alt="item.title" />
            <a-card-meta :title="item.title">
              <template slot="description">
                <ellipsis :length="50">{{ item.preview }}</ellipsis>
              </template>
            </a-card-meta>
            <div class="cardItemContent">
              <span>{{ item.updated_at | fromNow }}</span>
              <div class="avatarList">
                <avatar-list size="mini">
                  <avatar-list-item
                    v-for="(member, i) in item.members"
                    :key="`${item.id}-avatar-${i}`"
                    :src="member.avatar"
                    :tips="member.name"
                  />
                </avatar-list>
              </div>
            </div>
          </a-card>
        </a-list-item>
      </a-list>
    </div>
  </page-view>
</template>

<script>
  import { PageView } from '@/layouts'
import moment from 'moment'
import { TagSelect, StandardFormRow, Ellipsis, AvatarList } from '@/components'
const TagSelectOption = TagSelect.Option
const AvatarListItem = AvatarList.AvatarItem

export default {
  components: {
    PageView,
    AvatarList,
    AvatarListItem,
    Ellipsis,
    TagSelect,
    TagSelectOption,
    StandardFormRow
  },
  data () {
    return {
      queryParam:{},
      data: [],
      form: this.$form.createForm(this),
      loading: true
    }
  },
  filters: {
    fromNow (date) {
      return moment(date).fromNow()
    }
  },
  mounted () {
    this.getList()
  },
  methods: {
    handleQuery(){

    },
    handleResetParam(){

    },
    handleChange (value) {
      console.log(`selected ${value}`)
    },
    getList () {
      this.$api.getArticleList().then(res => {
        console.log('res', res)
        this.data = res.data
        this.loading = false
      })
    }
  }
}
</script>

<style lang="less" scoped>
.ant-pro-components-tag-select {
  /deep/ .ant-pro-tag-select .ant-tag {
    margin-right: 24px;
    padding: 0 8px;
    font-size: 14px;
  }
}
.ant-pro-pages-list-projects-cardList {
  margin-top: 24px;

  /deep/ .ant-card-meta-title {
    margin-bottom: 4px;
  }

  /deep/ .ant-card-meta-description {
    height: 44px;
    overflow: hidden;
    line-height: 22px;
  }

  .cardItemContent {
    display: flex;
    height: 20px;
    margin-top: 16px;
    margin-bottom: -4px;
    line-height: 20px;

    > span {
      flex: 1 1;
      color: rgba(0,0,0,.45);
      font-size: 12px;
    }

    /deep/ .ant-pro-avatar-list {
      flex: 0 1 auto;
    }
  }
}
</style>
