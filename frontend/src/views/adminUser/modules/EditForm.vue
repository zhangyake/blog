<template>
  <a-modal
    title="编辑账号信息"
    :width="640"
    :visible="visible"
    :confirmLoading="confirmLoading"
    @ok="handleSubmit"
    @cancel="handleCancel"
  >
    <a-spin :spinning="confirmLoading">
      <a-form :form="form">
        <a-form-item
          label="账号"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-input v-decorator="['account', {rules: [{required: true, message: '请输入'}]}]" />

        </a-form-item>
        <a-form-item
          label="手机号"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-input v-decorator="['phone', {rules: [{required: true, message: '请输入'}]}]" />

        </a-form-item>

        <a-form-item
          label="描述"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >

          <a-textarea v-decorator="['description']" :autosize="{ minRows: 3, maxRows: 6 }"/>        </a-form-item>

      </a-form>
    </a-spin>
  </a-modal>
</template>

<script>
import { pick, keys } from 'lodash'
export default {
  data () {
    return {
      labelCol: {
        xs: { span: 24 },
        sm: { span: 7 }
      },
      wrapperCol: {
        xs: { span: 24 },
        sm: { span: 13 }
      },
      visible: false,
      confirmLoading: false,

      form: this.$form.createForm(this),
      id: 0
    }
  },
  mounted () {

  },
  methods: {
    edit (record) {
      this.visible = true
      const { form: { setFieldsValue } } = this
      console.log(this.form)
      this.id = record.id
      this.$nextTick(() => {
        setFieldsValue(pick(record, keys(this.form.domFields)))
      })
    },
    handleSubmit () {
      const { form: { validateFields } } = this
      this.confirmLoading = true
      validateFields((errors, values) => {
        if (!errors) {
          console.log('values', values)
          this.$api.updateAdminUser({ id: this.id, ...values }).finally(() => {
            this.visible = false
            this.confirmLoading = false
            this.$emit('ok')
          })
        } else {
          this.confirmLoading = false
        }
      })
    },
    handleCancel () {
      this.visible = false
    }
  }
}
</script>
