<template>
    <div>
        <Row :gutter="16">
            <Col span="4">
            <Button @click="showAddModal" type="primary">创建标签</Button>
            </Col>
            <Col :xs="{ span: 14, offset: 2 }" :sm="{ span: 8, offset: 8}" :md="{ span: 6, offset: 10 }" :lg="{ span: 4, offset: 12 }">
            <Form label-position="right" :label-width="60">
                <FormItem label="标签名:" class="">
                    <Input type="text" v-model="query.tag" placeholder="Enter tag name"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="4">
            <Button type="primary" @click="toQuery" :loading="queryLoading">查询</Button>
            </Col>
        </Row>

        <Table :loading="queryLoading" border ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>

        <Page :total="total" class-name="margin-top-10" @on-page-size-change="pageSizeChange" @on-change="pageChange" size="small" show-total show-elevator show-sizer :page-size="10" class="margin-top-10"></Page>

        <Modal v-model="showEdit" title="修改标签" @on-ok="toEdit" @on-cancel="cancel" width="480">
            <Form :model="editRow" ref="editFormValidate" label-position="right" :label-width="140">
                <FormItem label="标签" prop="tag">
                    <Input v-model="editRow.tag" style="width:200px" disabled></Input>
                </FormItem>
                <FormItem label="标题" prop="title" :rules="{ required: true, message: '请输入邮箱地址', trigger: 'blur' }">
                    <Input v-model="editRow.title" style="width:200px"></Input>
                </FormItem>
                <FormItem label="描述">
                    <Input v-model="editRow.meta_description" style="width:200px" type="textarea" :autosize="{minRows: 2,maxRows: 4}"></Input>
                </FormItem>

            </Form>
        </Modal>

        <Modal v-model="showAdd" title="创建标签" width="480">
            <Form :model="addRow" ref="formValidate" :rules="ruleValidate" label-position="right" :label-width="140">
                <FormItem label="标签" prop="tag">
                    <Input v-model="addRow.tag" style="width:200px"></Input>
                </FormItem>
                <FormItem label="标题" prop="title">
                    <Input v-model="addRow.title" style="width:200px"></Input>
                </FormItem>
                <FormItem label="描述" prop="meta_description">
                    <Input v-model="addRow.meta_description" style="width:200px" type="textarea" :autosize="{minRows: 2,maxRows: 4}" placeholder="Enter something..."></Input>
                </FormItem>
            </Form>
            <div slot="footer" style="color:#f60;text-align:center">
                <Button type="default" @click="cancel">取消</Button>
                <Button type="primary" @click="toAdd('formValidate')" :loading="loading">保存</Button>
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
            query: { tag: '' },
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
                    title: "ID",
                    width: 60,
                    key: "id"
                },
                {
                    title: "标签",
                    key: "tag"
                },
                {
                    title: "标题",
                    key: "title"
                },
                {
                    title: "主要描述",
                    key: "meta_description"
                },
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
                tag: [
                    { required: true, message: 'The tag cannot be empty', trigger: 'blur' }
                ],
                title: [
                    { required: true, message: 'The title cannot be empty', trigger: 'blur' },
                ],
                meta_description: [
                    { required: true, message: 'The meta_description cannot be empty', trigger: 'blur' },
                ],
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
                const result = await this.api.getTagList(data);
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
                await this.api.addTag(data);
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
                await this.api.updateTag(data);
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
