<template>
  <a-card :bordered="false">

    <div class="table-page-search-wrapper">
      <a-form layout="inline">
        <a-row :gutter="48">
          <a-col
            :md="8"
            :sm="24">
            <a-form-item label="关键字">
              <a-input
                v-model="queryParam.searchText"
                placeholder="账号or手机号" />
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

    <a-table
      :columns="columns"
      :dataSource="tableDatas"
      :rowKey="(record)=>record.id"
      :pagination="pagination"
      :loading="loading"
      @change="handleChange">
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
  key: 'id',
  align: 'center'
}, {
  title: '账户',
  dataIndex: 'account'
}, {
  title: '手机号',
  dataIndex: 'phone'

}, {
  title: '描述',
  dataIndex: 'description',
  key: 'description'
}, {
  title: '创建时间',
  dataIndex: 'createTime',
  scopedSlots: { customRender: 'createTime' }
},
{
  title: '操作',
  dataIndex: 'operation',
  key: 'operation',
  scopedSlots: { customRender: 'operation' }
}]

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
      this.loading = true
      this.$api.getAdminUserList({ page: this.page, pageSize: this.pageSize, ...query }).then(res => {
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
