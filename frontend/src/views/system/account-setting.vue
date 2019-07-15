<template>
  <div>
    <Card>
      <p slot="title">账号设置</p>
      <div style="margin:0 auto;width:400px;">
        <Form
          label-position="right"
          :label-width="120"
          :model="editRow"
          ref="formValidate"
          :rules="ruleValidate"
        >
          <FormItem label="管理员用户:" class="">
            <Input
              v-model="editRow.username"
              style="width:200px"
              placeholder=""
              disabled
            ></Input>
          </FormItem>
          <FormItem label="旧密码:" prop="old_password">
            <Input
              type="password"
              v-model="editRow.old_password"
              style="width:200px"
              placeholder="请输入旧密码"
              clearable
            ></Input>
          </FormItem>
          <FormItem label="新密码:" prop="new_password">
            <Input
              type="password"
              v-model="editRow.new_password"
              style="width:200px"
              placeholder="请输入新密码"
              clearable
            ></Input>
          </FormItem>
          <FormItem label="确认密码:" prop="new_password_confirm">
            <Input
              type="password"
              v-model="editRow.new_password_confirm"
              style="width:200px"
              placeholder="请再次输入新密码"
              clearable
            ></Input>
          </FormItem>

          <FormItem :label-width="160">
            <Button
              type="primary"
              @click="toEdit('formValidate')"
              :loading="loading"
              >修改密码</Button
            >
          </FormItem>
        </Form>
      </div>
    </Card>
  </div>
</template>
<script>
import { myMixin } from '@/utils/mixins.js'
import { getKey } from '@/utils/auth'

export default {
  mixins: [myMixin],
  data () {
    const validatePass = (rule, value, callback) => {
      if (value === '' || value.toString().trim() === '') {
        callback(new Error('请输入密码！'))
      } else if (value.toString().trim().length < 6 || value.toString().trim().length > 12) {
        callback(new Error('密码长度6-12位字符！'))
      } else {
        if (this.editRow.new_password_confirm !== '') {
          // 对第二个密码框单独验证
          this.$refs.formValidate.validateField('new_password_confirm')
        }
        callback()
      }
    }
    const validatePassCheck = (rule, value, callback) => {
      if (value === '' || value.toString().trim() === '') {
        callback(new Error('请再次输入密码！'))
      } else if (value !== this.editRow.new_password) {
        callback(new Error('两次密码输入不一致!'))
      } else {
        callback()
      }
    }
    return {
      labelWidth: 0,
      queryLoading: false,

      loading: false,


      page: 1,
      per_page: 20,
      total: 0,
      showEdit: false,
      showAdd: false,
      addRow: {},
      editRow: {},
      checkboxs: [],
      columns: [
      ],
      tableDatas: [],
      ruleValidate: {
        username: [
          { required: true, message: '账号不能为空！', trigger: 'blur' }
        ],
        old_password: [
          { required: true, message: '请输入旧密码！', trigger: 'blur' }
        ],
        new_password: [
          { required: true, message: '请输入新密码！', trigger: 'blur' },
          { validator: validatePass, trigger: 'change' }
        ],
        new_password_confirm: [
          { required: true, message: '请再次输入新密码！', trigger: 'blur' },
          { validator: validatePassCheck, trigger: 'change' }
        ]
      }
    }
  },
  mounted () {
    this.editRow = { username: getKey('user_name'), old_password: '', new_password: '', new_password_confirm: '' }
  },
  computed: {

  },
  methods: {
    init () {
      this.handleReset('formValidate')
    },
    handleReset (name) {
      this.$refs[name].resetFields()
      this.checkboxs = []
    },
    toEdit (name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.edit(this.editRow)
        }
      })
    },
    edit (data) {
      this.loading = true
      setTimeout(() => {
        this.loading = false
      }, 1000)
      this.api.resetPwd(data).then(res => {
        this.$Message.success({
          content: '修改密码成功 ! 请重新登录!',
          duration: 3
        })
        setTimeout(() => {
          this.$store.dispatch('logOut').then(() => {
            location.reload()
          })
        }, 2000)
      })
    }
  }
}
</script>

<style lang="less" scoped>
.margin-top-10 {
  margin-top: 10px;
}
</style>
