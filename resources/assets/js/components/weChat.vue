<template>
    <div class="">
        <ul class="app-conetnt">
            <li class="chat-item">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item-me">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item-me">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item-me">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
            <li class="chat-item-me">
                <img class="head-img" src="../../img/brand.jpg">
                <div class="chat-msg">黄河远上白云间， 一片孤城万仞山。 羌笛何须怨杨柳， 春风不度玉门关
                </div>
                <div style="clear:both;"></div>
            </li>
        </ul>
    </div>
</template>

<script>
import Scroll from "./scroll";
export default {
  name: "weChat",
  mixins: [Scroll],
  props: ["isMe", "imgUrl", "msg"],
  mounted:function(){
    !function (e) { function t(a) { if (i[a]) return i[a].exports; var n = i[a] = { exports: {}, id: a, loaded: !1 }; return e[a].call(n.exports, n, n.exports, t), n.loaded = !0, n.exports } var i = {}; return t.m = e, t.c = i, t.p = "", t(0) }([function (e, t) { "use strict"; Object.defineProperty(t, "__esModule", { value: !0 }); var i = window; t["default"] = i.flex = function (normal, e, t) { var a = e || 100, n = t || 1, r = i.document, o = navigator.userAgent, d = o.match(/Android[\S\s]+AppleWebkit\/(\d{3})/i), l = o.match(/U3\/((\d+|\.){5,})/i), c = l && parseInt(l[1].split(".").join(""), 10) >= 80, p = navigator.appVersion.match(/(iphone|ipad|ipod)/gi), s = i.devicePixelRatio || 1; p || d && d[1] > 534 || c || (s = 1); var u = normal ? 1 : 1 / s, m = r.querySelector('meta[name="viewport"]'); m || (m = r.createElement("meta"), m.setAttribute("name", "viewport"), r.head.appendChild(m)), m.setAttribute("content", "width=device-width,user-scalable=no,initial-scale=" + u + ",maximum-scale=" + u + ",minimum-scale=" + u), r.documentElement.style.fontSize = normal ? "50px" : a / 2 * s * n + "px" }, e.exports = t["default"] }]); flex(false, 100, 1);
      
  },
  methods: {
   
  },
  components: {}
};
</script>

<style lang="css">
 * {
            box-sizing: border-box;
            /* 在X5新内核Blink中，在排版页面的时候，会主动对字体进行放大，会检测页面中的主字体，当某一块字体在我们的判定规则中，认为字号较小，并且是页面中的主要字体，就会采取主动放大的操作。然而这不是我们想要的，可以采取给最大高度解决 */
            max-height: 100000px;
        }

        *:before,
        *:after {
            box-sizing: border-box;
            max-height: 100000px;
        }

        *,
        *:before,
        *:after {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        html,
        body,
        div,
        span,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        address,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        samp,
        small,
        strong,
        sub,
        sup,
        var,
        b,
        i,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        textarea,
        td {
            border: 0 none;
            font-size: inherit;
            color: inherit;
            margin: 0;
            padding: 0;
            vertical-align: baseline;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: normal;
        }

        em,
        strong {
            font-style: normal;
        }

        ul,
        ol,
        li {
            list-style: none;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "\5FAE\8F6F\96C5\9ED1", Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            background-color: #f6f6f6;
            font-size: 0.24rem;
        }

        a {
            text-decoration: none;
        }


.app-conetnt .chat-item {
  margin-bottom: 0.2rem;
}

.chat-item .head-img {
  display: block;
  border-radius: 50%;
  width: 0.72rem;
  height: 0.72rem;
  float: left;
  margin: 0 0.1rem;
}

.chat-item .chat-msg {
  float: left;
  background: #fffeff;
  max-width: 64%;
  line-height: 0.48rem;
  font-size: 0.32rem;
  padding: 0.1rem;
  border-radius: 5px;
}

.app-conetnt .chat-item-me {
  margin-bottom: 0.2rem;
}

.chat-item-me .head-img {
  display: block;
  border-radius: 50%;
  width: 0.72rem;
  height: 0.72rem;
  float: right;
  margin: 0 0.1rem;
}

.chat-item-me .chat-msg {
  float: right;
  background: #b0e56d;
  max-width: 64%;
  line-height: 0.48rem;
  font-size: 0.32rem;
  padding: 0.1rem;
  border-radius: 5px;
}
</style>
