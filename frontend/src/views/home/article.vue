<template>
  <div class="page-header-index-wide page-header-wrapper-grid-content-main">
    <a-row :gutter="24">
      <a-col :md="24" :lg="7">
        <a-card :bordered="false">
          <div class="account-center-avatarHolder">
            <div class="avatar">
              <img :src="avatar()">
            </div>
            <div class="username">{{ nickname() }}</div>
            <div class="bio">海纳百川，有容乃大</div>
          </div>
          <div class="account-center-detail">
            <p>
              <i class="title"></i>交互专家
            </p>
            <p>
              <i class="group"></i>蚂蚁金服－某某某事业群－某某平台部－某某技术部－UED
            </p>
            <p>
              <i class="address"></i>
              <span>浙江省</span>
              <span>杭州市</span>
            </p>
          </div>
          <a-divider/>

          <div class="account-center-tags">
            <div class="tagsTitle">标签</div>
            <div>
              <template v-for="(tag, index) in tags">
                <a-tooltip v-if="tag.length > 20" :key="tag" :title="tag">
                  <a-tag
                    :key="tag"
                    :closable="index !== 0"
                    :afterClose="() => handleTagClose(tag)"
                  >{{ `${tag.slice(0, 20)}...` }}</a-tag>
                </a-tooltip>
                <a-tag
                  v-else
                  :key="tag"
                  :closable="index !== 0"
                  :afterClose="() => handleTagClose(tag)"
                >{{ tag }}</a-tag>
              </template>
              <a-input

                ref="tagInput"
                type="text"
                size="small"
                :style="{ width: '78px' }"

              />

            </div>
          </div>
          <a-divider :dashed="true"/>

          <div class="account-center-team">
            <div class="teamTitle">团队</div>
            <a-spin :spinning="teamSpinning">
              <div class="members">
                <a-row>
                  <a-col :span="12" v-for="(item, index) in teams" :key="index">
                    <a>
                      <a-avatar size="small" :src="item.avatar"/>
                      <span class="member">{{ item.name }}</span>
                    </a>
                  </a-col>
                </a-row>
              </div>
            </a-spin>
          </div>
        </a-card>
      </a-col>
      <a-col :md="24" :lg="17">

        <a-card
          style="width:100%"
          :bordered="false"
        > <a-skeleton :loading="loading">
          <div>
            <h2 v-text="article.title"> </h2>
            <p>1个月前 / 浏览量 1345 /  评论5 / 点赞9 </p>
            <a-divider/>

            <div class="markdown-body" v-html="article.content"></div>
          </div>
        </a-skeleton>
        </a-card>

        <a-divider/>

        <a-card
          style="width:100%"
          :bordered="false"
        >
          <a-skeleton :loading="loading">

            <a-list
              v-if="comments.length"
              :dataSource="comments"
              :header="`${comments.length} ${comments.length >= 1 ? 'replies' : 'reply'}`"
              itemLayout="vertical"
            >
              <a-list-item slot="renderItem" slot-scope="item, index">
                <a-comment
                  :author="item.user.nickname"
                  :avatar="item.user.avatar"
                  :datetime="item.created_at"
                >
                  <div slot="content" style="width:100%;">
                    {{ item.content }}
                  </div>

                  <template slot="actions">
                    <span>
                      <a-tooltip title="Like">
                        <a-icon type="like" :theme=" item.like_count ? 'filled' : 'outlined'" @click="like" />
                      </a-tooltip>
                      <span style="padding-left: '8px';cursor: 'auto'">
                        {{ item.like_count }}
                      </span>
                    </span>
                    <span>评论</span>
                  </template>
                  <a-comment >
                    <a-avatar
                      slot="avatar"
                      src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
                      alt="Han Solo"
                    />
                    <div slot="content" style="width:100%">

                      <a-input-search placeholder="评论" @search="toReplay" >
                        <a-button type="primary" slot="enterButton">评论</a-button>
                      </a-input-search>

                    </div>
                  </a-comment>
                </a-comment>

              </a-list-item>

            </a-list>

          </a-skeleton>
        </a-card>
        <a-divider/>

        <a-card
          style="width:100%"
          :bordered="false"
        >
          <a-skeleton :loading="loading">
            <div>

              <!-- <a-button type="dashed" block > <a-icon type="info" /> 请勿发布不友善或者负能量的内容。与人为善，比聪明更重要！ </a-button> -->
              <a-textarea v-model="comment" :autosize="{ minRows: 4, maxRows: 4 }" placeholder="请勿发布不友善或者负能量的内容。与人为善，比聪明更重要！" />

              <a-button type="primary" @click="storeArticleComment" style="float:right;top:5px;">评论</a-button>

            </div>
          </a-skeleton>
        </a-card>
      </a-col>
    </a-row>
    <a-back-top />

  </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
  components: {

  },
  data () {
    return {
      article: {},
      tags: ['很有想法的', '专注设计', '辣~', '大长腿', '川妹子', '海纳百川'],
      loading: true,
      teams: [],
      teamSpinning: false,
      comment: '',
      comments: [],
      noTitleKey: 'app'
    }
  },
  mounted () {
    console.log()
    this.handleQuery(this.$route.params.id)
  },
  methods: {
    ...mapGetters(['nickname', 'avatar']),
    handleQuery (id) {
      this.loading = true
      this.$api.getArticleDetail({ id }).then(res => {
        this.article = res.data
      }).finally(() => {
        setTimeout(() => {
          this.loading = false
        }, 300)
      })
      this.$api.getArticleComment({ id }).then(res => {
        this.comments = res.data
      }).finally(() => {

      })
    },
    storeArticleComment () {
      this.loading = true
      this.$api.storeArticleComment({ id: this.article.id, content: this.comment }).then(res => {
        this.comment = ''
      }).finally(() => {
        setTimeout(() => {
          this.loading = false
        }, 300)
      })
    },
    like () {

    },
    toReplay () {
      this.loading = true
      this.$api.storeArticleComment({ id: this.article.id, content: this.comment }).then(res => {
        this.comment = ''
      }).finally(() => {
        setTimeout(() => {
          this.loading = false
        }, 300)
      })
    }
  }
}
</script>

<style lang="less" scoped>
.page-header-wrapper-grid-content-main {
  width: 100%;
  height: 100%;
  min-height: 100%;
  transition: 0.3s;

  .account-center-avatarHolder {
    text-align: center;
    margin-bottom: 24px;

    & > .avatar {
      margin: 0 auto;
      width: 104px;
      height: 104px;
      margin-bottom: 20px;
      border-radius: 50%;
      overflow: hidden;
      img {
        height: 100%;
        width: 100%;
      }
    }

    .username {
      color: rgba(0, 0, 0, 0.85);
      font-size: 20px;
      line-height: 28px;
      font-weight: 500;
      margin-bottom: 4px;
    }
  }

  .account-center-detail {
    p {
      margin-bottom: 8px;
      padding-left: 26px;
      position: relative;
    }

    i {
      position: absolute;
      height: 14px;
      width: 14px;
      left: 0;
      top: 4px;
      background: url(https://gw.alipayobjects.com/zos/rmsportal/pBjWzVAHnOOtAUvZmZfy.svg);
    }

    .title {
      background-position: 0 0;
    }
    .group {
      background-position: 0 -22px;
    }
    .address {
      background-position: 0 -44px;
    }
  }

  .account-center-tags {
    .ant-tag {
      margin-bottom: 8px;
    }
  }

  .account-center-team {
    .members {
      a {
        display: block;
        margin: 12px 0;
        line-height: 24px;
        height: 24px;
        .member {
          font-size: 14px;
          color: rgba(0, 0, 0, 0.65);
          line-height: 24px;
          max-width: 100px;
          vertical-align: top;
          margin-left: 12px;
          transition: all 0.3s;
          display: inline-block;
        }
        &:hover {
          span {
            color: #1890ff;
          }
        }
      }
    }
  }

  .tagsTitle,
  .teamTitle {
    font-weight: 500;
    color: rgba(0, 0, 0, 0.85);
    margin-bottom: 12px;
  }
}
</style>
