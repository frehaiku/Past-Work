<template>
  <div id="wrap">
    <step stepOrder='0'>
      <p>第五步：上传资料</p>
    </step>
    <div class="bgWhite">
      <ul>
        <!--遍历state中的upload项-->
        <router-link :to="combineRouter(uploadItem)" tag="li"
                     :class="{active: isUpload(uploadItem)}"
                     v-for="(uploadItem, index) in uploadList"
                     :key="uploadItem">{{uploadItem}}
          <i></i>
        </router-link>
      </ul>
    </div>
    <p class="tac tips" v-show="remain != 0">您有{{remain}}份资料待上传！</p>
    <p class="tac tips" v-show="remain == 0">上传完毕！</p>
    <p class="tac check">
      <label>
        <input type="checkbox" class="dn" v-model="checkboxValid">
        <i></i>
        本人确保提供的所有资料均真实、有效
      </label>

    </p>
    <div class="btnContent">

      <router-link :to="jointParam">
        <input type="button" name="" id="" value="增加共同申请人"/>
      </router-link>

      <router-link :to="suretyParam">
        <input class="fr" type="button" name="" id="" value="增加担保人"/>
      </router-link>

    </div>
    <input class="nextStep" type="button" value="提交"
           :disabled="!checkboxValid"
           @click='pop=!pop'>
    <div class="pop" v-show="pop">
      <div class="content">
        <img src="~imgPath/delete.png" @click.stop="pop=!pop" class="close"/>
        <p>
          提交信息后，如需修改信息，<br/> 请致电客服热线400-099-1818，
          <br/> 是否确认提交贷款信息？
        </p>
        <input @click.stop="submitOperation" type="button" name="" class="nextStep" value="确认提交"/>
        <span class="blue" @click.stop="pop=!pop">我再核对一下</span>
      </div>
    </div>
  </div>
</template>

<script>
  import step from '../step/index.vue'
  import {mapState, mapGetters} from 'vuex'
  import {fetchAPI} from '../../libs/fetch'
  import {extend} from '../../libs/extend'

  import ChinaAddressV3Data from '../../datas/china_address_v3.json'
  import value2name from '../../filters/value2name'
  export default {
    data () {
      return {
        check: true,
        pop: false,
        // 默认复选框打钩
        checkboxValid: true
      }
    },
    mounted () {
      this.$store.commit('SAVE_TEMP_ROUTER', {data: this.nonceRouter})
    },
    computed: {
      ...mapGetters([
        'appliantMsg',
        'uploadList',
        'roleGroups',
        'maxStep',
        'activeDatum'
      ]),
      ...mapState({
        'isModifyRole': state => state.modify.isModifyRole,
        'modifyOrderParams': state => state.modify.modifyOrderParams,
      }),
      jointParam () {
        return {
          name: 'commonApply',
          params: Object.assign({}, this.nonceRouter, {group: '按揭共同申请人信息'})
        }
      },
      suretyParam () {
        return {
          name: 'commonApply',
          params: Object.assign({}, this.nonceRouter, {group: '按揭担保人信息'})
        }
      },
      nonceRouter () {
        return this.$route.params
      },
      remain () {

        if (!this.rolePic) {
          return this.uploadList.length
        } else {
          return this.uploadList.length - this.rolePic.length
        }
      },
      rolePic () {
        return this.appliantMsg[this.nonceRouter.group]
            [this.nonceRouter.role]
            [this.maxStep] || []
      }
    },
    created () {
      this.$store.commit('UPDATE_UNTREATED', 1)
    },
    methods: {
      isUpload (item) {
        return this.rolePic.filter(ele => ele.label == item).length == 0
      },
      getName (value) {
        return value2name(value, ChinaAddressV3Data)
      },
      combineRouter (item) {
        return {
          name: 'uploadImg',
          params: {...(this.$route.params), item}
        }
      },
      trimAll (str) {
        return str.replace(/\s+/g, '')
      },
      parseJSON () {
        let total = {}, groupCurr, roleCurr
        // roleGroup，如按揭共同申请人信息等
        for (const group in this.appliantMsg) {
          groupCurr = this.appliantMsg[group]

          // 非申请人时json是个数组
          total[group] = Object.keys(groupCurr).indexOf('self') ? [] : {}
          console.log(group)
          // 多角色，如子女0，子女1
          for (const role in groupCurr) {
            roleCurr = groupCurr[role]

            let roleObj = {}
            // 非申请人时json是个数组
            if (role !== 'self') {
              roleObj["与主贷款人关系"] = role.replace(/\d+/g, '')
            }
            // 每一步骤的数组
            roleCurr.forEach(ele => {
              // 每一步骤具体项
              ele.forEach(item => {
                item.placeholder && (item.placeholder = this.trimAll(item.placeholder))
                // 省市区
                if (item.split == '/') {
                  let label = item.label || item.remark,
                    placeholders = item.placeholder.split('/'),
                    // 日期的分隔符为-
                    valueDivide = (item.formType == "calendar") ? '-' : ' ',
                    values = this.getName(item.value).split(valueDivide)

                  placeholders.forEach((p, ind) => {
                    roleObj[label + '_' + p] = (ind + 1 > values.length) ? values[values.length - 1] : values[ind]
                  })
                } else if (item.split == 'wipe/') {
                  // 街路巷
                  let placeholders = item.placeholder.replace(/\/+/g, '')
                  roleObj[item.remark + '_' + placeholders] = item.value
                } else if (item.type == 'uploadPic') {
                  // 图片上传
                  let parentPic = group.replace(/信息/, '') + item.label
                  roleObj[parentPic] = {}
                  // 去除为空的路径，并用,分隔
                  roleObj[parentPic][item.label.split('（')[0]] = item.value.filter(ele => ele != '').join(",")
                } else {
                  roleObj[item.label || `${item.remark}_${item.placeholder}`] = item.value
                }
              })
            })
            if (role !== 'self') {
              total[group].push(roleObj)
            } else {
              total[group] = roleObj
            }
          }
        }
        console.dir(total)
        return total
      },
      submitOperation () {
        if (this.isModifyRole) {
          this.modify()
        } else {
          this.submit()
        }
      },
      // 最终请求提交
      submit() {
        this.$interfaces.apply(this, {
          productId: this.$route.params.product,
          data: {"按揭详细信息": this.parseJSON()}
        })
                .then(response => {
                this.pop = !this.pop
                if (response.code == 50000) {
                  this.$router.push({path: '/submitSuccess'})
                  this.$store.commit('GATHER_EMPTY')
                }
      })
        /*fetchAPI(this, this.$config.interfaceV1 + 'apply', 'POST',
                {
                  productId: this.$route.params.product,
                  data: {"按揭详细信息": this.parseJSON()}
                })*/

      },
      // 修改时添加申请人信息
      modify () {
        let update = extend(true, {}, this.activeDatum),
          addData = this.parseJSON()

        for (let role in addData) {
          if (Object.keys(addData[role]).length != 0) {
            // 不存在该角色时，将其默认值设置为数组
            update[role] || (update[role] = [])
            update[role] = update[role].concat(addData[role])
          }
        }

        this.$store.dispatch({
          type: 'fetchModifyOrder',
          vm: this,
          data: {'按揭详细信息': update},
          item: update
        }).then(() => {
          this.$store.commit('GATHER_EMPTY')
        }).then(() => {
            this.$router.push({
              name: 'applyInform',
              params: {
                orderId: this.modifyOrderParams.sn,
                ...this.modifyOrderParams
              }
            })
          }
        )


      }
    },
    components: {
      step
    }
  }
</script>

<style scoped lang="less">
  @import "~cssPath/custom";

  #wrap {
    padding-bottom: 1rem;
  }

  .bgWhite {
    padding: 0 0.2rem;

  ul {

  li {
    list-style: decimal inside;
    padding: 0.3rem;
    font-size: 0.26rem;
    color: @fontBlack;
    border-bottom: 1px solid #f4f4f4;

  i {
    float: right;
    width: 0.14rem;
    height: 0.26rem;
    background: url(~imgPath/rightArrow.png);
    background-size: 100% 100%;
  }

  }
  .active {
    color: #ff6d5e;
  }

  }
  }

  .tips {
    color: @fontBlue;
    line-height: 0.7rem;
  }

  .check {
    color: #522727;
    margin: .2rem 0;

  i {
    display: inline-block;
    width: 0.28rem;
    height: 0.28rem;
    border-radius: 0.05rem;
    vertical-align: middle;
    position: relative;
    top: -2px;
  }

  input[type=checkbox]:checked + i {
    background: url(~imgPath/pick.png);
    background-size: 100% 100%;
  }

  input[type=checkbox] + i {
    background: url(~imgPath/unpick.png);
    background-size: 100% 100%;
  }

  }

  .btnContent {
    margin: 0.2rem;

  input {
    background: @fontYellow;
    border: none;
    outline: none;
    height: 0.66rem;
    width: 3.4rem;
    color: white;
    border-radius: 0.1rem;
  }

  }

  .pop {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .5);
    left: 0;
    top: 0;

  .content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 1px solid @fontBlack;
    width: 5.34rem;
    background: white;
    text-align: center;
    padding: 0.5rem 0;
    line-height: 0.56rem;
    border-radius: 0.2rem;

  .nextStep {
    width: 2.4rem;
  }

  }
  .close {
    position: absolute;
    right: -0.7rem;
    top: -0.7rem;
    width: 0.58rem;
    height: 0.58rem;
  }

  }
</style>