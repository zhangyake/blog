<template>
    <div class="app-body" >
        <weChat></weChat>
    </div>

</template>

<script>

   import weChat from '../../components/weChat.vue'
    export default {
        components: {
            weChat
        },
        data() {
            return {
                message:'快来领支付宝红包！人人可领，天天可领！复制此消息，打开最新版支付宝就能领取！FYIX2u52ai',
                show: false,
                archives: {},
                loading: false,
                page: 1,
                scroller: null,
                noArticle: false,
                music_width: 375
            }
        },
        mounted() {
            let w = document.body.clientWidth
            this.music_width = w >= 375 ? 376 : w
        },
        methods: {
            showSilder() {
                this.show = !this.show
            },
            toArticle(id) {
                this.$router.push({name: 'Article', params: {'id': id}})
            }
        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
</style>
