<template>
  <div style="margin-bottom: 58px;" v-bottom-split-page>
    <swiper :list="swiperList" :auto="true" :loop="true"></swiper>
    <ul id="statistical">
      <li>
        <p>班级参与</p>
        <p>{{initData.class}}</p>
      </li>
      <li>
        <p>累计支持</p>
        <p>{{initData.vote}}</p>
        <span class="split-1"></span>
      </li>
      <li>
        <p>访问量</p>
        <p>{{initData.click}}</p>
        <span class="split-2"></span>
      </li>
    </ul>
    <div class="count-down">
      <span class="icon"><img src="http://img.huizhou.us/best-class/jing-zhong.svg" alt=""></span>
      <p>距活动结束还有：<br>
        <count-down @send-init="getInitData"></count-down>
      </p>
    </div>
    <div class="activity-msg">
      <img src="http://img.huizhou.us/best-class/shi-jian.svg" alt="" class="msgicon">
      活动时间：2016年11月18日至2016年11月27日
    </div>
    <div class="activity-msg" @click="briefShow = true" style="font-weight: 700;">
      <img src="http://img.huizhou.us/best-class/introduce.svg" alt="" class="msgicon">
      活动简介
      <img src="http://img.huizhou.us/best-class/more.svg" alt="" class="more-act">
    </div>
    <ul id="categorise">
      <li v-for="cateItem in categorise"
          :class="{selected: cateItem.active, primary: !cateItem.active}"
          @click="changeCategorise($index)"
      >
        <p>
          <img v-if="!cateItem.active" :src="cateItem.originImg" alt="">
          <img v-if="cateItem.active" :src="cateItem.changeImg" alt="">
        </p>
        <p>{{cateItem.name}}</p>
      </li>
    </ul>
    <!--具体班级列表展示-->
    <ul class="classTabulation">
      <li class="classSub"
          v-for="classHeapItem in classHeap"
          v-link="{name: 'ClassSpecifics', params: {clsId: classHeapItem.clsid}}"
      >
        <span class="clsNum">{{classHeapItem.clsid}}</span>
        <img :src="classHeapItem.photolist" alt="" class="cover">
        <div class="vote">
          <span class="font" @click.stop="voteThs(classHeapItem.clsid)">支持</span>
          <span class="voteNum">{{classHeapItem.vote}}</span>
          <span class="clsName">高{{classHeapItem.grade}}{{classHeapItem.class}}班</span>
        </div>
        <p class="clsIntrod">
          By:&nbsp;{{classHeapItem.school}}
          <br>
          {{classHeapItem.slogan}}
        </p>
      </li>
    </ul>

  </div>
  <!-- 活动简介图片 -->
  <dialog :show.sync="briefShow">
    <img src="http://img.huizhou.us/best-class/jianjie.jpg?imageMogr2/thumbnail/x500" style="max-width:100%">
    <span class="brief-close" @click="briefShow = false"></span>
  </dialog>
  <!-- 奖项图片 -->
  <dialog :show.sync="priceShow">
    <img src="http://img.huizhou.us/best-class/jiangxiang.jpg?imageMogr2/thumbnail/x500" style="max-width:100%">
    <span class="brief-close" @click="priceShow = false"></span>
  </dialog>
  <!-- 底部导航fixed -->
  <tabbar id="fixedNav">
    <tabbar-item @click="oSearch.show = true">
      <img slot="icon" src="http://img.huizhou.us/best-class/sou-suo.svg" alt="">
      <span slot="label" class="navName">搜索</span>
    </tabbar-item>
    <tabbar-item
      v-if="initData.hasClass == null"
      @click="jumpStep1">
      <img slot="icon" src="http://img.huizhou.us/best-class/team.svg" alt="">
      <span slot="label" class="navName">报名</span>
    </tabbar-item>
    <tabbar-item
      v-else
      @click="jumpStep1">
      <img slot="icon" src="http://img.huizhou.us/best-class/team.svg" alt="">
      <span slot="label" class="navName">我的班级</span>
    </tabbar-item>
    <tabbar-item @click="priceShow = true">
      <img slot="icon" src="http://img.huizhou.us/best-class/jiang-xiang.svg" alt="">
      <span slot="label" class="navName">奖项</span>
    </tabbar-item>
  </tabbar>
  <!-- 搜索弹出框 -->
  <popup :show.sync="oSearch.show" height="400px">
    <tab :index.sync="oSearch.nonthInd" active-color="#E34140">
      <tab-item selected>编号搜索</tab-item>
      <tab-item>班级搜索</tab-item>
    </tab>
    <group v-show="oSearch.nonthInd == 0">
      <x-input placeholder="请输入班级编号"
               :value.sync="oSearch.searchClsid.clsid">
      </x-input>
      <div class="btn-wrapper">
        <x-button type="warn" @click="search(oSearch.searchClsid)">搜索</x-button>
      </div>
    </group>
    <div v-show="oSearch.nonthInd == 1">
      <cls-basic @dispatch-basic-msg="updateInfo"></cls-basic>
      <div class="btn-wrapper">
        <x-button type="warn" @click="search(oSearch.searchMsg)">搜索</x-button>
      </div>
    </div>

    <!--<swiper :show-dots="false" :show-desc-mask="false" loop>
      &lt;!&ndash; 编号搜索 &ndash;&gt;
      <swiper-item>

      </swiper-item>
      &lt;!&ndash; 班级搜索 &ndash;&gt;
      <swiper-item>
        <cls-basic @dispatch-basic-msg="updateInfo"></cls-basic>
        <div class="btn-wrapper">
          <x-button type="warn" @click="search(oSearch.searchClsid)">搜索</x-button>
        </div>
      </swiper-item>
    </swiper>-->
  </popup>
</template>
<script>
  import {
    Swiper,
    SwiperItem,
    Dialog,
    Tabbar,
    TabbarItem,
    Scroller,
    Popup,
    Group,
    Cell,
    XInput,
    XButton
  } from 'vux/src/components'
  import {Tab, TabItem} from 'vux/src/components/tab/index'
  import countDown from './common/EndCountDown.vue'
  import ClsBasic from './common/ClsBasicMsg.vue'
  export default {
    components: {
      Swiper,
      SwiperItem,
      Dialog,
      Tabbar,
      TabbarItem,
      Scroller,
      countDown,
      Tab,
      TabItem,
      Popup,
      Group,
      Cell,
      XInput,
      XButton,
      ClsBasic
    },
    data () {
      let categorise = [
        {
          originImg: 'http://img.huizhou.us/best-class/fa-xian.svg',
          changeImg: 'http://img.huizhou.us/best-class/fa-xian-change.svg',
          name: '发现班集体',
          active: 1
        },
        {
          originImg: 'http://img.huizhou.us/best-class/zui-xin-can-yu.svg',
          changeImg: 'http://img.huizhou.us/best-class/zui-xin-can-yu-change.svg',
          name: '最新参与',
          active: 0
        },
        {
          originImg: 'http://img.huizhou.us/best-class/fang-wen-liang.svg',
          changeImg: 'http://img.huizhou.us/best-class/fang-wen-liang-change.svg',
          name: '人气排行',
          active: 0
        }
      ]
      let oSearch = {
        show: false, searchClsid: {clsid: 0},
        searchMsg: {
          school: '',
          grade: '',
          class: ''
        },
        nonthInd: 0
      }
      return {
        swiperList: [{
          url: 'http://huizhou.us/a/best-class/goto.html',
          img: 'http://img.huizhou.us/best-class/ad1.jpg?imageMogr2/thumbnail/x280/strip/quality/50',
          title: '最团结班级评比大赛•参赛须知'
        }, {
          url: 'http://huizhou.us/banfu',
          img: 'http://img.huizhou.us/best-class/ad2.jpg?imageMogr2/thumbnail/x280/strip/quality/50',
          title: '惠州史上最快的班服定制  隔天到货'
        }],
        categorise,
        briefShow: false,
        priceShow: false,
        oSearch,
        initData: {},
        classHeap: [], //heap 堆
        nonceConf: {taxis: '', page: 1}, // 当前页数
      }
    },
    directives: {
      'bottom-split-page': {
        bind () {
          window.addEventListener('scroll', this.vm.isBottom, false)
        },
        unbind () {
          window.removeEventListener('scroll', this.vm.isBottom, false)
        }
      }
    },
    beforeCompile () {
      window.removeEventListener('scroll', this.isBottom, false)
    },
    ready () {
      this.getClassHeap(this.nonceConf.taxis, this.nonceConf.page)
      window.sessionStorage.setItem('isVote', 1)
    },
    beforeDestroy () {
      this.nonceConf.page = 1
    },
    methods: {
      isBottom () {
        let ths = this;
        //滚动条在Y轴上的滚动距离
        function getScrollTop() {
          var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
          if (document.body) {
            bodyScrollTop = document.body.scrollTop;
          }
          if (document.documentElement) {
            documentScrollTop = document.documentElement.scrollTop;
          }
          scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
          return scrollTop;
        }

//文档的总高度

        function getScrollHeight() {
          var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
          if (document.body) {
            bodyScrollHeight = document.body.scrollHeight;
          }
          if (document.documentElement) {
            documentScrollHeight = document.documentElement.scrollHeight;
          }
          scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;
          return scrollHeight;
        }

//浏览器视口的高度

        function getWindowHeight() {
          var windowHeight = 0;
          if (document.compatMode == "CSS1Compat") {
            windowHeight = document.documentElement.clientHeight;
          } else {
            windowHeight = document.body.clientHeight;
          }
          return windowHeight;
        }
        if (getScrollTop() + getWindowHeight() == getScrollHeight()) {
          ths.loadMore()
        }
      },
      loadMore () {
        this.getClassHeap(this.nonceConf.taxis, ++this.nonceConf.page)
//        this.$broadcast('pullup:reset', uuid)
      },
      onSearchTab (ind) { // search框点击tab
//        console.log(this.oSearch.show)
        this.oSearch.nonthInd = ind
      },
      updateInfo (msg) { // 子组件传值
        this.oSearch.searchMsg.school = msg.schoolInfo[1] || ''
        this.oSearch.searchMsg.class = msg.classInfo[0] || ''
        this.oSearch.searchMsg.grade = msg.gradeInfo
      },
      search (obj) {
        this.$http.post('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=clsSearch',
          obj)
          .then(response => {
            const iferror = response.body.status
            if (iferror == 'error') {
              const err = response.body.info
              this.$root.msg('warn', err)
            } else {
              const clss = response.body.data.class
              this.$router.go({name: 'ClassSpecifics', params: {clsId: clss}})
            }
          })
      },
      voteThs (clsid) {
        if (this.$root.isWeixin() === false) {
          this.$root.msg('warn', '请往公众号“惠州学生汇”发送“投票”后进入本页面')
        } else {
          this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=vote&classid=' + clsid)
            .then(response => {
              var responseJson = response.body
              if (responseJson.state === 'fail') {
                this.$root.msg('warn', responseJson.info)
              } else {
                this.$root.msg('success', responseJson.info)
              }
            })
        }
      },
      jumpStep1 () {
        window.location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6dead41c7f5b2d5b&redirect_uri=http%3A%2F%2Fhuizhou.us%2Fholehole%2Findex.php%3Fg%3Dunitecls%26m%3Dapplicant%26a%3Dstep1TplTest&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect'
      },
      getClassHeap (taxis, p) { // taxis 排序
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=clsSummary&label=' + taxis + '&page=' + p)
          .then(response => {
            var becameCn = cls => {
              switch (cls) {
                case '1':
                  return '一';
                case '2':
                  return '二';
                case '3':
                  return '三';
              }
            }
            // 处理年级为汉字
            response.body.data.forEach((ele, ind) => {
              response.body.data[ind].grade = becameCn(ele.grade)
            })
            this.classHeap = this.classHeap.concat(response.body.data)
          })
      },
      changeCategorise ($ind) {   // 点tab改变列表
        if (this.categorise[$ind].active == 1) return
//        window.scrollTo(0, 0) // 防止额外请求接口
        this.categorise.every((ele, ind) => {
          if (ele.active == 1) {
            ele.active = 0
            this.categorise.splice(ind, 1, ele)
            return false
          } else {
            return true
          }
        })
        const goal = Object.assign({}, this.categorise[$ind], {active: 1})
        this.categorise.splice($ind, 1, goal)
        // sync http
        let taxis
        switch ($ind) {
          case 0:
            taxis = ''
            break
          case 1:
            taxis = 'new'
            break
          case 2:
            taxis = 'popular'
        }
        // reset
        this.classHeap = []
        this.nonceConf.page = 1
        this.nonceConf.taxis = taxis

        this.getClassHeap(taxis, this.nonceConf.page)
      },
      getInitData (val) { // 回调countDown组件$dispatch
        this.initData = val
      }
    }
  }
</script>
<style lang="less" scoped rel="stylesheet/less">
  @import "../less/ballot.less";
</style>
