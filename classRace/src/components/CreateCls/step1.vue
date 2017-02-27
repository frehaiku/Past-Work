<template>
  <group title="姓名">
    <x-input :value.sync="formData.fullname" placeholder="输入您的真实姓名" type="text" is-type="china-name"
             :readonly="isSet"></x-input>
  </group>
  <group title="电话">
    <x-input :value.sync="formData.tel" placeholder="输入您的手机号" type="text" is-type="china-mobile" :readonly="isSet"></x-input>
  </group>
  <group title="微信号">
    <x-input :value.sync="formData.wechat" placeholder="工作人员将会联系你" type="text" :readonly="isSet"></x-input>
  </group>
  <group title="班级职务">
    <x-input :value.sync="formData.duties" placeholder="如无可填“无”" type="text" :readonly="isSet"></x-input>
  </group>
  <transparent-disabled :mask-stat.sync="isSet"></transparent-disabled>
</template>
<script>
  import Group from 'vux/src/components/group'
  import xInput from 'vux/src/components/x-input'
  import TransparentDisabled from './transparentDisabled.vue'

  export default {
    components: {Group, xInput, TransparentDisabled},
    ready () {
      this.getAlreadyData()
    },
    data () {
      return {
        isSet: false,
        formData: {
          fullname: '',
          tel: '',
          wechat: '',
          duties: ''
        }
      }
    },
    methods: {
      getAlreadyData () {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=firstStepList')
          .then((response) => {
            const resData = response.body
            if (resData.fullname.length !== 0) {
              this.isSet = true
              this.formData.fullname = resData.fullname
              this.formData.tel = resData.tel
              this.formData.wechat = resData.wechat
              this.formData.duties = resData.duties
            }
          })
      }
    },
    watch: {
      'formData': {
        handler (val) {
          this.$dispatch('step-form-data', val)
        },
        deep: true
      }
    }
  }
</script>

