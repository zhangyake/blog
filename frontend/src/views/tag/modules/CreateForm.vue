<template>
  <a-modal
    title="新增轮播图"
    :width="640"
    :visible="visible"
    :confirmLoading="confirmLoading"
    @ok="handleSubmit"
    @cancel="handleCancel"
    destroyOnClose
  >
    <a-spin :spinning="confirmLoading">
      <a-form :form="form">

        <a-form-item
          label="图片"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-upload
            v-decorator="['imgUrl', {rules: [{required: true, message: '请上传图片'}]}]"
            action="/imagePath"
            listType="picture-card"
            :fileList="fileList"
            @preview="handlePreview"
            @change="handleChange"
          >
            <div v-if="fileList.length < 1">
              <a-icon type="plus" />
              <div class="ant-upload-text">上传</div>
            </div>
          </a-upload>
          <a-modal :visible="previewVisible" :footer="null" @cancel="handleImageCancel">
            <img alt="example" style="width: 100%" :src="previewImage" />
          </a-modal>
        </a-form-item>
        <a-form-item
          label="绑定链接"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-input v-decorator="['bindUrl', {rules: [{required: true, message: '请输入'}]}]" />

        </a-form-item>

        <a-form-item
          label="状态"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-radio-group v-decorator="['enable', {rules: [{required: true, message: '请选择'}]}]">
            <a-radio :value="1">启用</a-radio>
            <a-radio :value="0">禁用</a-radio>
          </a-radio-group>
        </a-form-item>
        <a-form-item
          label="排序"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-input-number v-decorator="['sort', {rules: [{required: true, message: '请输入'}] ,initialValue:0}]" :precision="0" :min="0" style="width:100%" />

        </a-form-item>
        <a-form-item
          label="备注"
          :labelCol="labelCol"
          :wrapperCol="wrapperCol"
        >
          <a-textarea v-decorator="['description']" />
        </a-form-item>
      </a-form>
    </a-spin>
  </a-modal>
</template>

<script>

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
      selectList: [],
      provinces: [],
      cities: [],
      areas: [],
      previewVisible: false,
      previewImage: '',
      fileList: []
    }
  },
  mounted () {

  },
  methods: {
    handleImageCancel () {
      this.previewVisible = false
    },
    handlePreview (file) {
      this.previewImage = file.url || file.thumbUrl
      this.previewVisible = true
    },
    handleChange ({ file, fileList }) {
      this.fileList = fileList
    },
    show () {
      this.visible = true
      this.$nextTick(() => {
        this.form.setFieldsValue({ enable: 1
        })
      })
    },
    handleSubmit () {
      const { form: { validateFields } } = this
      this.confirmLoading = true
      validateFields((errors, values) => {
        if (!errors) {
          var postData = { ...values }
          const arr = this.fileList.map((item) => {
            return item.response.imagePath._id
          })
          postData.imgUrl = arr[0]
          this.$api.insertSwiper(postData).finally(() => {
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
