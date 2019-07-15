<template>
  <Modal :value="show" width="1000" class="demo-tabs-style1" :closable="false" :transfer="false" @on-cancel="cancel">
      <Tabs type="card">
        <TabPane label="游戏币来源">

        <Table size="small" :loading="loading" border :columns="scolumns" :data="stableDatas" stripe></Table>

        </TabPane>

        <TabPane label="游戏信息">
          <Table size="small" :loading="loading" border ref="selection" :columns="columns" :data="tableDatas" stripe></Table>

          <Page :total="total" :page-size-opts="[20,50,100]" :current="current" class-name="margin-top-10"  size="small" @on-change="pageChange" @on-page-size-change="pageSizeChange" show-total show-elevator show-sizer :page-size="20" class="margin-top-10"></Page>

        </TabPane>

      </Tabs>
      <div slot="footer" style="color:#f60;text-align:center">
        <!-- <Button type="default" @click="cancel">取消</Button>
        <Button type="primary" @click="toEdit('formValidate')" :loading="loading">确定</Button> -->
      </div>
    </Modal>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false
    },
    loading: {
      type: Boolean,
      default: false
    },
    columns: {
      type: Array
    },
    tableDatas: {
      type: Array
    },
    scolumns: {
      type: Array
    },
    stableDatas: {
      type: Array
    },
    total: {
      type: Number,
      default: 0
    },
    current: {
      type: Number,
      default: 1
    }
  },
  data () {
    return {
      // show: this.showFlag
    }
  },
  methods: {
    pageChange (page) {
      this.$emit('page-change', page)
    },
    pageSizeChange (perPage) {
      this.$emit('page-size-change', perPage)
    },
    cancel () {
      this.$emit('cancel')
    }
  }
}
</script>
