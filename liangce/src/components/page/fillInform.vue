<style scoped lang="less">

  @import "~cssPath/custom";

  .tips {
    text-align: center;
    height: .55rem;
    font-size: .22rem;
    color: @fontBrown;
    padding: 1.63rem 0;
  }

</style>
<template>
  <div class="outer">
    <step :stepOrder="nonceStep">
      <p>第{{nonceStep}}步：填写贷款人申请人信息({{nonceStep}}/{{maxStep}})</p>

    </step>
    <div class="wrap">
      <form-tpl :datas="formTplData"
                @onRadioChange="nowLiveSync"
                @onInputChange="nowLiveSync"
                @onPaAddressChange="nowLiveSync"
      ></form-tpl>
    </div>
    <input @click="nextStep" class="nextStep" type="button" value="下一步">
    <router-link v-show="nonceStep > 1" :to="prevRouter" class="db blue mgt10 tac">返回上一步</router-link>
    <p class="tips">
      温馨提示：请确保您提供的资料真实、有效
      <br/>
      如果资料存在真实性问题，可能会导致货款不成功。
    </p>
  </div>


</template>

<script>
  import xCeil from '../x-ceil'
  import xInput from '../x-input'
  import {checker, checkerItem} from '../checker'
  import xSelect from '../x-select'
  import xRadio from '../x-radio'
  import step from '../step'
  import formTpl from '../x-form/abstractTpl.vue'

  import {mapGetters} from 'vuex'

  import scrollTop from '../../mixins/scrollTop'

  import {extend} from '../../libs/extend'
  export default {
    components: {
      xInput,
      xSelect,
      checker,
      checkerItem,
      xRadio,
      xCeil,
      step,
      formTpl
    },
    mixins: [scrollTop],
    computed: {
      ...mapGetters([
        'appliantMsg',
        'maxStep',
        'formData'
      ]),
      prevRouter () {
        return {
          name: 'fillInform',
          params: Object.assign(
            {},
            this.router,
            {step: this.nonceStep - 1}
          )
        }
      }
    },
    created () {
      try {
        this.formTplData = JSON.parse(JSON.stringify(this.appliantMsg
            [this.router.group]
            [this.router.role]
            [this.nonceStep - 1] ||
          this.formData[`step${this.nonceStep}`]))
      } catch (e) {
        this.formTplData = JSON.parse(JSON.stringify(this.formData[`step${this.nonceStep}`]))
      }
      // 对象深复制，保存初始无值状态
      this.formDataDeep = JSON.parse(JSON.stringify(this.formData))
      console.log(this.formDataDeep)
    },
    watch: {
      '$route.params.step': function (val) {
        this.$store.commit('SHOW_LOADING')

        this.nonceStep = +val
        this.router = Object.assign({}, this.router, {step: +val})

        this.formData = JSON.parse(JSON.stringify(this.formDataDeep))
        console.dir(this.formData)
        this.formTplData = JSON.parse(JSON.stringify(this.appliantMsg
            [this.router.group]
            [this.router.role]
            [this.nonceStep - 1] ||
          this.formData[`step${this.nonceStep}`]))

        this.$store.commit('HIDE_LOADING')
      }
    },
    data () {
      return {
        router: this.$route.params,
        nonceStep: +(this.$route.params.step),
        formValid: false,
        formTplData: [],
        formDataDeep: {},
        isSync: false
      }
    },
    methods: {
      getStep3WorkAddress () {
        // 最后一步时
        if (this.nonceStep == this.maxStep) {
          const key = '工作单位地址'
          let step3 = this.appliantMsg
            [this.router.group]
            [this.router.role][2]

          return step3.filter(ele =>
          ele.label == key || ele.remark == key)
        }
      },
      // 通讯地址与现居住地址相同时的关联
      nowLiveSync (inputVal, radioValue) {
        let radioVal = radioValue || inputVal,
          formTplData = this.formTplData
            .concat( this.getStep3WorkAddress() )
        const one = (radioVal == '通讯地址与现居住地址相同') ? '现居住址' : '工作单位地址',
          other = '通讯地址'

        formTplData.forEach((ele, ind) => {
          let l = ele.label || ele.remark,
            p = ele.placeholder

          // 找到通讯地址
          if (l == other && ele.formType != 'radio') {
            // 匹配的现居住址
            let otherArr = formTplData.filter(ele =>
            (ele.remark == one ||
            ele.label == one) &&
            ele.placeholder == p)

            formTplData[ind].value = otherArr[0].value
          }
        })
      },
      nextStep () {
        this.formValid = true

        this.$store.commit(
          'SAVE_FORM',
          {data: JSON.parse(JSON.stringify(this.formTplData)), ...this.router}
        )

        if (this.formValid && this.nonceStep != this.maxStep) this.scrollTop()
//        alert({data: JSON.parse(JSON.stringify(this.formTplData)), ...this.router})
        let params = Object.assign({}, this.router, {step: ++this.nonceStep})
//                console.log(this.$refs)
//                this.$plugins.toast.show('good job')
        // 恢复默认值
        console.log(this.formDataDeep)
        this.formData = JSON.parse(JSON.stringify(this.formDataDeep))

        if (this.nonceStep <= this.maxStep) {
          this.$router.push({name: 'fillInform', params})
        } else {
          this.$router.push({name: 'uploadList'})
        }
      }
    }
  }
</script>