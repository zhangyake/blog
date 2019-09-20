<template>
  <div class="main">
    <a-form
      id="formLogin"
      class="user-layout-login"
      ref="formLogin"
      :form="form"
      @submit="handleSubmit"
    >

      <a-alert v-if="isLoginError" type="error" showIcon style="margin-bottom: 24px;" message="账户或密码错误" />
      <a-form-item>
        <a-input
          size="large"
          type="text"
          placeholder="账户:"
          v-decorator="[
            'username',
            {rules: [{ required: true, message: '请输入帐号' }],validateTrigger: 'blur'}
          ]"
        >
          <a-icon slot="prefix" type="user" :style="{ color: 'rgba(0,0,0,.25)' }"/>
        </a-input>
      </a-form-item>

      <a-form-item>
        <a-input
          size="large"
          type="password"
          autocomplete="false"
          placeholder="密码:"
          v-decorator="[
            'password',
            {rules: [{ required: true, message: '请输入密码' }], validateTrigger: 'blur'}
          ]"
        >
          <a-icon slot="prefix" type="lock" :style="{ color: 'rgba(0,0,0,.25)' }"/>
        </a-input>
      </a-form-item>

      <!-- <a-form-item>
        <a-checkbox v-decorator="['rememberMe']">自动登录</a-checkbox>
        <router-link
          :to="{ name: 'recover', params: { user: 'aaa'} }"
          class="forge-password"
          style="float: right;"
        >忘记密码</router-link>
      </a-form-item> -->

      <a-form-item style="margin-top:24px">
        <a-button
          size="large"
          type="primary"
          htmlType="submit"
          class="login-button"
          :loading="loginBtn"
          :disabled="loginBtn"
        >登录</a-button>
      </a-form-item>

    </a-form>
  </div>
</template>

<script>

import { timeFix } from '@/utils/util'
import { mapActions } from 'vuex'
export default {

  data () {
    return {

      loginBtn: false,
      isLoginError: false,
      stepCaptchaVisible: false,
      form: this.$form.createForm(this)

    }
  },
  methods: {
    ...mapActions(['Login', 'Logout']),
    handleSubmit (e) {
      e.preventDefault()
      this.loginBtn = true
      this.form.validateFields(
        (err, values) => {
          if (!err) {
            console.log('login form', values)

            this.Login({ username: values.username, password: values.password })
              .then((res) => this.loginSuccess(res))
              .catch(err => this.requestFailed(err))
              .finally(() => {
                this.loginBtn = false
              })
          } else {
            setTimeout(() => {
              this.loginBtn = false
            }, 600)
          }
        }
      )
    },
    loginSuccess (res) {
      console.log(res)
      this.$router.push({ name: 'dashboard' }, () => {
        this.$notification.success({
          message: '欢迎',
          description: `${timeFix()}，欢迎回来`
        })
      })
      this.isLoginError = false
    },
    requestFailed (err) {
      this.isLoginError = true
      this.$notification['error']({
        message: '错误',
        description: ((err.response || {}).data || {}).message || '请求出现错误，请稍后再试',
        duration: 4
      })
    }
  }
}
</script>

<style lang="less" scoped>
.user-layout-login {
  label {
    font-size: 14px;
  }

  .getCaptcha {
    display: block;
    width: 100%;
    height: 40px;
  }

  .forge-password {
    font-size: 14px;
  }

  button.login-button {
    padding: 0 15px;
    font-size: 16px;
    height: 40px;
    width: 100%;
  }

  .user-login-other {
    text-align: left;
    margin-top: 24px;
    line-height: 22px;

    .item-icon {
      font-size: 24px;
      color: rgba(0, 0, 0, 0.2);
      margin-left: 16px;
      vertical-align: middle;
      cursor: pointer;
      transition: color 0.3s;

      &:hover {
        color: #1890ff;
      }
    }

    .register {
      float: right;
    }
  }
}
</style>
