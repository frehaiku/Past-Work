<template>
  <divider>该步骤为选填，可修改</divider>

  <group title="班级口号">
    <ceil>
      <x-textarea :max="50" :value.sync="stepThirdForm.slogan"></x-textarea>
    </ceil>
  </group>

  <group title="班歌名称">
    <ceil>
      <x-textarea :max="20" :rows="1" :value.sync="stepThirdForm.clssong"></x-textarea>
    </ceil>
  </group>

<!--  <group title="班级简介">
    <ceil>
      <x-textarea :max="500" :value.sync="stepThirdForm.clsintrod"></x-textarea>
    </ceil>-->
  </group>

</template>
<script>
  import Group from 'vux/src/components/group'
  import Ceil from 'vux/src/components/cell'
  import XTextarea from 'vux/src/components/x-textarea'
  import Divider from 'vux/src/components/divider'
  export default {
    components: {Group, Ceil, XTextarea, Divider},
    data () {
      return {
        stepThirdForm: {
          slogan: '',
          clssong: '',
          clsintrod: ''
        }
      }
    },
    ready () {
      this.getAlreadyData()
    },
    methods: {
      getAlreadyData () {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=thirdStepList')
          .then((response) => {
            const resData = response.body
            resData.slogan != null ? this.stepThirdForm.slogan = resData.slogan : ''
            resData.slogan != null ? this.stepThirdForm.clssong = resData.clssong : ''
            resData.slogan != null ? this.stepThirdForm.clsintrod = resData.clsintrod : ''
          })
      }
    },
    watch: {
      'stepThirdForm': {
        handler (val) {
          this.$dispatch('step-form-data', val)
        },
        deep: true
      }
    }
  }
</script>
