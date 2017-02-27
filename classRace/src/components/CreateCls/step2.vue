<template>
  <!-- 选择学校，年级，班级 -->
  <cls-basic @dispatch-basic-msg="updateInfo">
  </cls-basic>
  <group>
    <ceil title="班级人数" :inline-desc="stepSecondForm.clssize + '人'" primary="content">
      <range :value.sync="stepSecondForm.clssize" :min="10" :max="110" min-html="minhtml...."
             max-html="maxhtml..." slot="value"></range>
    </ceil>
  </group>

  <group title="（不含老师，班上所有学生人数）">
    <x-input :value.sync="stepSecondForm.headmaster" title="班主任姓名" type="text" is-type="china-name" :min="2" :max="5"
             placeholder="请输入班主任的姓名"></x-input>
  </group>
  <divider>我是有底线的</divider>

  <transparent-disabled :mask-stat.sync="isSet"></transparent-disabled>

</template>
<script>
  import Group from 'vux/src/components/group'
  import Range from 'vux/src/components/range'
  import XInput from 'vux/src/components/x-input'
  import Ceil from 'vux/src/components/cell'
  import Divider from 'vux/src/components/divider'
  import SchoolJSON from './school.json'
  import TransparentDisabled from './transparentDisabled.vue'
  import ClsBasic from '../common/ClsBasicMsg.vue'

  export default {
    components: {Group, Range, XInput, Ceil, Divider, TransparentDisabled, ClsBasic},
    ready () {
      this.getAlreadyData()
    },
    methods: {
      updateInfo (msg) { // 子组件传值
        this.stepSecondForm.school = msg.schoolInfo[1] || ''
        this.stepSecondForm.class = msg.classInfo[0] || ''
        this.stepSecondForm.grade = msg.gradeInfo
      },
      getAlreadyData () {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=secondStepList')
          .then(response => {
            const resData = response.body
            if (resData.headmaster.length !== 0) {
              this.isSet = true
              // 更新子组件的文字
              this.$broadcast('transfer-to-child', resData)
              /*this.stepSecondForm.grade = resData.grade
              this.classInfo = [resData.class]
              this.schoolInfo = [resData.school]*/
              this.stepSecondForm.clssize = parseInt(resData.clssize)
              this.stepSecondForm.headmaster = resData.headmaster
            }
          })
      }
    },
    data () {
      return {
        isSet: false,
        stepSecondForm: {grade: '', class: '', school: '', clssize: 0, headmaster: ''}
      }
    },
    watch: {
      'stepSecondForm': {
        handler (val) {
          this.$dispatch('step-form-data', val)
//          console.log(val)
        },
        deep: true
      }
    }
  }
</script>
<style scoped>
  .white-mask {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 168px;
    left: 0;
    background: transparent;
    z-index: 999;
  }
</style>
