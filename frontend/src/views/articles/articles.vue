<template>
    <div>
      


<Tabs type="card" @on-click="handleTabsClick">
        <TabPane label="全部文章 " name="all">  <Row :gutter="16">
            
            <Col span="4">
            <Form label-position="right" :label-width="0">
                <FormItem label="" class="">
                    <Input type="text" v-model="query.name" placeholder="输入文章名称搜索"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="4">
            <Button type="primary" @click="toQuery('')" :loading="queryLoading" icon="ios-search">查询</Button>
            </Col>
        </Row>
        
           <Table :loading="queryLoading"  ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>


        
        </TabPane>
        <TabPane label="已发布" name="1"> <Row :gutter="16">
            
            <Col span="4">
            <Form label-position="right" :label-width="0">
                <FormItem label="" class="">
                    <Input type="text" v-model="query.name" placeholder="输入文章名称搜索"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="4">
            <Button type="primary" @click="toQuery(1)" :loading="queryLoading" icon="ios-search">查询</Button>
            </Col>
        </Row>
        
           <Table :loading="queryLoading"  ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>

</TabPane>
        <TabPane label="草稿箱" name="0"> <Row :gutter="16">
            
            <Col span="4">
            <Form label-position="right" :label-width="0">
                <FormItem label="" class="">
                    <Input type="text" v-model="query.name" placeholder="输入文章名称搜索"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="4">
            <Button type="primary" @click="toQuery(0)" :loading="queryLoading" icon="ios-search">查询</Button>
            </Col>
        </Row>
        
           <Table :loading="queryLoading"  ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>

</TabPane>
        <TabPane label="回收站" name="2"> <Row :gutter="16">
            
            <Col span="4">
            <Form label-position="right" :label-width="0">
                <FormItem label="" class="">
                    <Input type="text" v-model="query.name" placeholder="输入文章名称搜索"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="4">
            <Button type="primary" @click="toQuery(2)" :loading="queryLoading" icon="ios-search">查询</Button>
            </Col>
        </Row>
        
           <Table :loading="queryLoading"  ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>

</TabPane>
    </Tabs>
             <Page :total="total" class-name="margin-top-10" @on-page-size-change="pageSizeChange" @on-change="pageChange" size="small" show-total show-elevator show-sizer :page-size="10" class="margin-top-10"></Page>


    </div>
</template>
<script>
export default {
    data() {
        return {
            queryLoading: false,
            loading: false,
            query: { name: '' },
            page: 1,
            per_page: 10,
            total: 0,
            showEdit: false,
            showAdd: false,
            addRow: {status:true},
            editRow: {},
            columns: [
                {
                    type: "selection",
                    width: 60,
                    align: "center"
                },
                {
                    title: "ID",
                    width: 60,
                    key: "id"
                },
                {
                    title: "标题",
                    key: "title"
                },
                {
                    title: "作者",
                    key: "subtitle"
                },
                {
                    title: "状态",
                    key: "state",
                    align: "center",
                    width: 160,
                    render: (h, params) => {
                        return h("div",[
                            h('Tag',{ props: {
                                color: params.row.state==0?'blue':( params.row.state==1?'success':'error')}
                            },params.row.state_txt)
                        ],);
                    }
                },
                {
                    title: "发布时间",
                    key: "created_at"
                },
                {
                    title: "操作",
                    key: "action",
                    render: (h, params) => {
                        return h("div", [
                            h(
                                "Button",
                                {
                                    props: {
                                        type: "error",
                                        icon: "compose",
                                        size: "small"
                                    },
                                    style: {
                                        marginRight: "5px"
                                    },
                                    on: {
                                        click: () => {
                                            this.toEditView(params.index);
                                        }
                                    }
                                },
                                "编辑"
                            )
                        ]);
                    }
                }
            ],
            tableDatas: [],

            ruleValidate: {

            }
        };
    },
    mounted() {
        // this.init();
    },
    computed: {},
    methods: {
        init() {
            this.queryList();
        },
        pageChange(page) {
            this.page = page;
            this.queryList();
        },
        pageSizeChange(per_page) {
            this.per_page = per_page;
            this.queryList();
        },
        async queryList(status) {
            try {
                this.queryLoading = true

                const data = {
                    page: this.page,
                    per_page: this.per_page,
                    name: this.query.name,
                    state:status
                }
                const result = await this.api.getArticleList(data);
                this.queryLoading = false
                this.tableDatas = result.data;
                this.total = result.meta.total;
            } catch (error) {
                const response = error.response;
                if (response) {
                    if (response.status === 401) {
                        this.$Message.error("你没有权限!");
                    }
                    if (response.status === 500) {
                        this.$Message.error("系统繁忙，请稍后再试!");
                    }
                }
            }
        },
        changeStatus(index) {
            const data = { id: this.tableDatas[index].id, status: this.tableDatas[index].status === 1 ? 0 : 1 }
            this.saveEdit(data);
        },
        show(index) {
            this.modal1 = true;
            this.$Message.info("当前查看索引" + index);
            this.editRow = this.tableDatas[index];
            console.log(this.editRow);
        },
        selectAlldata(datas) {
            this.$Message.success("选择了全部");
            console.log(datas);
        },
        toRoute(name){
               this.$router.push({name})
        },
        toEditView(index){
        },
        toEdit() {
            this.saveEdit(this.editRow)
        },
        async saveEdit(data) {
            try {
                this.loading = true
                await this.api.updateArticle(data);
                this.loading = false
                this.$Message.success("修改成功!");
                this.toQuery()
            } catch (error) {
                const response = error.response;
                if (response) {
                    if (response.status === 401) {
                        this.$Message.error("你没有权限!");
                    }
                    if (response.status === 500) {
                        this.$Message.error("系统繁忙，请稍后再试!");
                    }
                }
            }

        },
        handleReset(name) {
            this.$refs[name].resetFields();
        },
        cancel() {
            console.log("cancel");
        },
        toQuery(status) {
            console.log(status)
            this.queryList(status);
        },
        handleTabsClick(name){
            if(name!=='all'){
                this.queryList(name)
            }else{
                this.queryList()
            }
           
        }

    }
};
</script>


<style lang="less" scoped>
.margin-top-10 {
  margin-top: 10px;
}
</style>
