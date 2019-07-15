<template>
  <div>
    <Form label-position="right"
          :label-width="70"
          inline>
      <FormItem :label-width="1">
        <Button type="primary"
                :loading="queryLoading"
                icon="ios-search">查询</Button>
      </FormItem>

    </Form>
    <Table :loading="queryLoading" 
           border
           ref="selection"
           :columns="columns"
           :data="tableDatas"
           stripe></Table>

    <Page :total="total" :page-size-opts="[20,30,50]"
          :current="page"
          class-name="margin-top-10"
          @on-page-size-change="pageSizeChange"
          @on-change="pageChange"
          size="small"
          show-total
          show-elevator
          show-sizer
          :page-size="20"
          class="margin-top-10"></Page>
  
  </div>
</template>
<script>
import { myMixin } from '@/utils/mixins.js'
export default {
  mixins: [myMixin],
  data () {
    return {
      queryLoading: false,
      loading: false,
      query: {  },
      datasTime: [],
      page: 1,
      per_page: 20,
      total: 0,
      showEdit: false,
      showAdd: false,
      addRow: {},
      editRow: {},
      columns: [
      ],
      tableDatas: [],
     
    }
  },
  mounted () {
    // this.init();
  },
  computed: {},
  methods: {

    pageChange (page) {
      this.page = page
      this.queryList()
    },
    pageSizeChange (perPage) {
      if (this.per_page !== perPage) {
        this.per_page = perPage
        // this.queryList()
      }
    },
 queryList(){

 }

  }
}
</script>

<style lang="less" scoped>
.margin-top-10 {
  margin-top: 10px;
}
</style>
