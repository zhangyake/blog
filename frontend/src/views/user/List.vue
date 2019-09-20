<template>
  <a-card :bordered="false">

    <div class="table-page-search-wrapper">
      <a-form layout="inline">
        <a-row :gutter="48">
          <a-col
            :md="8"
            :sm="24">
            <a-form-item label="手机号">
              <a-input
                v-model="queryParam.phone"
                placeholder="" />
            </a-form-item>
          </a-col>
          <a-col
            :md="8"
            :sm="24">
            <a-form-item label="创建时间">
              <a-range-picker v-model="times" />
            </a-form-item>
          </a-col>

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
      <!-- <template
        slot="operation"
        slot-scope="text, record">
        <div class="editable-row-operations">
          <span>
            <a @click="handleEdit(record)">编辑</a>
          </span>
        </div>
      </template> -->
    </a-table>
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

const columns = [{
  title: '#ID',
  dataIndex: 'id',
  align: 'center'
},
{
  title: '头像',
  dataIndex: 'headImgUrl',
  scopedSlots: { customRender: 'headImgUrl' }
},
{
  title: '微信昵称',
  dataIndex: 'nickname'
},
{
  title: '手机号',
  dataIndex: 'phone'
},
{
  title: '性别',
  dataIndex: 'sex',
  customRender: (text) => {
    return text === 0 ? '未知' : (text === 1 ? '男' : '女')
  }

},
{
  title: '城市',
  dataIndex: 'city'
},
{
  title: '省份',
  dataIndex: 'province'
},
{
  title: '余额',
  dataIndex: 'balance'
}, {
  title: '创建时间',
  dataIndex: 'createTime',
  scopedSlots: { customRender: 'createTime' }
}
//  {
//   title: '操作',
//   dataIndex: 'operation',
//   scopedSlots: { customRender: 'operation' }
// }
]

export default {
  components: {
    CreateForm,
    EditForm
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
      this.queryList({ ...this.queryParam })
    },
    queryList (query) {
      if (this.times.length === 2) {
        // query.startTime = this.times[0]
        // query.endTime = this.times[1]
        query.startTime = this.times[0].format('YYYY-MM-DD 00:00:00')
        query.endTime = this.times[1].format('YYYY-MM-DD 23:59:59')
      }
      this.loading = true
      this.$api.getUserList({ page: this.page, pageSize: this.pageSize, ...query }).then(res => {
        this.tableDatas = res.data.hasOwnProperty('list') ? res.data.list : []
        this.pagination.total = res.data.hasOwnProperty('total') ? res.data.total : 0
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
<style scoped>
.editable-row-operations a {
  margin-right: 8px;
}
</style>
