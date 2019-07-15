<template>
    <div>
        <div ref="editor" style="text-align:left"></div>
        <button v-on:click="getContent">查看内容</button>
    </div>
</template>

<script>
import E from 'wangeditor'
export default {
  name: 'editor',
  props: {
    content: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      editorContent: this.content
    }
  },
  methods: {
    getContent: function () {
      alert(this.editorContent)
      this.$emit('on-show', this.editorContent)
    }
  },
  mounted () {
    var editor = new E(this.$refs.editor)
    editor.customConfig.onchange = (html) => {
      this.editorContent = html
    }

    editor.create()
    editor.txt.html(this.content)
  }
}
</script>

<style scoped>
</style>
