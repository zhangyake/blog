<template>
    <a-card :body-style="{padding: '24px 32px'}" :bordered="false">
        <a-form @submit="handleSubmit" :form="form">
            <a-form-item
                    label="标题"
                    :labelCol="{lg: {span: 7}, sm: {span: 7}}"
                    :wrapperCol="{lg: {span: 10}, sm: {span: 17} }">
                <a-input
                        v-decorator="[
            'title',
            {rules: [{ required: true, message: '请输入标题' }]}
          ]"
                        name="name"
                        placeholder="给文章写个标题"/>
            </a-form-item>

            <a-form-item
                    label="简要描述"
                    :labelCol="{lg: {span: 7}, sm: {span: 7}}"
                    :wrapperCol="{lg: {span: 10}, sm: {span: 17} }">
                <a-textarea
                        rows="3"
                        placeholder="输入文章的简述"
                        v-decorator="[
            'preview',
            {rules: [{ required: true, message: '请输入目标描述' }]}
          ]"/>
            </a-form-item>
            <a-form-item
                    label="文章内容"
                    :labelCol="{lg: {span: 7}, sm: {span: 7}}"
                    :wrapperCol="{lg: {span: 10}, sm: {span: 17} }">
                <a-textarea
                        rows="15"
                        placeholder="开始书写文章吧"
                        v-decorator="[
            'content',
            {rules: [{ required: true, message: '请输入目标描述' }]}
          ]"/>
            </a-form-item>

            <a-form-item
                    label="发布状态"
                    :labelCol="{lg: {span: 7}, sm: {span: 7}}"
                    :wrapperCol="{lg: {span: 10}, sm: {span: 17} }"
                    :required="false"

            >
                <a-radio-group v-model="status">
                    <a-radio :value="1">公开</a-radio>
                    <a-radio :value="2">不公开</a-radio>
                </a-radio-group>

            </a-form-item>
            <a-form-item
                    :wrapperCol="{ span: 24 }"
                    style="text-align: center"
            >
                <a-button htmlType="submit" type="primary">发布文章</a-button>
                <a-button style="margin-left: 8px" @click="toSaveArticle">保存草稿</a-button>
            </a-form-item>
        </a-form>
    </a-card>
</template>

<script>
    export default {
        name: 'BaseForm',
        data() {
            return {
                status: 1,
                // form
                form: this.$form.createForm(this)
            }
        },
        methods: {
            // handler
            handleSubmit(e) {
                e.preventDefault()
                this.form.validateFields((err, values) => {
                    if (!err) {
                        this.$api.insertArticle({status: this.status, ...values}).finally(() => {


                        })
                    }
                })
            },
            toSaveArticle() {
                this.form.validateFields((err, values) => {
                    if (!err) {
                        this.$api.insertArticle({status: 0, ...values}).finally(() => {


                        })
                    }
                })
            }

        }
    }
</script>