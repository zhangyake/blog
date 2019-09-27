<template>
  <div class="page-header-index-wide page-header-wrapper-grid-content-main">
    <a-row :gutter="24">

      <a-col :md="24" :lg="17">
        <a-card style="width:100%;" :body-style="{padding:'0px 0px'}" :bordered="false">
          <a-row>
            <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
              <input class="title-input" v-model="title" placeholder="输入文章标题..." />

            </a-col>

            <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
              <div id="textarea_for_editor">

                <mavon-editor
                  codeStyle="far"
                  :autofocus="false"
                  :subfield="subfield"
                  :ishljs="true"
                  :toolbars="toolbars"
                  style="height: 100%"
                  v-model="content_md"
                  @change="mdChange" ></mavon-editor>
              </div>

            </a-col>

          </a-row>

        </a-card>
        <a-col
          :xs="24"
          :sm="24"
          :md="24"
          :lg="24"
          :xl="24"
          style="margin-top:1px; padding:5px ; text-align:right;background:#fff">
          <a-button type="primary" @click="toPublish">发布</a-button>
        </a-col>
      </a-col>
      <a-col :md="24" :lg="7">
        <a-card :bordered="false">
          <div class="account-center-avatarHolder">
            <div class="avatar">
              <img :src="avatar()">
            </div>
            <div class="username">{{ nickname() }}</div>
            <div class="bio">海纳百川，有容乃大</div>
          </div>
          <div class="account-center-detail">
            <p>
              <i class="title"></i>交互专家
            </p>
            <p>
              <i class="group"></i>蚂蚁金服－某某某事业群－某某平台部－某某技术部－UED
            </p>
            <p>
              <i class="address"></i>
              <span>浙江省</span>
              <span>杭州市</span>
            </p>
          </div>
          <a-divider />

          <div class="account-center-tags">
            <div class="tagsTitle">标签</div>
            <div>
              <template v-for="(tag) in tags">
                <a-tooltip v-if="tag.length > 20" :key="tag" :title="tag">
                  <a-tag :key="tag">{{ `${tag.slice(0, 20)}...` }}</a-tag>
                </a-tooltip>
                <a-tag v-else :key="tag">{{ tag }}</a-tag>
              </template>
            </div>
          </div>
          <a-divider :dashed="true" />

          <div class="account-center-team">
            <div class="teamTitle">团队</div>

          </div>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>

import { mapGetters } from 'vuex'
import { mavonEditor } from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'
export default {
  components: {
    mavonEditor
  },
  data () {
    return {
      clientHeight: '',
      subfield: false,
      toolbars: {
        bold: true, // 粗体
        italic: true, // 斜体
        header: true, // 标题
        underline: true, // 下划线
        strikethrough: true, // 中划线
        mark: false, // 标记
        superscript: true, // 上角标
        subscript: true, // 下角标
        quote: true, // 引用
        ol: true, // 有序列表
        ul: true, // 无序列表
        link: true, // 链接
        imagelink: true, // 图片链接
        code: true, // code
        table: true, // 表格
        fullscreen: true, // 全屏编辑
        readmodel: false, // 沉浸式阅读
        htmlcode: true, // 展示html源码
        help: false, // 帮助
        /* 1.3.5 */
        undo: false, // 上一步
        redo: false, // 下一步
        trash: false, // 清空
        save: false, // 保存（触发events中的save事件）
        /* 1.4.2 */
        navigation: true, // 导航目录
        /* 2.1.8 */
        alignleft: false, // 左对齐
        aligncenter: false, // 居中
        alignright: false, // 右对齐
        /* 2.2.1 */
        subfield: true, // 单双栏模式

        preview: true // 预览
      },
      title: '',
      content_md: '',
      content: '',
      article: {},
      tags: ['很有想法的', '专注设计', '辣~', '大长腿', '川妹子', '海纳百川']

    }
  },
  watch: {

    clientHeight () { // 如果clientHeight 发生改变，这个函数就会运行
      this.changeFixed(this.clientHeight)
    }
  },
  mounted () {
    this.clientHeight = `${document.documentElement.clientHeight}`// 获取浏览器可视区域高度

    window.onresize = () => {
      this.clientHeight = `${document.documentElement.clientHeight}`
    }
    this.handleQuery()
  },
  methods: { handleChange (value) {

  },
  ...mapGetters(['nickname', 'avatar']),
  changeFixed (clientHeight) {
    document.getElementById('textarea_for_editor').style.height = (clientHeight - 280) + 'px'
  },
  mdChange (value, renderValue) {
    console.log(value)
    console.log(renderValue)
    this.content = renderValue
  },
  toPublish () {
    if (this.title.trim() === '') {
      this.$message.error('标题不能为空')
      return
    }
    if (this.htmlString.trim() === '') {
      this.$message.error('内容不能为空')
      return
    }
    this.loading = true

    this.$api.insertArticle({ status: 1, preview: this.title, title: this.title, content_md: this.content_md, content: this.content }).finally(() => {
      this.$message.success('success')
      setTimeout(() => {
        this.$router.push({ name: 'articleList' })
      }, 1000)
    }).finally(() => {
      this.loading = false
    })
  },
  handleQuery (query) {
    // this.loading = true
    // this.$api.getArticleDetail({ id: 10 }).then(res => {
    //   this.article = res.data
    // }).finally(() => {
    //   setTimeout(() => {
    //     this.loading = false
    //   }, 300)
    // })
  }
  }
}
</script>

<style lang="less" scoped>
.page-header-wrapper-grid-content-main {
  width: 100%;
  height: 100%;
  min-height: 100%;
  transition: 0.3s;
  .title-input {
    height: 48px;
    width: 100%;
    padding-left: 20px;
    outline: none;
    font-size: 1.2rem;
    border: none;
    border-bottom: #dfdfdf 1px solid;
    margin: 0px 0px 2px 0px;
  }
  .account-center-avatarHolder {
    text-align: center;
    margin-bottom: 24px;

    & > .avatar {
      margin: 0 auto;
      width: 104px;
      height: 104px;
      margin-bottom: 20px;
      border-radius: 50%;
      overflow: hidden;
      img {
        height: 100%;
        width: 100%;
      }
    }

    .username {
      color: rgba(0, 0, 0, 0.85);
      font-size: 20px;
      line-height: 28px;
      font-weight: 500;
      margin-bottom: 4px;
    }
  }

  .account-center-detail {
    p {
      margin-bottom: 8px;
      padding-left: 26px;
      position: relative;
    }

    i {
      position: absolute;
      height: 14px;
      width: 14px;
      left: 0;
      top: 4px;
      background: url(https://gw.alipayobjects.com/zos/rmsportal/pBjWzVAHnOOtAUvZmZfy.svg);
    }

    .title {
      background-position: 0 0;
    }
    .group {
      background-position: 0 -22px;
    }
    .address {
      background-position: 0 -44px;
    }
  }

  .account-center-tags {
    .ant-tag {
      margin-bottom: 8px;
    }
  }

  .account-center-team {
    .members {
      a {
        display: block;
        margin: 12px 0;
        line-height: 24px;
        height: 24px;
        .member {
          font-size: 14px;
          color: rgba(0, 0, 0, 0.65);
          line-height: 24px;
          max-width: 100px;
          vertical-align: top;
          margin-left: 12px;
          transition: all 0.3s;
          display: inline-block;
        }
        &:hover {
          span {
            color: #1890ff;
          }
        }
      }
    }
  }

  .tagsTitle,
  .teamTitle {
    font-weight: 500;
    color: rgba(0, 0, 0, 0.85);
    margin-bottom: 12px;
  }
}
</style>
