<template>
  <a-card :bordered="false">

    <div class="table-page-search-wrapper">
      <a-form layout="inline">
        <a-row :gutter="48">
          <a-col
            :md="8"
            :sm="24">
            <a-form-item label="状态">
              <a-select
                placeholder="请选择"
                default-value=""
                v-model="queryParam.enable">
                <a-select-option value="">全部</a-select-option>
                <a-select-option :value="1">启用</a-select-option>
                <a-select-option :value="0">禁用</a-select-option>
              </a-select>
            </a-form-item>
          </a-col>
          <!-- <a-col
            :md="8"
            :sm="24">
            <a-form-item label="手机号">
              <a-input
                v-model="queryParam.phone"
                placeholder="" />
            </a-form-item>
          </a-col> -->

          <a-col
            :md=" 8 "
            :sm="24">
            <span class="table-page-search-submitButtons">
              <a-button
                type="primary"
                @click="init">查询</a-button>
              <a-button
                style="margin-left: 8px"
                @click="() => queryParam = {}">重置</a-button>

            </span>
          </a-col>
        </a-row>
      </a-form>
    </div>

    <div class="table-operator">
      <a-button
        type="primary"
        icon="plus"
        @click="$refs.createModal.show()">新建</a-button>
    </div>

    <div class="ant-pro-pages-list-projects-cardList">
    <a-list
            :grid="{ gutter: 24, xl: 4, lg: 3, md: 3, sm: 2, xs: 1 }"
            :dataSource="tableDatas"
    >
      <a-list-item slot="renderItem" slot-scope="item, index">
        <a-card class="ant-pro-pages-list-projects-card"
                hoverable

        >
          <img
                  alt="example"
                  src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
                  slot="cover"
          />
          <template class="ant-card-actions" slot="actions">
            {{item.name}}
          </template>
          <a-card-meta
                  title="Card title"
                  description="This is the description">
            <a-avatar slot="avatar" src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png" />
          </a-card-meta>
        </a-card>      </a-list-item>
    </a-list>
    </div>

    <create-form
      ref="createModal"
      @ok="queryList" />
    <edit-form
      ref="editModal"
      @ok="queryList" />

  </a-card>
</template>
<script>
import CreateForm from './modules/CreateForm'
import EditForm from './modules/EditForm'


export default {
  components: {
    CreateForm,
    EditForm
  },
  data () {
    return {
      queryParam: {},
      tableDatas: [],
      pagination: { total: 0 },
      page: 1,
      pageSize: 10,
      loading: false

    }
  },
  mounted () {
    this.init()
  },
  methods: {
    init () {
      this.page = 1
      this.pageSize = 10
      this.queryList({ ...this.queryParam })
    },
    queryList (query) {
      this.loading = true
      this.$api.getAllTags().then(res => {
        this.tableDatas = res.data
      }).finally(() => {
        setTimeout(() => {
          this.loading = false
        }, 300)
      })
    },
    handleEdit (record) {
      this.$refs.editModal.edit(record)
    },
    handleChange (pagination, filters, sorter) {
      this.page = pagination.current
      this.queryList()
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

