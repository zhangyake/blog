<template>
  <div class="login-container">
    <!-- <vue-canvas-nest :config="config"></vue-canvas-nest> -->

    <div class="login-container-box">

      <div  class="info">
        <div  class="title">
          <img  src="data:image/png;base64,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">
          <span >Blog后台管理</span></div>
        <div  class="detail">
          <span >
          <!--Database Manager 助您更好的管理关系型数据-->
        </span></div></div>

      <div class="login-form">


          <div slot="title" class="title">
            <h3>账号密码登录</h3>
          </div>
          <Form ref="formInline" :model="formInline" :rules="ruleInline">
            <FormItem prop="username">
              <Input type="text" v-model="formInline.username" placeholder="请输入用户名">
              <span slot="prepend">
                <Icon :size="16" type="md-person"></Icon>
              </span>
              </Input>
            </FormItem>
            <FormItem prop="password">
              <Input type="password" v-model="formInline.password" placeholder="请输入密码" @keyup.enter.native="handleSubmit('formInline')">
              <span slot="prepend">
                <Icon :size="14" type="md-lock"></Icon>
              </span>
              </Input>
            </FormItem>

           <!-- <FormItem prop="code">
              <Input type="text" v-model="formInline.code" placeholder="请输入验证码" @keyup.enter.native="handleSubmit('formInline')">
              <span slot="prepend">
                <Icon :size="14" type="ios-lock"></Icon>
              </span>
              <span class="show-pwd" slot="append" @click="getIdentifyCode"> {{gettingIdentifyCodeBtnContent}}</span>
              </Input>
            </FormItem> -->
           <FormItem prop="code">
              <Input type="text" v-model="formInline.code" placeholder="请输入右侧验证码" @keyup.enter.native="handleSubmit('formInline')">
              <span slot="prepend">
                <Icon :size="14" type="ios-lock"></Icon>
              </span>
              <img class="show-captcha" slot="append" :src="imagesrc" @click="changeSrc">
              </Input>
            </FormItem> 
            <FormItem>
              <Button type="primary" @click="handleSubmit('formInline')" long :loading="loading">登 录</Button>
            </FormItem>
          </Form>


      </div>
    </div>

 
  </div>
</template>

<script>
import vueCanvasNest from '@/components/VueCanvasNest'
import { mapGetters } from 'vuex'
import { setToken, setKey } from '@/utils/auth'
import * as UUID from 'uuidjs'
export default {
  name: 'Login',
  components: { vueCanvasNest },
  data () {
    return {
      qrcodeModal: false,
      config: { color: '255,255,255', opacity: '1', count: 240 },
      loading: false,
      bind_loading: false,
      oneCode: '',
      imagesrc: '',
      svgStr: '',
      uuid: '',
      formInline: {
        username: '',
        password: '',
        code: ''
      },
      ruleInline: {
        username: [
          {
            required: true,
            message: '请输入用户名！',
            trigger: 'blur'
          }
        ],
        password: [
          {
            required: true,
            message: '请输入密码！',
            trigger: 'blur'
          },
          {
            type: 'string',
            min: 5,
            message: '密码长度不能小于5位！',
            trigger: 'blur'
          }
        ],
        code: [
          {
            required: true,
            message: '请输入验证码！',
            trigger: 'blur'
          }
        ]
      },
      canGetIdentifyCode: true,
      gettingIdentifyCodeBtnContent: '获取验证码'
    }
  },
  computed: {
    ...mapGetters([
      'firstPage'
    ])
  },
  mounted () {
    this.uuid = UUID.generate()
    this.imagesrc = '/api/captcha/' + this.uuid
  },
  methods: {
    changeSrc () {
      this.uuid = UUID.generate()
      this.imagesrc = '/api/captcha/' + this.uuid
    },
    getIdentifyCode () {
      //   this.$refs.formInline.validate(valid => {
      // if (valid) {
      if (this.canGetIdentifyCode) {
        this.canGetIdentifyCode = false
        let timeLast = 20
        const timer = setInterval(() => {
          if (timeLast >= 0) {
            this.gettingIdentifyCodeBtnContent = timeLast + '秒后重试'
            timeLast -= 1
          } else {
            clearInterval(timer)
            this.gettingIdentifyCodeBtnContent = '获取验证码'
            this.canGetIdentifyCode = true
          }
        }, 1000)

        // you can write ajax request here
      }
      // }
      //   })
    },
    handleSubmit (name) {
      this.$refs[name].validate(valid => {
        this.loading = true
        if (valid) {
        
              this.api.login({ name: this.formInline.username, password: this.formInline.password, code: this.formInline.code, uuid: this.uuid })
              .then(res=>{
                setToken(res.access_token)
                setKey('expires_in',res.expires_in)
                setKey('timestamp',+new Date)
                this.api.getUserInfo().then(res=>{
                  this.$store.commit('SET_NAME',res.name)
                  setKey('user_name',res.name)
                  this.$store.dispatch('getUserMenu').then(()=>{
                  this.$router.push({ name: 'home' })
                  })
                })
              }).catch(err=>{
               if(err && err.response.data.message){
                this.$Message.error({
                  content: err.response.data.message,
                  duration: 3
                })
               }
                
              })
              
              
            }

        this.loading = false
      })
    },
    
  }
}
</script>

<style lang="less" scoped>
.login-container {
  position: fixed;
  width: 100%;
  height: 100%;
  background-image: url('bg.svg');
  .login-container-box {
    position: absolute;
    width: 400px;
    height: 540px;
    margin: auto;
    top: 120px;
    right: 0;
    left: 0;

    .info {
      text-align: center;
      height: 120px;
      .title {
        display: flex;
        justify-content: center;
        align-items: Center;
        font-size: 32px;
        color: rgba(0,0,0,.85);
        font-family: Myriad Pro,Helvetica Neue,Arial,Helvetica,sans-serif;
        font-weight: 600;
      }
      .detail {
        font-size: 14px;
        color: rgba(0,0,0,.45);
        margin-top: 12px;
        margin-bottom: 40px;
      }
    }
    .login-form {
      border-radius: 5px;
      -moz-border-radius: 5px;
      background-clip: padding-box;
      padding: 35px 35px 15px;
      background: #fff;
      border: 1px solid #eaeaea;
      box-shadow: 0 0 25px #cac6c6;
      .title{
        margin: 0 auto 40px;
        text-align: center;
        color: #505458;
        font-size: 1.18em;
      }
    }
  }
}
.show-pwd {
  cursor: pointer;
}
.show-captcha {
  cursor: pointer;
  margin-top: -5px;
  margin-bottom: -8px;
  margin-left: -7px;
  margin-right: -7px;
}
</style>
