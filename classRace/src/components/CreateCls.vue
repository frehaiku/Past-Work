<style>
  .fix-head {
    position: fixed !important;
    width: 100%;
    z-index: 999;
    left: 0;
    top: 0;
  }

  .fix-head-margin {
    padding-top: 46px;
  }
  p.tips{
    margin: 15px 0;
    text-align: center;font-size: 14px;}
  p.tips > a{font-size: 14px;font-family: "Microsoft YaHei";
    color: rgb(0, 147, 217);}
</style>
<template>
  <x-header class="fix-head" :left-options="{showBack: false}">
    <div v-if="myClassId" slot="left" @click="OauthMyCls">我的班级
    </div>
    创建班级
    <div slot="right" @click="nextStep">下一步</div>
  </x-header>
  <p class="tips fix-head-margin">
    <a href="http://mp.weixin.qq.com/s?__biz=MjM5Mzc2MjUwOA==&mid=2650082050&idx=1&sn=2be579dc7c9a0f1948fd3a44bf550e6f&chksm=be93b6a189e43fb72104fd8cd44cb24cda476f41b7f0050d7e9a5da70e6000e2ea01f3fff79c&mpshare=1&scene=1&srcid=1102is0sxY7kCUaxev8YeGGh#wechat_redirect">请先阅读参赛须知</a>
    如有疑问请加大赛Q群：391384459
  </p>
  <step :current="currStep">
    <step-item v-for="stepItem in stepStructs"
               :title="stepItem.title"
               :description="stepItem.description"
               :step-number="stepItem.stepNumber" :step-last="false">
    </step-item>
  </step>
  <actionsheet :show.sync="actionSheetShow" :show-cancel="true"
               :menus="actionSheetMenuConf" cancel-text="取消" @on-click-menu-confirm="renderHandler">
  </actionsheet>
  <router-view @step-form-data="dispatchChild"></router-view>
  <foot></foot>
</template>
<script>
  import XHeader from 'vux/src/components/x-header'
  import Step from 'vux/src/components/step/step.vue'
  import StepItem from 'vux/src/components/step/step-item.vue'
  import Actionsheet from 'vux/src/components/actionsheet'
  import Foot from './common/Foot.vue'

  export default {
    components: {
      XHeader,
      Step,
      StepItem,
      Actionsheet,
      Foot
    },
    ready () {
      this._initStep()
      this.renderMyCls()
    },
    data () {
      return {
        myClassId: false,
        actionSheetShow: false,
        actionSheetMenuConf: {
          'title.noop': '确定提交吗?<br/><span style="color:#666;font-size:12px;">提交后将不能修改</span>',
          confirm: '<span style="color:red">确定</span>'
        },
        currStep: 0,
        formData: {},
        stepStructs: [
          {title: '第一步', description: '填写申请人信息', stepNumber: 1, stepLast: true},
          {title: '第二步', description: '填写班级基本信息', stepNumber: 2, stepLast: true},
          {title: '第三步', description: '填写班级介绍资料', stepNumber: 3, stepLast: true}
        ]
      }
    },
    methods: {
      _initStep () {
        const ind = this.$route.path.match(/\d/)[0]
        this.currStep = parseInt(ind) - 1
      },
      OauthMyCls () {
        window.location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6dead41c7f5b2d5b&redirect_uri=http%3A%2F%2Fhuizhou.us%2Fholehole%2Findex.php%3Fg%3Dunitecls%26m%3Dapplicant%26a%3DclassSpecificsTestTpl%26category%3D' + this.myClassId + '&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect'
      },
      renderMyCls () {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=myClass')
          .then(response => {
            const cls = response.body.data.clsid
            if (cls != null) {
              this.myClassId = cls
            }
          })
      },
      verifyHandler () {
        var verifyRoot = this.formData
        var chinaReg = /^[\u4e00-\u9fa5]{1,}$/
        var trim = str => {
          return str.replace(/\s/g, '')
        }
        switch (this.$route.path) {
          case '/CreateCls/step1':
            if (!chinaReg.test(verifyRoot.fullname)) {
              this.$root.msg('warn', '请输入正确的姓名')
              return false
            }
            if (!/[1-9][0-9]{10}/.test(verifyRoot.tel)) {
              this.$root.msg('warn', '请输入正确的手机号')
              return false
            }
            if (trim(verifyRoot.wechat).length === 0) {
              this.$root.msg('warn', '请输入wechat Id')
              return false
            }
            if (trim(verifyRoot.duties).length === 0) {
              this.$root.msg('warn', '班级职务不能为空')
              return false
            }
            break
          case '/CreateCls/step2':
            if (trim(verifyRoot.grade).length === 0) {
              this.$root.msg('warn', '请选择年级')
              return false
            }
            if (trim(verifyRoot.headmaster).length === 0) {
              this.$root.msg('warn', '请输入班主任姓名')
              return false
            }
        }
      },
      nextStep () {
        // 前端判断所输入数据的有效性
        if (this.verifyHandler() === false) {
          return
        }
        switch (this.$route.path) {
          case '/CreateCls/step3':
            this.submitStep3()
            break
          default:
            this.actionSheetShow = true
            break
        }
      },
      renderHandler () {
        switch (this.$route.path) {
          case '/CreateCls/step1':
            this.submitStep1()
            break
          case '/CreateCls/step2':
            this.submitStep2()
            break
          case '/CreateCls/step3':
            this.submitStep3()
            break
        }
      },
      dispatchChild (childData) {
        this.formData = childData
//        console.log(childData)
      },
      _stepSubmit (url, routeGoal) {
        this.$http.post(url,
          this.formData)
          .then((response) => {
            var responseBody = response.body
            var responseData = responseBody.data
            if (responseBody.state === 'fail') {
              this.$parent.msg('warn', responseBody.info)
            } else {
              this.$parent.msg('success', responseBody.info)
              setTimeout(() => {
                switch (this.$route.path) {
                  case '/CreateCls/step3':
                    window.location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6dead41c7f5b2d5b&redirect_uri=http%3A%2F%2Fhuizhou.us%2Fholehole%2Findex.php%3Fg%3Dunitecls%26m%3Dapplicant%26a%3DclassSpecificsTestTpl%26category%3D' + responseData + '&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect'
//                    this.$router.go({name: 'ClassSpecifics', params: {clsId: responseData}})
                    break
                  default:
                    this.$router.go(routeGoal)
                    break
                }
              }, 500)
            }
          }, (e) => {
            this.$parent.msg('cancel', '服务器错误')
          })
      },
      submitStep1 () {
        this._stepSubmit('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=step1',
          {path: '/CreateCls/step2'})
      },
      submitStep2 () {
        this._stepSubmit('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=step2',
          {path: '/CreateCls/step3'})
      },
      submitStep3 () {
        this._stepSubmit('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=step3', 'defined in _stepSubmit'
        )
      }
    },
    watch: {
      '$route.path': function (val, oldVal) {
        // 根据路由改变步数
        const st = val.match(/\d/)[0]
        this.currStep = parseInt(st) - 1
        // 设置默认的formData 对象
        switch (this.$route.path) {
          case '/CreateCls/step1':
            this.formData = {fullname: '', tel: '', wechat: '', duties: ''}
            break
          case '/CreateCls/step2':
            this.formData = {grade: '', class: '', school: '', clssize: '', headmaster: ''}
            break
          case '/CreateCls/step3':
            this.formData = {slogan: '', clssong: '', clsintrod: ''}
            break
        }
      }
    }
  }
</script>
