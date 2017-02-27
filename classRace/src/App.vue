<template>
  <div id="app">
    <router-view
      :transition="'vux-pop-' + (direction === 'forward' ? 'in' : 'out')"></router-view>
    <loading :show="isLoading" :text="loadingOpt.text"></loading>
    <toast :show.sync="toastOpt.show" :type="toastOpt.type">{{ toastOpt.text }}</toast>
  </div>
</template>
<script>
  import loading from '../node_modules/vux/src/components/loading/index.vue'
  import toast from 'vux/src/components/toast'
  import store from './vuex/store'

  export default {
    components: {
      loading,
      toast
    },
    store: store,
    vuex: {
      getters: {
        route: (state) => state.route,
        isLoading: (state) => state.isLoading,
        direction: (state) => {
          console.log('state.direction: ' + state.direction)
          return state.direction
        }
      }
    },
    data () {
      return {
        routerTransition: {
          forward: 'slideRL',
          back: 'slideLR'
        },
        loadingOpt: {
          text: '加载中'
        },
        toastOpt: {
          show: false,
          type: 'success',
          text: '操作成功'
        }
      }
    },
    methods: {
      msg (type, msg) {
        this.toastOpt.show = true
        this.toastOpt.type = type
        this.toastOpt.text = msg
      },
      isWeixin () {
        const ag = window.navigator.userAgent.toLowerCase()
        if (/micromessenger/i.test(ag)) {
          return true
        } else {
          return false
        }
      }
    }
  }
</script>

<style lang="less">

  @import '~vux/src/styles/reset';
  *{
    margin: 0;
    padding: 0;list-style: none;}
  body {
    background-color: #fbf9fe;
  }
  .btn-wrapper {
    margin: 10px;
  }
  /**
* vue-router transition
*/
  .vux-pop-out-transition,
  .vux-pop-in-transition {
    width: 100%;
    animation-duration: 0.5s;
    animation-fill-mode: both;
    backface-visibility: hidden;
  }
  .vux-pop-out-enter,
  .vux-pop-out-leave,
  .vux-pop-in-enter,
  .vux-pop-in-leave {
    will-change: transform;
    height: 100%;
    position: absolute;
    left: 0;
  }
  .vux-pop-out-enter {
    animation-name: popInLeft;
  }
  .vux-pop-out-leave {
    animation-name: popOutRight;
  }
  .vux-pop-in-enter {
    perspective: 1000;
    animation-name: popInRight;
  }
  .vux-pop-in-leave {
    animation-name: popOutLeft;
  }
  @keyframes popInLeft {
    from {
      transform: translate3d(-100%, 0, 0);
    }
    to {
      transform: translate3d(0, 0, 0);
    }
  }
  @keyframes popOutLeft {
    from {
      transform: translate3d(0, 0, 0);
    }
    to {
      transform: translate3d(-100%, 0, 0);
    }
  }
  @keyframes popInRight {
    from {
      transform: translate3d(100%, 0, 0);
    }
    to {
      transform: translate3d(0, 0, 0);
    }
  }
  @keyframes popOutRight {
    from {
      transform: translate3d(0, 0, 0);
    }
    to {
      transform: translate3d(100%, 0, 0);
    }
  }
</style>

