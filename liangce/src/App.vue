<template>
  <div id="app">
    <topic :diyTopic='navTitle'
           :backShow="backShow"
           link="/xxx">
      <router-link class="fr side"
                   v-if="showRight"
                   to="/applyList"
                   tag="span">我的
      </router-link>
    </topic>
    <transition :name="transformName">
      <router-view></router-view>
    </transition>

    <toast></toast>

    <div id="loading-wrap" :class="{dn: !loadStatus}">
      <div id="mask">
        <span class="rotate" id="loading"></span>
        <p>加载中</p>
      </div>
    </div>

  </div>
</template>


<script>
  import topic from './components/topic/index.vue'
  import {navMap} from './libs/navMap'
  import toast from './components/toast'

  import {mapGetters} from 'vuex'

  export default {
    name: 'app',
    data() {
      return {
        navTitle: "...",
        showRight: false,
        transformName: 'slide-left',
        isInitial: true
      }
    },
    computed: {
      ...mapGetters([
        "loadStatus"
      ]),
      backShow () {
        return (this.$route.path == '/home') ? 0 : 1
      }
    },
    methods: {
      // 计算前进还是后退动画
      _computedForward(to) {
        const noncePath = to.fullPath,
                format = JSON.stringify([noncePath])

        const KEY = 'history'

        let historyInd = -1,
                exist

        if (this.isInitial) {
          window.sessionStorage.setItem(KEY, '')
        }
        this.isInitial = false

        exist = window.sessionStorage.getItem(KEY) ?
                JSON.parse(window.sessionStorage.getItem(KEY)) :
                window.sessionStorage.getItem(KEY)
        //                console.log(window.sessionStorage.getItem(KEY))
        if (!exist) {
          this.transformName = 'slide-left'
          window.sessionStorage.setItem(KEY, format)
        } else {
          if ((historyInd = exist.indexOf(noncePath)) == -1) {
            exist.push(noncePath)
            this.transformName = 'slide-left'
          } else {
            exist.splice(historyInd)
            this.transformName = 'slide-right'
          }
          window.sessionStorage.setItem(KEY, JSON.stringify(exist))
        }
      },
      _clearStorage() {
        window.sessionStorage.setItem()
      }
    },
    components: {
      topic,
      toast
    },
    watch: {
      $route: function (to) {
        const vm = this,
                path = to.path,
                name = to.name

        // 在主页时显示我的
        this.showRight = (path == '/home')

        // 根据路由对标题做特殊处理
        if (name == 'uploadImg') {
          this.navTitle = to.params.item
        } else {
          // 匹配标题Map
          const isMap = navMap.some(ele => {
            if (ele.path === path) {
              vm.navTitle = ele.navName
              return true
            }
          })
          // 不匹配设置默认导航文字
          if (!isMap)
            this.navTitle = '按揭贷款'
        }

        this._computedForward(to)
      }
    }
  }
</script>
<style lang="less">
  @import "./assets/css/custom.less";

  input, select, textarea {
    -webkit-appearance: none !important;
    -webkit-tap-highlight-color: transparent;
    font-size: .26rem;
  }

  ::-webkit-input-placeholder {
    font-size: .26rem;
  }

  #loading-wrap {
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    position: fixed;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

  #mask {
    padding: 20px 30px;
    border-radius: 5px;
    background-color: rgba(0, 0, 0, 0.5);
  }

  span, p {
    font-size: .3rem;
    display: block;
    padding: 3px;
    color: #ffffff;
  }

  }

  #loading {
    width: .7rem;
    height: .7rem;
    border-width: 3px;
    border-color: #fff;
    border-right-color: transparent;
    border-style: solid;
    border-radius: 50%;
    animation: loadingRotate 1s linear infinite;
    margin-bottom: 5px;
  }

  #app {
    margin-top: .9rem;
  }

  .slide-left-enter-active,
  .slide-left-leave-active,
  .slide-right-enter-active,
  .slide-right-leave-active {
    will-change: transform;
    transition: all ease-out 500ms;
    height: 100%;
    position: absolute;
    left: 0;
    top: .9rem;
    backface-visibility: hidden;
    perspective: 1000;
  }

  .slide-left-enter {
    opacity: 0;
    transform: translate3d(-100%, 0, 0);
  }

  .slide-left-leave-active {
    opacity: 0;
    transform: translate3d(100%, 0, 0);
  }

  .slide-right-enter {
    opacity: 0;
    transform: translate3d(100%, 0, 0);
  }

  .slide-right-leave-active {
    opacity: 0;
    transform: translate3d(-100%, 0, 0);
  }

  @keyframes loadingRotate {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>