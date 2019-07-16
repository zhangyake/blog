<template>
    <div>
        <Row :gutter="16">
             <Col span="2">
            <Button @click="showAddModal" type="success" icon="ios-add">创建分类</Button>
            </Col>
            <Col span="4">
            <Form label-position="right" :label-width="0">
                <FormItem label="" class="">
                    <Input type="text" v-model="query.name" placeholder="Enter category name"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="12">
            <Button type="primary" @click="toQuery" icon="ios-search" :loading="queryLoading">查询</Button>
            </Col>
           
        </Row>

        <Table :loading="queryLoading"  ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>

        <!-- <Page :total="total" class-name="margin-top-10" @on-page-size-change="pageSizeChange" @on-change="pageChange" size="small" show-total show-elevator show-sizer :page-size="10" class="margin-top-10"></Page> -->

        <Modal v-model="showEdit" title="修改分类" @on-ok="toEdit" @on-cancel="cancel" width="480">
            <Form :model="editRow" ref="editFormValidate" label-position="right" :label-width="140">
                <FormItem label="名字" prop="name" :rules="{ required: true, message: '请输入名字', trigger: 'blur' }">
                    <Input v-model="editRow.name" style="width:200px"></Input>
                </FormItem>
                <!-- <FormItem label="路径" prop="path" :rules="{ required: true, message: '请输入路径地址', trigger: 'blur' }">
                    <Input v-model="editRow.path" style="width:200px"></Input>
                </FormItem>
                <FormItem label="描述" prop="description">
                    <Input v-model="editRow.description" style="width:200px" type="textarea" :autosize="{minRows: 2,maxRows: 4}"></Input>
                </FormItem> -->

            </Form>
        </Modal>

        <Modal v-model="showAdd" title="创建分类" width="480">
            <Form :model="addRow" ref="formValidate" :rules="ruleValidate" label-position="right" :label-width="140">
                <FormItem label="名字" prop="name">
                    <Input v-model="addRow.name" style="width:200px"></Input>
                </FormItem>
                <!-- <FormItem label="路径" prop="path">
                    <Input v-model="addRow.path" style="width:200px"></Input>
                </FormItem>
                <FormItem label="描述" prop="description">
                    <Input v-model="addRow.description" style="width:200px" type="textarea" :autosize="{minRows: 2,maxRows: 4}" placeholder="Enter something..."></Input>
                </FormItem> -->
            </Form>
            <div slot="footer" style="color:#f60;text-align:center">
                <Button type="default" @click="cancel">取消</Button>
                <Button type="success" @click="toAdd('formValidate')" :loading="loading">保存</Button>
            </div>
        </Modal>

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
            addRow: {},
            editRow: {},
            columns: [
                {
                    type: "selection",
                    width: 60,
                    align: "center"
                },
                {
                    title: "编号",
                    width: 60,
                    key: "id"
                },
                {
                    title: "分类名称",
                    key: "name"
                },
                // {
                //     title: "路径",
                //     key: "path"
                // },
                // {
                //     title: "描述",
                //     key: "description"
                // },
                {
                    title: "创建时间",
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
                                            this.showEditModal(params.index);
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
                name: [
                    { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                ],
                // path: [
                //     { required: true, message: 'The path cannot be empty', trigger: 'blur' },
                // ],
                // description: [
                //     { required: true, message: 'The description cannot be empty', trigger: 'blur' },
                // ],
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
        async queryList() {
            try {
                this.queryLoading = true

                const data = {
                    page: this.page,
                    per_page: this.per_page,
                    name: this.query.name
                }
                const result = await this.api.getCategoryList(data);
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
        showAddModal() {
            this.showAdd = true;
        },
        toAdd(name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    this.add(this.addRow)
                } else {
                    this.$Message.error('Fail!');
                }

            })
        },
        async add(data) {
            try {
                this.loading = true
                await this.api.addCategory(data);
                this.loading = false
                this.showAdd = false;
                this.$Message.success("添加成功!");
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
        showEditModal(index) {
            this.showEdit = true;
            this.editRow = { ...this.tableDatas[index] };
        },
        toEdit() {
            this.saveEdit(this.editRow)
        },
        async saveEdit(data) {
            try {
                this.loading = true
                await this.api.updateCategory(data);
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
        toQuery() {
            this.queryList();
        },

    }
};
</script>


<style lang="less" scoped>
.margin-top-10 {
  margin-top: 10px;
}
</style>
