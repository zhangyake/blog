<template>
    <div>
        <Row :gutter="16">
            <Col span="4">
            <Button @click="showAddModal" type="primary">新增友链</Button>
            </Col>
            <Col :xs="{ span: 14, offset: 2 }" :sm="{ span: 8, offset: 8}" :md="{ span: 6, offset: 10 }" :lg="{ span: 4, offset: 12 }">
            <Form label-position="right" :label-width="60">
                <FormItem label="名字:" class="">
                    <Input type="text" v-model="query.name" placeholder="Enter user name"></Input>
                </FormItem>
            </Form>
            </Col>
            <Col span="4">
            <Button type="primary" @click="toQuery" :loading="queryLoading">查询</Button>
            </Col>
        </Row>

        <Table :loading="queryLoading" border ref="selection" :columns="columns" :data="tableDatas" stripe @on-select-all="selectAlldata"></Table>

        <Page :total="total" class-name="margin-top-10" @on-page-size-change="pageSizeChange" @on-change="pageChange" size="small" show-total show-elevator show-sizer :page-size="10" class="margin-top-10"></Page>

        <Modal v-model="showEdit" title="编辑友链" @on-ok="toEdit" @on-cancel="cancel" width="480">
            <Form :model="editRow" ref="editFormValidate" label-position="right" :label-width="140">
                <FormItem label="链接名" prop="name" :rules="{ required: true, message: '请输入链接名', trigger: 'blur' }">
                    <Input v-model="editRow.name" style="width:200px"></Input>
                </FormItem>
                <FormItem label="链接" prop="link" :rules="{ required: true, message: '请输入链接地址', trigger: 'blur' }">
                    <Input v-model="editRow.link" style="width:200px"></Input>
                </FormItem>
                <FormItem label="图片地址" prop="image">
                    <Input v-model="editRow.image" style="width:200px"></Input>
                </FormItem>

            </Form>
        </Modal>

        <Modal v-model="showAdd" title="新增友链" width="480">
            <Form :model="addRow" ref="formValidate" :rules="ruleValidate" label-position="right" :label-width="140">
                <FormItem label="链接名" prop="name">
                    <Input v-model="addRow.name" style="width:200px"></Input>
                </FormItem>
                <FormItem label="链接" prop="link">
                    <Input v-model="addRow.link" style="width:200px"></Input>
                </FormItem>
                <FormItem label="图片地址" prop="image">
                    <Input v-model="addRow.image" style="width:200px"></Input>
                </FormItem>
                <FormItem label="是否开启" prop="status">
                    <i-switch v-model="addRow.status" size="large">
                        <span slot="open">启用</span>
                        <span slot="close">禁用</span>
                    </i-switch>
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
                    title: "图片",
                    width: 80,
                    key: "image",
                    render: (h, params) => {
                        return h("div", [
                            h("Avatar", {
                                props: {
                                    src: params.row.image,
                                    shape: "square",
                                    size: "large"
                                }
                            })
                        ]);
                    }
                },
                {
                    title: "链接名",
                    key: "name"
                },
                {
                    title: "链接",
                    key: "link"
                },
                {
                    title: "状态",
                    key: "status",
                    width: 90,
                    render: (h, params) => {
                        return h("div", [
                            h("i-switch", {
                                props: {
                                    value: params.row.status === 1,
                                    size: "large"
                                },
                                scopedSlots: {
                                    open: () => {
                                        return "启用";
                                    },
                                    close: () => {
                                        return "禁用";
                                    }
                                },
                                on: {
                                    "on-change": status => {
                                        this.changeStatus(params.index);
                                    }
                                }
                            })
                        ]);
                    }
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
                name: [
                    { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                ],
                link: [
                    { required: true, message: 'The link cannot be empty', trigger: 'blur' },
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
                const result = await this.$store.dispatch("GetLinkList", data);
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
                    let data = {...this.addRow}
                    data.status = data.status === true ? 1:0;
                    this.add(data)
                } else {
                    this.$Message.error('Fail!');
                }

            })
        },
        async add(data) {
            try {
                this.loading = true
                await this.$store.dispatch("AddLink", data);
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
                await this.$store.dispatch("UpdateLink", data);
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
