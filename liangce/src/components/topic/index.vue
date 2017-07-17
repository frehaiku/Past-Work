<template>
  <div>
    <header class="tac">
      <img v-show="backShow" @click="goBack" src="~imgPath/back.png" class="fl"/>

      {{diyTopic}}
      <slot></slot>
    </header>
  </div>
</template>

<script>
  import {mapState, mapGetters} from 'vuex'

  export default{
    computed: {
      ...mapGetters([
        'tempRouter'
      ]),
      ...mapState({
        'isModifyRole': state => state.modify.isModifyRole,
        'addRoleInitHistoryLen': state => state.modify.addRoleInitHistoryLen
      })
    },
    data(){
      return {}
    },
    methods: {
      goBack () {
        let routeName = this.$route.name
        console.log(this.tempRouter)
        // 特殊处理

        if (routeName == 'applyInform') {
          this.isModifyRole ?
            this.$router.go(-(window.history.length - this.addRoleInitHistoryLen + 1)) :
            this.$router.back()
          /*query.operation ?
            this.$router.replace({path: '/showImgList'}) :
            this.$router.push({name: 'applyDisplay', params: this.$route.params})*/
        } else {
          this.$router.back()
        }
//        this.$router.back()
        this.$store.commit('HIDE_LOADING')
      }
    },
    props: ['diyTopic', 'link', 'backShow']
  }
</script>

<style scoped lang="less">
  @import "~cssPath/custom.less";

  header {
    height: 0.9rem;
    /*background: #fa4141;*/
    background: @topRed;
    line-height: 0.9rem;
    color: white;
    font-size: 0.34rem;
    z-index: 279;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
  }

  header img {
    position: absolute;
    top: 50%;
    padding: .3rem .3rem .3rem .2rem;
    height: 0.33rem;
    transform: translateY(-50%);
    left: 0;
  }

  .side {
    position: absolute;
    right: 0.2rem;
    top: 50%;
    transform: translateY(-50%);
  }
</style>