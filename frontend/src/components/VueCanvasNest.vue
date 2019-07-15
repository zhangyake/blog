<template>
  <div class="vue-canvas-nest-element" ref="vue_canvas_next_element">
  </div>
</template>
<script>
import CanvasNest from 'canvas-nest.js'
export default {
  name: 'vueCanvasNest',
  props: {
    config: {
      type: Object,
      default () {
        return {
          color: '255,0,0',
          count: 88
        }
      }
    }
  },
  data () {
    return {
      cn: ''
    }
  },
  mounted () {
    const el = this.$refs.vue_canvas_next_element
    this.cn = new CanvasNest(el, this.config)
    // this.cn.destroy()
  },
  beforeDestroy () {
    // this.cn.destroy()
    this.$refs.vue_canvas_next_element.innerHTML = ''
  }
}
</script>
<style scoped>
.vue-canvas-nest-element {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  overflow: hidden;
  pointer-events: none;
  z-index: -2;
  opacity: 0.7;
}
</style>
