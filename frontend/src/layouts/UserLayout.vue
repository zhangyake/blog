<template>
  <div id="userLayout" :class="['user-layout-wrapper', device]">
    <div class="bruce">
      <ul class="bubble-bgwall">
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
        <li>Love</li>
      </ul>
    </div>
    <div class="container">
      <div class="top">
        <div class="header">
          <a href="/">
            <img src="~@/assets/logo.png" class="logo" alt="logo">
            <span class="title">博客后台
            </span>
          </a>
        </div>
        <div class="desc">

        </div>
      </div>

      <route-view></route-view>

      <div class="footer">
        <div class="links">
          <!-- <a href="_self">帮助</a>
          <a href="_self">隐私</a>
          <a href="_self">条款</a> -->
        </div>
        <div class="copyright">
          Copyright &copy; 2019 blue sky
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import RouteView from './RouteView'
import { mixinDevice } from '@/utils/mixin'

export default {
  name: 'UserLayout',
  components: { RouteView },
  mixins: [mixinDevice],
  data () {
    return {}
  },
  mounted () {
    document.body.classList.add('userLayout')
  },
  beforeDestroy () {
    document.body.classList.remove('userLayout')
  }
}
</script>
<style lang="less">
.bruce {
  background-image: linear-gradient(270deg, #8146b4, #6990f6);
  height: 100%;
  position:fixed;
  top: 0;
  left: 0;
  width: 100%;
  bottom: 0;
}
.bubble-bgwall {
	overflow: hidden;
	position: relative;
	margin: 0 auto;
	width: 1200px;
	height: 100%;
	li {
		display: flex;
		position: absolute;
		bottom: -200px;
		justify-content: center;
		align-items: center;
    border-radius: 80% 0 55% 50%  e('/') 55% 0 80% 50%;
		width: 50px;
		height: 50px;
		background-color: rgba(#fff, .15);
		color: #ccc;
		animation: bubble 15s infinite;
		&:nth-child(1) {
			left: 10%;
		}
		&:nth-child(2) {
			left: 20%;
			width: 40px;
			height: 40px;
			animation-duration: 7s;
			animation-delay: 2s;
		}
		&:nth-child(3) {
			left: 25%;
			animation-delay: 4s;
		}
		&:nth-child(4) {
			left: 40%;
			width: 60px;
			height: 60px;
			background-color: rgba(#fff, .3);
			animation-duration: 8s;
		}
		&:nth-child(5) {
			left: 70%;
		}
		&:nth-child(6) {
			left: 80%;
			width: 50px;
			height: 50px;
			background-color: rgba(#fff, .2);
			animation-delay: 3s;
		}
		&:nth-child(7) {
			left: 32%;
			width: 60px;
			height: 60px;
			animation-delay: 2s;
		}
		&:nth-child(8) {
			left: 55%;
			width: 40px;
			height: 40px;
			font-size: 12px;
			animation-duration: 15s;
			animation-delay: 4s;
		}
		&:nth-child(9) {
			left: 25%;
			width: 40px;
			height: 40px;
			background-color: rgba(#fff, .3);
			font-size: 12px;
			animation-duration: 12s;
			animation-delay: 2s;
		}
		&:nth-child(10) {
			left: 85%;
			width: 60px;
			height: 60px;
			animation-delay: 5s;
		}
	}
}
@keyframes bubble {
	100% {
		opacity: .5;
		transform: translateY(0) rotate(-45deg);
	}
	50% {
		opacity: .75;
		transform: translateY(-400px) rotate(-45deg);
	}
	25% {
		opacity: 1;
		transform: translateY(-600px) rotate(-45deg);
	}
	0% {
		opacity: 0;
		transform: translateY(-1000px) rotate(-45deg);
	}
}
</style>
<style lang="less" scoped>
  #userLayout.user-layout-wrapper {
    height: 100%;

    &.mobile {
      .container {
        .main {
          max-width: 368px;
          width: 98%;
        }
      }
    }

    .container {
      width: 100%;
      min-height: 100%;
      // background: #f0f2f5 url(~@/assets/background.svg) no-repeat 50%;
      // background-size: 100%;
      padding: 130px 0 114px;
      position: relative;

      a {
        text-decoration: none;
      }

      .top {
        text-align: center;

        .header {
          height: 44px;
          line-height: 44px;

          .badge {
            position: absolute;
            display: inline-block;
            line-height: 1;
            vertical-align: middle;
            margin-left: -12px;
            margin-top: -10px;
            opacity: 0.8;
          }

          .logo {
            height: 44px;
            vertical-align: top;
            margin-right: 16px;
            border-style: none;
          }

          .title {
            font-size: 28px;
            color: rgba(0,0,0,.85);
            font-family: Avenir, 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-weight: 600;
            position: relative;
            top: 2px;
          }
        }
        .desc {
          font-size: 14px;
          color: rgba(243, 241, 241, 0.8);
          margin-top: 12px;
          margin-bottom: 40px;
        }
      }

      .main {
        min-width: 260px;
        width: 368px;
        margin: 0 auto;
      }

      .footer {
        position: absolute;
        width: 100%;
        bottom: 0;
        padding: 0 16px;
        margin: 48px 0 24px;
        text-align: center;

        .links {
          margin-bottom: 8px;
          font-size: 14px;
          a {
            color: rgba(0, 0, 0, 0.45);
            transition: all 0.3s;
            &:not(:last-child) {
              margin-right: 40px;
            }
          }
        }
        .copyright {
          color: rgba(245, 241, 241, 0.8);
          font-size: 14px;
        }
      }
    }
  }
</style>
