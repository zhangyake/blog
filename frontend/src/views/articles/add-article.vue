<style>
/*@import "simplemde/dist/simplemde.min.css";*/
/*@import "highlight.js/styles/atom-one-dark.css";*/
@import "./markdown.css";
.add-new-tag-con {
  margin-top: 20px;
  border-top: 1px dashed #dbdddf;
  padding: 20px 0;
  height: 60px;
  overflow: hidden;
}
.add-new-tag-enter {
  height: 0;
  margin-top: 0;
  padding: 0px 0;
}
.add-new-tag-enter-active,
.add-new-tag-leave-active {
  transition: all 0.3s;
}
.add-new-tag-enter-to {
  height: 60px;
  margin-top: 20px;
  padding: 20px 0;
}
.add-new-tag-leave {
  height: 60px;
  margin-top: 20px;
  padding: 20px 0;
}
.add-new-tag-leave-to {
  height: 0;
  margin-top: 0;
  padding: 0px 0;
}
.margin-top-10 {
  margin-top: 10px;
}
.publish-button-con {
  border-top: 1px dashed #dbdddf;
  padding: 12px 0 0 0;
}

.markdown-editor .CodeMirror {
  height: 500px;
}
.CodeMirror-fullscreen {
  z-index: 901;
}
</style>

<template>
    <div>
        <Form ref="formValidate" :model="addRow" :label-width="60">
            <Row :gutter="32">
                <Col span="16">
                <Card>
                    <Row>
                        <Col span="16" offset="4">

                        <FormItem label="标题" prop="title" :rules="{ required: true, message: '请输入标题', trigger: 'blur' }">
                            <Row>
                                <Col span="18">
                                <Input placeholder="Enter 文章标题" name="title" v-model="addRow.title"></Input>
                                </Col>
                            </Row>
                        </FormItem>
                        <FormItem label="副标题" prop="subtitle" :rules="{ required: true, message: '请输入副标题', trigger: 'blur' }">
                            <Row>
                                <Col span="18">
                                <Input placeholder="Enter 文章副标题" v-model="addRow.subtitle"></Input>
                                </Col>
                            </Row>
                        </FormItem>

                        <FormItem label="页面图片" prop="page_image">
                            <Row>
                                <Col span="18">
                                <Input placeholder="可粘贴外部链接" v-model="addRow.page_image"> </Input>
                                </Col>
                                <Col span="6">
                                <Upload action="/api/upload" :on-success="uploadSuccess">
                                    <Button type="success">上传图片</Button>
                                </Upload>
                                </Col>
                            </Row>

                        </FormItem>

                        </Col>
                    </Row>
                    <!-- <a href="#" slot="extra">
                    <Icon type="ios-loop-strong"></Icon>
                    Change
                </a> -->
                    <markdown-editor v-model="content" :highlight="true" preview-class="markdown" ref="markdownEditor"></markdown-editor>

                    <!-- <div class="button-wrap">
      <button type="button" @click="handleOutputMARKDOWN">输出MARKDOWN</button>
      <button type="button" @click="handleOutputHTML">输出HTML</button>
      <pre v-text="output"></pre>
      <div v-html="output" v-show="type === 'html'" class="markdown"></div>
    </div> -->
                </Card>

                </Col>
                <Col span="6">
                <Card>
                    <p slot="title">
                        <Icon type="paper-airplane"></Icon>
                        发布
                    </p>

                    <p class="margin-top-10">
                        <Icon type="ios-calendar-outline"></Icon>&nbsp;&nbsp;
                        <span v-if="publishTimeType === 'immediately'">立即发布</span>
                        <span v-else>定时：{{ publishTime }}</span>
                        <Button v-show="!editPublishTime" size="small" @click="handleEditPublishTime" type="text">修改</Button>
                        <transition name="publish-time">
                            <div v-show="editPublishTime" class="publish-time-picker-con">
                                <div class="margin-top-10">
                                    <DatePicker @on-change="setPublishTime" type="datetime" style="width:200px;" placeholder="选择日期和时间"></DatePicker>
                                </div>
                                <div class="margin-top-10">
                                    <Button type="primary" @click="handleSavePublishTime">确认</Button>
                                    <Button type="ghost" @click="cancelEditPublishTime">取消</Button>
                                </div>
                            </div>
                        </transition>
                    </p>
                    <Row class="margin-top-10 publish-button-con">
                        <!-- <span class="publish-button">
                            <Button @click="handlePreview" icon="eye">预览</Button>
                        </span> -->
                        <span class="publish-button">
                            <Button @click="toPublish('formValidate')" :loading="publishLoading" icon="ios-checkmark" style="width:90px;" type="primary">发布</Button>
                        </span>
                        <span class="publish-button">
                            <Button @click="handleSaveDraft('formValidate')">保存草稿</Button>
                        </span>

                    </Row>
                </Card>

                <div class="margin-top-10">
                    <Card>
                        <p slot="title">
                            <Icon type="navicon-round"></Icon>
                            文章分类
                        </p>
                        <FormItem label="" :label-width="1" prop="title" :rules="{ required: true, message: '请选择文章分类', trigger: 'blur' }">

                            <Row>
                                <Col span="18">
                                <Select v-model="categoryId" size="small" placeholder="请选择分类">
                                    <Option v-for="item in categories" :value="item.id" :key="item.id">{{ item.name }}</Option>
                                </Select>
                                </Col>
                            </Row>
                        </FormItem>
                        <!-- <CheckboxGroup v-model="offenUsedClassSelected" @on-change="setClassificationInOffen">
                        <span v-for="item in offenUsedClass" :key="item.id">
                            <Checkbox :label="item.id">{{ item.name }}</Checkbox>
                        </span>
                    </CheckboxGroup> -->

                    </Card>
                </div>
                <div class="margin-top-10">

                    <Card>
                        <p slot="title">
                            <Icon type="ios-pricetags-outline"></Icon>
                            标签
                        </p>
                        <FormItem label="" :label-width="1" prop="title" :rules="{ required: true, message: '请选择文章标签', trigger: 'blur' }">

                            <Row>
                                <Col span="18">

                                <Select v-model="tagIds" multiple size="small">
                                    <Option v-for="item in tags" :value="item.id" :key="item.id">{{ item.name }}</Option>
                                </Select>
                                </Col>
                                <Col span="6">
                                <Button type="primary" v-show="!addingNewTag" @click="handleAddNewTag" size="small">新建</Button>
                                </Col>
                            </Row>
                        </FormItem>
                        <transition name="add-new-tag">
                            <div v-show="addingNewTag" class="add-new-tag-con">
                                <Col span="14">
                                <Input v-model="newTagName" size="small" placeholder="请输入标签名" />
                                </Col>
                                <Col span="5">
                                <Button @click="createNewTag" size="small" type="primary">确定</Button>
                                </Col>
                                <Col span="5">
                                <Button @click="cancelCreateNewTag" size="small" type="ghost">取消</Button>
                                </Col>
                            </div>
                        </transition>
                    </Card>

                </div>

                </Col>
            </Row>
        </Form>
    </div>
</template>
<script>

import markdownEditor from 'vue-simplemde/src/markdown-editor';
import hljs from "highlight.js";
window.hljs = hljs;

export default {
    components: {
        markdownEditor,
    },
    data() {
        return {
            addRow: {},
            addingNewTag: false,
            newTagName: "",
            publishTime: "",
            publishTimeType: "immediately",
            editPublishTime: false, // 是否正在编辑发布时间,
            publishLoading: false,
            categoryId: '', // 常用目录选中的目录
            classificationFinalSelected: [], // 最后实际选择的目录
            content: '',
            output: '',
            type: 'html',
            categories: [],
            tags: [

            ],
            tagIds: [],
            offenUsedClass: []
        };
    },
    mounted() {
        this.allTags()
        this.allCategories()
    },
    computed: {
        simplemde() {
            return this.$refs.markdownEditor.simplemde;
        },

    },
    methods: {
        async  allTags() {
            try {
                const res = await this.api.getTagList({ per_page: 100, fields: 'select:id|tag' });
                this.tags = res.data
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
        async  allCategories() {
            try {
                const res = await this.api.getCategoryList({ per_page: 100, fields: 'select:id|tag' });
                this.categories = res.data
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
        setClassificationInOffen(selectedArray) {
            this.classificationFinalSelected = selectedArray;
        },
        handleAddNewTag() {
            this.addingNewTag = !this.addingNewTag;
        },
        createNewTag() {
            if (this.newTagName.length !== 0) {
                this.addingNewTag = false;
                setTimeout(() => {
                    this.newTagName = "";
                }, 200);
            } else {
                this.$Message.error("请输入标签名");
            }
        },
        cancelCreateNewTag() {
            this.newTagName = "";
            this.addingNewTag = false;
        },
        handleEditPublishTime() {
            this.editPublishTime = !this.editPublishTime;
        },
        setPublishTime(datetime) {
            this.publishTime = datetime;
        },
        handleSavePublishTime() {
            this.publishTimeType = "timing";
            this.editPublishTime = false;
        },
        cancelEditPublishTime() {
            this.publishTimeType = "immediately";
            this.editPublishTime = false;
        },
        handlePreview() {
            this.$store.state.app.md = this.simplemde.value();
            this.$router.push({ name: "preview_article" });
        },
        toPublish(name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    const data = {
                        ...this.addRow,
                        content: this.content,
                        category_id: this.categoryId,
                        tag_ids: this.tagIds,
                        published_at:this.publishTime,
                        status: this.publishTime? 0:1
                    }
                    this.handlePublish(data)
                } else {
                    this.$Message.error('请填写必填内容!');
                }

            })
        },
        async handlePublish(data) {

            try {
                this.$Spin.show();
                this.publishLoading = true
                await this.api.addArticle(data);
                this.publishLoading = false
                this.$Spin.hide();
                this.$Message.success("保存成功!");
                this.$router.push({name:'articles_index'})
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
        handleSaveDraft(name) {
             this.$refs[name].validate((valid) => {
                if (valid) {
                    const data = {
                        ...this.addRow,
                        content: this.content,
                        category_id: this.categoryId,
                        tag_ids: this.tagIds,
                        status: 0,
                    }
                    this.handlePublish(data)
                } else {
                    this.$Message.error('请填写必填内容!');
                }

            })
         },
        handleOutputHTML() {
            this.type = 'html';
            this.output = this.simplemde.markdown(this.content);
        },
        handleOutputMARKDOWN() {
            this.type = 'markdown';
            this.output = this.content;
        },
        uploadSuccess( response, file, fileList){
// console.log(response,file,fileList)
this.$set(this.addRow, 'page_image', response.data)

        }
    }
};
</script>
