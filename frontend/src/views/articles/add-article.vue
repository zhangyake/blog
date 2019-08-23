/* eslint-disable vue/no-parsing-error */
<template>
  <div>
    <Form ref="formValidate"
          :model="addRow"
          :label-width="60">
      <Row :gutter="32">
        <Col span="16">
        <Card>
          <Row>
            <Col span="16"
                 offset="4">

            <FormItem label="标题"
                      prop="title"
                      :rules="{ required: true, message: '请输入标题', trigger: 'blur' }">
              <Row>
                <Col span="18">
                <Input placeholder="Enter 文章标题"
                       name="title"
                       v-model="addRow.title"></Input>
                </Col>
              </Row>
            </FormItem>

            <FormItem label="封面图片"
                      prop="page_image">
              <Row>
                <Col span="18">
                <Input placeholder="可粘贴外部链接"
                       v-model="addRow.page_image_url"> </Input>
                </Col>
                <Col span="6">
                <Upload action="/api/upload"
                        :on-success="uploadSuccess"
                        name="image"
                        :headers="headers">
                  <Button type="success">上传图片</Button>
                </Upload>
                </Col>
              </Row>

            </FormItem>

            </Col>
          </Row>

          <v-markdown :mdText="content"
                      :theme="theme"
                      fontSize="16px"
                      @md-change="mdChange"
                      @html-change="htmlChange"
                      @html-hljs-change="htmlHljsChange" />

        </Card>

        </Col>
        <Col span="6">
        <Card>
          <p slot="title">
            <Icon type="paper-airplane"></Icon>
            发布
          </p>

          <Row class="margin-top-10 publish-button-con">
            <Button @click="handleSaveDraft('formValidate')">保存草稿</Button>

            <Button @click="toPublish('formValidate')"
                    :loading="publishLoading"
                    icon="ios-checkmark"
                    type="primary">发布</Button>

          </Row>
        </Card>

        <div class="margin-top-10">
          <Card>
            <p slot="title">
              <Icon type="navicon-round"></Icon>
              文章分类
            </p>
            <FormItem label=""
                      :label-width="1"
                      prop="title"
                      :rules="{ required: true, message: '请选择文章分类', trigger: 'blur' }">

              <Row>
                <Col span="18">
                <Select v-model="categoryId"
                        size="small"
                        placeholder="请选择分类">
                  <Option v-for="item in categories"
                          :value="item.id"
                          :key="item.id">{{ item.name }}</Option>
                </Select>
                </Col>
              </Row>
            </FormItem>

          </Card>
        </div>
        <div class="margin-top-10">

          <Card>
            <p slot="title">
              <Icon type="ios-pricetags-outline"></Icon>
              标签
            </p>
            <FormItem label=""
                      :label-width="1"
                      prop="title"
                      :rules="{ required: true, message: '请选择文章标签', trigger: 'blur' }">

              <Row>
                <Col span="18">

                <Select v-model="tagIds"
                        multiple
                        size="small">
                  <Option v-for="item in tags"
                          :value="item.id"
                          :key="item.id">{{ item.name }}</Option>
                </Select>
                </Col>
                <Col span="6">
                <Button type="primary"
                        v-show="!addingNewTag"
                        @click="handleAddNewTag"
                        size="small">新建</Button>
                </Col>
              </Row>
            </FormItem>

            <div v-show="addingNewTag"
                 class="add-new-tag-con">
              <Row>
                <Col span="14">
                <Input v-model="newTagName"
                       size="small"
                       placeholder="请输入标签名" />
                </Col>
                <Col span="5">
                <Button @click="createNewTag"
                        size="small"
                        type="primary">确定</Button>
                </Col>
                <Col span="5">
                <Button @click="cancelCreateNewTag"
                        size="small">取消</Button>
                </Col>
              </Row>
            </div>

          </Card>

        </div>

        </Col>
      </Row>
    </Form>
  </div>
</template>
<script>
import { getToken } from '@/utils/auth'

import VMarkdown from '@zkhh/v-markdown'
export default {
  components: {
    VMarkdown,
  },
  data () {
    return {
      theme: 'ir-black',//主题名字 'github','atom-one-dark'
      addRow: {},
      addingNewTag: false,
      newTagName: "",
      publishLoading: false,
      categoryId: '', //
      content: '',
      categories: [],
      tags: [],
      tagIds: [],
      headers: {}

    };
  },
  mounted () {
    this.allTags()
    this.allCategories()
    this.headers = { 'Authorization': 'Bearer ' + getToken() }// 让每个请求携带token-- ['X-Token']为自定义key 请根据实际情况自行修改

  },
  computed: {

  },
  methods: {
    mdChange (value) {
      // 获取md文本
      console.log(value)
      this.addRow.content_md = value

    },
    htmlChange (value) {
      // 获取 marked处理过后生成的html
      console.log(value)

    },
    htmlHljsChange (value) {
      // 获取 highlight.js处理过的html 主要给代码code 添加了 hljs 等css类
      console.log(value)
      this.addRow.content = value

    },
    async  allTags () {
      const res = await this.api.getTagList({ per_page: 100 });
      this.tags = res.data
    },
    async  allCategories () {

      const res = await this.api.getCategoryList({ per_page: 100 });
      this.categories = res.data

    },

    handleAddNewTag () {
      this.addingNewTag = !this.addingNewTag;
    },
    createNewTag () {
      if (this.newTagName.length !== 0) {
        this.addingNewTag = false;
        setTimeout(() => {
          this.newTagName = "";
        }, 200);
      } else {
        this.$Message.error("请输入标签名");
      }
    },
    cancelCreateNewTag () {
      this.newTagName = "";
      this.addingNewTag = false;
    },

    handlePreview () {
      this.$store.state.app.md = this.simplemde.value();
      this.$router.push({ name: "preview_article" });
    },
    toPublish (name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          const data = {
            ...this.addRow,
            category_id: this.categoryId,
            tags: this.tagIds,
            state: 1
          }
          this.handlePublish(data)
        } else {
          this.$Message.error('请填写必填内容!');
        }

      })
    },
    async handlePublish (data) {

      try {
        this.$Spin.show();
        this.publishLoading = true
        await this.api.addArticle(data);
        this.publishLoading = false
        this.$Spin.hide();
        this.$Message.success("保存成功!");
        this.$router.push({ name: 'articles_index' })
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
    handleSaveDraft (name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          const data = {
            ...this.addRow,
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

    uploadSuccess (response, file, fileList) {
      this.$set(this.addRow, 'page_image_url', response.url)

    }
  }
};
</script>
