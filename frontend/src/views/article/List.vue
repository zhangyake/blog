<template>
  <a-card :bordered="false">

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
                <!-- <a-select-option
                  v-for="status in Object.keys(postStatus)"
                  :key="status"
                  :value="status"
                >{{ postStatus[status].text }}</a-select-option> -->
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
                <!-- <a-select-option
                  v-for="category in categories"
                  :key="category.id"
                >{{ category.name }}</a-select-option> -->
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

    <!-- <div class="table-operator">
      <a-button
        type="primary"
        icon="plus"
        @click="$refs.createModal.show()">新建</a-button>
    </div> -->

    <a-table
      :columns="columns"
      :dataSource="tableDatas"
      :rowKey="(record)=>record.id"
      :pagination="pagination"
      :loading="loading"
      @change="handleChange">
      <template slot="headImgUrl" slot-scope="text">
        <a-avatar shape="square" :src="text" />
      </template>
      <span slot="createTime" slot-scope="text">
        {{ text|moment }}
      </span>
      <template
        slot="operation"
        slot-scope="text, record">
        <div class="editable-row-operations">
          <span>
            <a @click="handleEdit(record)">编辑</a>
          </span>
        </div>
      </template>
    </a-table>

  </a-card>
</template>
<script>
// import CreateForm from './modules/CreateForm'
// import EditForm from './modules/EditForm'

const columns = [{
  title: '#ID',
  dataIndex: 'id',
  align: 'center'
},
{
  title: '文章标题',
  dataIndex: 'title'

},
{
  title: '状态',
  dataIndex: 'status'
},
// {
//   title: '标签',
//   dataIndex: 'phone'
// },
{
  title: '访问次数',
  dataIndex: 'read_count'

},
{
  title: '评论次数',
  dataIndex: 'comment_count'
},
{
  title: '创建时间',
  dataIndex: 'create_at',
  scopedSlots: { customRender: 'createTime' }
},
{
  title: '操作',
  dataIndex: 'operation',
  scopedSlots: { customRender: 'operation' }
}
]

export default {
  components: {

  },
  data () {
    return {
      times: [],
      queryParam: {},
      tableDatas: [],
      pagination: { total: 0 },
      page: 1,
      pageSize: 10,
      loading: true,
      columns
    }
  },
  mounted () {
    this.init()
  },
  methods: {
    init () {
      this.page = 1
      this.pageSize = 10
      this.handleQuery({ ...this.queryParam })
    },
    handleResetParam () {

    },
    handleQuery (query) {
      if (this.times.length === 2) {
        // query.startTime = this.times[0]
        // query.endTime = this.times[1]
        query.startTime = this.times[0].format('YYYY-MM-DD 00:00:00')
        query.endTime = this.times[1].format('YYYY-MM-DD 23:59:59')
      }
      this.loading = true
      this.$api.getArticleList({ page: this.page, pageSize: this.pageSize, ...query }).then(res => {
        this.tableDatas = res.data ? res.data : []
        this.pagination.total = res.meta.total
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
      this.handleQuery()
    }

  }
}
</script>
<style scoped>
.editable-row-operations a {
  margin-right: 8px;
}
</style>
