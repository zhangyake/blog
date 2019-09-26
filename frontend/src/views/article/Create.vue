<template>
  <a-card :body-style="{padding: '0px 0px'}" :bordered="false">
    <a-row>
      <a-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
        <input
          class="title-input"
          name="name"
          v-model="title"
          placeholder="输入文章标题..."/>
      </a-col>
      <a-col
        :xs="24"
        :sm="24"
        :md="12"
        :lg="12"
        :xl="12"
      >
        <div class="publish-popover">
          <a-popover placement="bottom" trigger="click" >
            <template slot="content">
              <template v-for="(tag,index) in allTags">
                <a-checkable-tag
                  :key="tag.id"
                  :checked="selectedTags.indexOf(tag.id) > -1"
                  @change="(checked) => handleChange(tag.id, checked)"
                >
                  {{ tag.name }}
                </a-checkable-tag>

                <br v-if="index%4===3" :key="'br'+index" />

              </template>
              <a-divider />
              <div style="text-align:center;">
                <a-button type="primary" ghost @click="toPublish" :loading="loading">确认并发布</a-button>
              </div>

            </template>
            <template slot="title">
              <span>选择标签</span>
            </template>
            <a-button type="primary" ghost>发 布</a-button>
          </a-popover></div>
        <!-- <a-button htmlType="submit" type="primary">发布文章</a-button>
        <a-button style="margin-left: 8px" @click="toSaveArticle">保存草稿</a-button> -->
      </a-col>
    </a-row>

    <a-row>
      <a-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
        <textarea
          @keydown.tab.exact.prevent="insertTab"
          @keydown.ctrl.49.prevent="addH(1)"
          @keydown.ctrl.50.prevent="addH(2)"
          @keydown.ctrl.51.prevent="addH(3)"
          @keydown.ctrl.52.prevent="addH(4)"
          @keydown.ctrl.53.prevent="addH(5)"
          @keydown.ctrl.76.prevent="addLink"
          @keydown.ctrl.71.prevent="addImg"
          @keydown.ctrl.75.prevent="addCode"
          @keydown.ctrl.66.prevent="addBold"
          @keydown.ctrl.73.prevent="addItalic"
          ref="textarea_for_md"
          id="textarea_for_md"
          rows="35"
          placeholder="开始书写文章吧"
          v-model="mdString"/>
      </a-col>
      <a-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
        <div
          class="editor-preview"
          v-html="htmlString"
          id="editor_preview_box"
          ref="editor_preview_box"
        ></div>
      </a-col>
    </a-row>

  </a-card>
</template>

<script>
import emojione from 'emojione'
import marked from 'marked'
import hljs from 'highlight.js'

export default {
  props: {
    mdText: {
      type: String,
      default: ''
    },
    theme: {
      type: String,
      default: 'atom-one-dark'
    },
    options: {
      type: Object,
      default: () => {
        return {
          pedantic: false,
          gfm: true,
          breaks: true,
          sanitize: false,
          smartLists: true,
          smartypants: false
        }
      }
    }
  },
  watch: {
    theme (value) {
      this.addOrUpdateCssLink(value)
    },
    mdString (value) {
      this.$emit('md-change', value)
      marked.setOptions(this.options)
      this.htmlString = emojione.toImage(marked(value))
      this.$emit('html-change', this.htmlString)
      // console.log(this.htmlString)
      this.$nextTick().then(() => {
        document.querySelectorAll('.editor-preview pre code').forEach(block => {
          hljs.highlightBlock(block)
        //   Prism.highlight(block)
        })
        this.$emit('html-hljs-change', this.$refs.editor_preview_box.innerHTML)
        // console.log(this.$refs.editor_preview_box.innerHTML)
      })
    },
    clientHeight () { // 如果clientHeight 发生改变，这个函数就会运行
      this.changeFixed(this.clientHeight)
    }
  },
  mounted () {
    // autosize(document.getElementById('textarea_for_md'))
    this.clientHeight = `${document.documentElement.clientHeight}`// 获取浏览器可视区域高度

    window.onresize = () => {
      this.clientHeight = `${document.documentElement.clientHeight}`
    }
    this.mdString = this.mdText
    this.addOrUpdateCssLink(this.theme)
    this.getAllTags()
  },
  data () {
    return {
      loading: false,
      allTags: [],
      selectedTags: [],
      title: '',
      clientHeight: '',
      mdString: '',
      htmlString: '',
      status: 1,
      article: {}

    }
  },
  methods: {
    getAllTags () {
      this.$api.getAllTags().then(res => {
        this.allTags = res.data
      })
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

      this.$api.insertArticle({ tags: this.selectedTags, status: 1, preview: this.title, title: this.title, content_md: this.mdString, content: this.$refs.editor_preview_box.innerHTML }).finally(() => {
        this.$message.success('success')
        setTimeout(() => {
          this.$router.push({ name: 'articleList' })
        }, 1000)
      }).finally(() => {
        this.loading = false
      })
    },
    handleChange (tag, checked) {
      const { selectedTags } = this
      const nextSelectedTags = checked
        ? [...selectedTags, tag]
        : selectedTags.filter(t => t !== tag)
      this.selectedTags = nextSelectedTags
    },
    changeFixed (clientHeight) {
      document.getElementById('textarea_for_md').style.height = (clientHeight - 290) + 'px'
      document.getElementById('editor_preview_box').style.height = (clientHeight - 290) + 'px'
    },
    addOrUpdateCssLink (value) {
      var themeUrl = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/styles/' + value + '.min.css'
      var link = document.getElementById('highlight_style')
      if (link) {
        link.href = themeUrl
      } else {
        link = document.createElement('link')
        link.href = themeUrl
        link.id = 'highlight_style'
        link.rel = 'stylesheet'
        document.head.append(link)
      }
    },
    insertTab () {
      var start = document.getElementById('textarea_for_md').selectionStart
      var end = document.getElementById('textarea_for_md').selectionEnd
      if (start === end) {
        document.execCommand('insertText', false, '    ')
      } else {
        const strBefore = document.getElementById('textarea_for_md').value.slice(0, start)
        const curLineStart = strBefore.includes('\n') ? strBefore.lastIndexOf('\n') + 1 : 0
        const strBetween = document.getElementById('textarea_for_md').value.slice(curLineStart, end + 1)
        const newStr = '  ' + strBetween.replace(/\n/g, '\n  ')
        const lineBreakCount = strBetween.split('\n').length
        const newStart = start + 2
        const newEnd = end + (lineBreakCount + 1) * 2
        document.getElementById('textarea_for_md').setSelectionRange(curLineStart, end)
        document.execCommand('insertText', false, newStr)
        document.getElementById('textarea_for_md').setSelectionRange(newStart, newEnd)
      }
    },
    addH (i) {
      var hstrs = { 1: '#', 2: '##', 3: '###', 4: '####', 5: '#####' }
      var start = document.getElementById('textarea_for_md').selectionStart
      //  var end = document.getElementById('textarea_for_md').selectionEnd;
      const strBefore = document.getElementById('textarea_for_md').value.slice(0, start)
      const curLineStart = strBefore.includes('\n') ? strBefore.lastIndexOf('\n') + 1 : 0
      const lineEndIndex = document.getElementById('textarea_for_md').value.slice(curLineStart).indexOf('\n')
      const lineStr = lineEndIndex === -1 ? document.getElementById('textarea_for_md').value.slice(curLineStart)
        : document.getElementById('textarea_for_md').value.slice(curLineStart, lineEndIndex + curLineStart)
      let endIndex = curLineStart
      if (lineStr.startsWith('# ')) {
        if (i !== 1) {
          endIndex = curLineStart + 2
        } else {
          return
        }
      }
      if (lineStr.startsWith('## ')) {
        if (i !== 2) {
          endIndex = curLineStart + 3
        } else {
          return
        }
      }
      if (lineStr.startsWith('### ')) {
        if (i !== 3) {
          endIndex = curLineStart + 4
        } else {
          return
        }
      }
      if (lineStr.startsWith('#### ')) {
        if (i !== 4) {
          endIndex = curLineStart + 5
        } else {
          return
        }
      }
      if (lineStr.startsWith('##### ')) {
        if (i !== 5) {
          endIndex = curLineStart + 6
        } else {
          return
        }
      }
      document.getElementById('textarea_for_md').setSelectionRange(curLineStart, endIndex)
      document.execCommand('insertText', false, hstrs[i] + ' ')
    },
    addLink () {
      var start = document.getElementById('textarea_for_md').selectionStart
      //  var end = document.getElementById('textarea_for_md').selectionEnd;
      document.getElementById('textarea_for_md').setSelectionRange(start, start)
      document.execCommand('insertText', false, '[描述](http://example.com)')
      document.getElementById('textarea_for_md').setSelectionRange(start + 3, start + 3)
    },
    addImg () {
      var start = document.getElementById('textarea_for_md').selectionStart
      //  var end = document.getElementById('textarea_for_md').selectionEnd;
      document.getElementById('textarea_for_md').setSelectionRange(start, start)
      document.execCommand('insertText', false, '![图片描述](http://example.com/demo.png)')
      document.getElementById('textarea_for_md').setSelectionRange(start + 6, start + 6)
    },
    addCode () {
      var start = document.getElementById('textarea_for_md').selectionStart
      var end = document.getElementById('textarea_for_md').selectionEnd
      var str = document.getElementById('textarea_for_md').value.slice(start, end + 1)
      document.getElementById('textarea_for_md').setSelectionRange(start, end)
      document.execCommand('insertText', false, '```\n' + str + '\n```')
      document.getElementById('textarea_for_md').setSelectionRange(start + 4, end + 4)
    },
    addBold () {
      var start = document.getElementById('textarea_for_md').selectionStart
      var end = document.getElementById('textarea_for_md').selectionEnd
      var str = document.getElementById('textarea_for_md').value.slice(start, end)
      document.getElementById('textarea_for_md').setSelectionRange(start, end)
      //   var start = document.getElementById('textarea_for_md').selectionStart
      //   var end = document.getElementById('textarea_for_md').selectionEnd
      //   var str = document.getElementById('textarea_for_md').value.slice(start, end)
      //   document.getElementById('textarea_for_md').setSelectionRange(start, end)
      if (start === end) {
        str = 'strong txt'
        end = end + 12
      } else {
        end = end + 2
      }
      start = start + 2
      document.execCommand('insertText', false, '**' + str + '**')
      document.getElementById('textarea_for_md').setSelectionRange(start, end)
    },
    addItalic () {
      var start = document.getElementById('textarea_for_md').selectionStart
      var end = document.getElementById('textarea_for_md').selectionEnd
      var str = document.getElementById('textarea_for_md').value.slice(start, end)
      document.getElementById('textarea_for_md').setSelectionRange(start, end)
      if (start === end) {
        str = 'italic txt'
        end = end + 11
      } else {
        end = end + 1
      }
      start = start + 1
      document.execCommand('insertText', false, '*' + str + '*')
      document.getElementById('textarea_for_md').setSelectionRange(start, end)
    }

  }
}
</script>
<style>
  blockquote {
    margin: 1em 0;
    border-left: 4px solid #ddd;
    padding: 0 1em;
    color: #666;
  }
</style>
<style lang="less" scoped>
.title-input{
height: 48px;
width: 100%;
padding-left: 20px;
outline: none;
font-size: 1.3rem;
border: none;

}
.publish-popover{
  float: right;
  margin: 8px 10px;
  // width: 60px;
  // height: 48px;
  // line-height: 48px;
  // cursor: pointer;
  // user-select: none;
}
#textarea_for_md{
  outline: none;
  border: 1px solid #ebebeb;
  width: 100%;
     resize: none;
     overflow-x: hidden;
     overflow-y:auto;
     padding-top: 10px;
     padding-left: 28px;
    background: #f8f9fa;
    &::-webkit-scrollbar { /*滚动条整体样式*/
    width: 8px !important;; /*高宽分别对应横竖滚动条的尺寸*/
    height: 6px !important;;
    background: #ffffff !important;;
    cursor: pointer !important;

}

&::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
    border-radius: 5px !important;
    background: rgba(143, 143, 143, 0.5) !important;;
    cursor: pointer !important;
}

&::-webkit-scrollbar-track { /*滚动条里面轨道*/
    border-radius: 0 !important;;
    background: rgb(255, 255, 255) !important;;
    cursor: pointer !important;
}
}
.editor-preview{
  padding: 2px 10px;
  overflow-x: hidden;
  overflow-y:auto;
  word-wrap:break-word;
  // border-radius: 4px;
  border: 1px solid #ebebeb;

  &::-webkit-scrollbar { /*滚动条整体样式*/
    width: 8px !important;; /*高宽分别对应横竖滚动条的尺寸*/
    height: 6px !important;;
    background: #dfdfdf !important;;
    cursor: pointer !important;

}

&::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
    border-radius: 5px !important;
    background: rgba(143, 143, 143, 0.5) !important;;
    cursor: pointer !important;
}

&::-webkit-scrollbar-track { /*滚动条里面轨道*/
    border-radius: 0 !important;;
    background: rgba(240, 240, 240, 0.5) !important;;
    cursor: pointer !important;
}
}
</style>
