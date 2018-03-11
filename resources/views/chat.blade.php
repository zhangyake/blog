<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>对话</title>
    <script>!function (e) {
            function t(a) {
                if (i[a]) return i[a].exports;
                var n = i[a] = {exports: {}, id: a, loaded: !1};
                return e[a].call(n.exports, n, n.exports, t), n.loaded = !0, n.exports
            }

            var i = {};
            return t.m = e, t.c = i, t.p = "", t(0)
        }([function (e, t) {
            "use strict";
            Object.defineProperty(t, "__esModule", {value: !0});
            var i = window;
            t["default"] = i.flex = function (normal, e, t) {
                var a = e || 100, n = t || 1, r = i.document, o = navigator.userAgent,
                    d = o.match(/Android[\S\s]+AppleWebkit\/(\d{3})/i), l = o.match(/U3\/((\d+|\.){5,})/i),
                    c = l && parseInt(l[1].split(".").join(""), 10) >= 80,
                    p = navigator.appVersion.match(/(iphone|ipad|ipod)/gi), s = i.devicePixelRatio || 1;
                p || d && d[1] > 534 || c || (s = 1);
                var u = normal ? 1 : 1 / s, m = r.querySelector('meta[name="viewport"]');
                m || (m = r.createElement("meta"), m.setAttribute("name", "viewport"), r.head.appendChild(m)), m.setAttribute("content", "width=device-width,user-scalable=no,initial-scale=" + u + ",maximum-scale=" + u + ",minimum-scale=" + u), r.documentElement.style.fontSize = normal ? "50px" : a / 2 * s * n + "px"
            }, e.exports = t["default"]
        }]);
        flex(false, 100, 1);</script>
    <style>
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
            background-color: #EBEAEB;
            font-size: 0.24rem;
        }

        a {
            text-decoration: none;
        }

        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            height: 1rem;
            background: #373940;
            color: #fff;
            font-size: 0.34rem;
            align-items: center
        }

        .return-icon {
            flex: 0 0 1rem;
            border-right: 1px solid #282A31;
            text-align: center;
            box-sizing: border-box;
        }

        .person-name {
            flex: 1;
            padding-left: 0.2rem;

        }

        .person-icon {
            flex: 0 0 1rem;
            text-align: center;

        }

        .app-send {
            position: fixed;
            display: flex;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1rem;
            background: #F3F2F3;
            align-items: center;

        }

        .send-icon {
            flex: 0 0 1rem;
            text-align: center;

        }

        .send-content {
            flex: 1;
            height: 0.72rem;
            font-size: 0.4rem;
            border: none;
            outline: none;
            border-radius: 3px;
            padding-left: 0.1rem;
        }

        .app-conetnt {
            margin: 1.1rem 0;
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
            background: #FFFEFF;
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
            background: #B0E56D;
            max-width: 64%;
            line-height: 0.48rem;
            font-size: 0.32rem;
            padding: 0.1rem;
            border-radius: 5px;
        }
    </style>
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
</head>

<body>
<div class="app" id="app">
    <div class="app-header">
        <div class="return-icon" @click="open">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>
        <div class="person-name">机器人</div>
        <div class="person-icon">
            <i class="fa fa-user" aria-hidden="true"></i>
        </div>
    </div>

    <ul class="app-conetnt">
        <li v-for="(item,index) in chatMsgs " :class="item.isMe?'chat-item-me':'chat-item'">

            <img class="head-img" src="./images/me.jpg" v-if="item.isMe">
            <img class="head-img" src="./images/robot.jpg" v-else>
            <div class="chat-msg" v-text="item.msg"></div>
            <div style="clear:both;"></div>
        </li>


    </ul>

    <div class="app-send">
        <div class="send-icon">
            <i class="fa fa-smile-o" aria-hidden="true"></i>
        </div>

        <input type="text" class="send-content" v-model="userMsg" @keyup.enter="sendMsg">

        <div class="send-icon" @click="sendMsg">
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </div>
    </div>
</div>
</body>
<script>
    new Vue({
        el: '#app',
        data: {
            userMsg: '',
            osTop:0,
            chatMsgs: [
                {isMe: false, msg: 'Hello, 你好 !', time: ''},
            ]
        },
        mounted:function () {
            this.osTop = document.documentElement.scrollTop || document.body.scrollTop;
        },
        updated:function () {
            document.documentElement.scrollTop = document.body.scrollTop = this.osTop + 10000;
        },
        methods: {
            open:function () {
              window.open('/');
            },
            sendMsg: function () {
                var that = this;
                var msg = that.userMsg;
                if (msg != '' && msg.toString().trim() != '') {
                    that.chatMsgs.push({
                        isMe: true,
                        msg: msg,
                        time: ''
                    });
                    that.userMsg = '';
                    axios.get('/api/robot', {
                        params: {
                            info: msg
                        }
                    }).then(function (response) {
                           var data =response.data;
                           if(data && data.hasOwnProperty('text')){
                               that.chatMsgs.push({
                                   isMe: false,
                                   msg: data.text,
                                   time: ''
                               });
                           }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            }
        }
    })
</script>
</html>