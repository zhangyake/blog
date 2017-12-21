<template>
    <div id="vaptcha_container" style="width:300px;height:36px;">
        <!--vaptcha_container是用来引入VAPTCHA的容器，下面代码为预加载动画，仅供参考-->
        <div class="vaptcha-init-loading">
            <a href="https://www.vaptcha.com/" target="_blank"><img src="https://cdn.vaptcha.com/vaptcha-loading.gif"/></a>
            <span class="vaptcha-text">VAPTCHA启动中...</span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                msg: 'This is a Laravel with Vue and Element Demo.'
            }
        },
        mounted() {
            $.get('/api/vaptcha/challenge?sceneid=01', function (response) {
//                console.log(response);
                var options = {
                 /*          vid: response.data.vid, //验证单元id, string, 必填
                           challenge: response.data.challenge, //验证流水号, string, 必填
                           container:"#vaptcha_container",//验证码容器, HTMLElement或者selector, 必填
                           type:"click", //必填，表示点击式验证模式,
                           effect:'float', //验证图显示方式, string, 可选择float, popup, 默认float
                           https:false, //协议类型, boolean, 可选true, false
                           color:"#57ABFF", //按钮颜色, string
                           outage:"/api/vaptcha/downtime", //服务器端配置的宕机模式接口地址
                           success:function(token,challenge){//验证成功回调函数, 参数token, challenge 为string, 必填
                               //todo:执行人机验证成功后的操作
                           },
                           fail:function(){//验证失败回调函数
                               //todo:执行人机验证失败后的操作
                           }*/
                   vid: response.data.vid, //验证单元id, string, 必填
                    challenge: response.data.challenge, //验证流水号, string, 必填
                    container: "#vaptcha_container",//验证码容器, HTMLElement或者selector, 必填
                    type: "embed", //必填，表示点击式验证模式,
                    https: false,//协议类型,boolean,可选true,false,不填则自适应。
                    outage: "/api/vaptcha/downtime", //服务器端配置的宕机模式接口地址
                    success: function (token, challenge) {//验证成功回调函数, 参数token, challenge 为string, 必填
                        //todo:执行人机验证成功后的操作
                        console.log('执行人机验证成功后的操作');
                    },
                    fail: function () {//验证失败回调函数
                        //todo:执行人机验证失败后的操作
                        console.log('执行人机验证失败后的操作');
                    }
                }
                   var obj;
                  window.vaptcha(options, function (vaptcha_obj) {
                    obj = vaptcha_obj;
                    obj.init();
                });
            });
        }
    }
    //这里使用到验证场景，传过去的参数即为对应的编号，比如之前登录的对应的编号即为01

</script>

<style>
    #vaptcha_container {
         margin-bottom: 10px;
         display: table;
          background-color: #EEEEEE;
         border-radius: 2px;
    }

    .vaptcha-init-loading {
        display: table-cell;
        vertical-align: middle;
        text-align: center
    }

    .vaptcha-init-loading > a {
        display: inline-block;
        width: 18px;
        height: 18px;
    }

    .vaptcha-init-loading > a img {
        vertical-align: middle
    }

    .vaptcha-init-loading .vaptcha-text {
        font-family: sans-serif;
        font-size: 12px;
        color: #CCCCCC;
        vertical-align: middle
    }
</style>
