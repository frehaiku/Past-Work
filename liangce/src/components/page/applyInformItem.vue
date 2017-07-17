<style rel="stylesheet/less" lang="less" scoped="">
  @import "~cssPath/_applyInformList";

  ul.details {
    border-top: 1px solid #ececec;
    padding-top: .3rem;
    li {
      margin-bottom: .3rem;
      font-size: .26rem;
      color: @fontShallowGray;
      overflow: auto;
      .operation {
        float: right;
        color: @fontBlue;
      }
      .right {
        float: right;
        font-size: .25rem;
        color: @fontDeepGray;
        input.edit {
          border: none;
          outline: none;
          text-align: right;
        }
      }
    }
    li:last-of-type {
      margin-bottom: 0;
    }
  }

  .height0 {
    display: none;
  }

  .heightauto {
    display: block;
  }

  .itemUnit {
    vertical-align: top;
    margin-left: 5px;
  }
</style>
<!--3.3申请人资料-->
<template>
  <div class="inform-wrapper">
    <ul class="of">
      <!--图片资料单独列出来路由跳转-->
      <li class="parent-l" @click="$router.push({path: '/showImgList'})">图片资料
        <i class="arrow"></i>
      </li>
      <!--其余三种角色-->
      <li v-for="(informItem, key) in computedInformLis"
          class="parent-l">
        <span class="listHeader db"
              @click="listShow[key] = !listShow[key]"
        >
          {{key}}
        <i class="arrow"></i>
        </span>
        <!--<i class="warn"></i>-->
        <ul class="details of"
            :class="{height0: !listShow[key], heightauto: listShow[key]}"
            style="padding-top:0;">
          <!--只有待处理的订单可以编辑-->
          <li style="margin-top: .3rem;">
            <span class="operation"
                  v-show="isUntreated && editStatus[key]"
                  @click="changeEdit(key)">编辑</span>

            <span class="operation"
                  v-show="isUntreated && !editStatus[key]"
                  @click="changeEdit(key)">保存</span>
          </li>
          <li v-for="item in informItem">
            <label>
              {{item.name}}
              <span class="right">
                <apply-tpl
                  :datas="item"
                  :readonly="editStatus[key]"
                ></apply-tpl>
                <!--单位-->
                <span class="itemUnit"
                      v-show="item.unit"
                      v-text="item.unit"></span>
              </span>
            </label>
          </li>
        </ul>
      </li>
      <!--<li class="parent-l">贷款信息
        <i class="arrow"></i>
        <ul class="details of">
          <li>
            <span class="operation">编辑</span>
            <span class="operation">保存</span>
          </li>
          <li>
            <label>
              贷款人姓名
              <span class="right">
                <input class="edit" type="text" value="小明">
              </span>
            </label>
          </li>
        </ul>
      </li>-->

      <!--      <li class="parent-l">个人资料<i class="arrow"></i></li>
            <li class="parent-l">户籍资料<i class="arrow"></i></li>
            <li class="parent-l">职业信息<i class="arrow"></i></li>-->
    </ul>
  </div>
</template>
<script>
  import {fetchAPI} from '../../libs/fetch'
  import applyTpl from '../x-form/applyInformTpl.vue'

  import {mapState, mapGetters} from 'vuex'
  import {extend} from '../../libs/extend'

  import ChinaAddressV3Data from '../../datas/china_address_v3.json'
  import value2name from '../../filters/value2name'
  export default {
    data () {
      return {
        // tpl模板数据对象
        informLis: {
          '贷款信息': [
            {
              formType: 'input',
              name: '贷款人姓名',
              value: ''
            },
            {
              formType: 'input',
              name: '贷款人手机号',
              value: ''
            },
            {
              formType: 'address',
              name: '成交物业地址',
              concat: ['成交物业地址_省', '成交物业地址_市', '成交物业地址_县(区)'],
              split: ' ',
              value: []
            },
            {
              formType: 'input',
              name: '',
              concat: ['成交物业地址_街'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['成交物业地址_路'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['成交物业地址_巷'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['成交物业地址_栋'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['成交物业地址_房号'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['成交物业地址_小区名称'],
              value: ''
            },
            {
              formType: 'input',
              name: '成交价',
              value: '',
              unit: '万元'
            },
            {
              formType: 'input',
              name: '计划贷款金额',
              value: '',
              unit: '万元'
            },
            {
              formType: 'input',
              name: '计划贷款期限',
              value: '',
              unit: '月'
            },
            {
              formType: 'input',
              name: '房产证号',
              value: ''
            },
            {
              formType: 'input',
              name: '房产证持有人数量',
              value: '',
              unit: '人'
            }
          ],
          '个人资料': [
            {
              name: '证件类型',
              value: '',
              formType: 'select',
              options: ['身份证', '护照', '军官证', '港澳台身份证', '其它']
            },
            {
              formType: 'input',
              name: '证件号码',
              value: ''
            },
            {
              name: '性别',
              value: '',
              formType: 'select',
              options: ['男', '女']
            },
            {
              formType: 'datetime',
              name: '出生年月',
              value: ''
            },
            {
              name: '婚姻情况',
              value: '',
              formType: 'select',
              options: ['已婚有子女', '已婚无子女', '未婚', '离异', '丧偶']
            },
            {
              name: '文化程度',
              value: '',
              formType: 'select',
              options: ['大专', '本科', '研究生及以上']
            },
            {
              name: '月均收入',
              value: '',
              formType: 'select',
              options: ['40000元以上', '20000-39999元', '10000-19999元', '5000-9999元', '5000元以下']
            },
            {
              name: '月家庭综合收入',
              value: '',
              formType: 'select',
              options: ['80000元以上', '50000-79999元', '20000-49999元', '20000元以下']
            },
            {
              formType: 'input',
              name: '电子邮箱',
              value: ''
            },
          ],
          '户籍资料': [
            {
              name: '现住房性质',
              value: '',
              formType: 'select',
              options: ['自购房有抵押', '自购房无抵押', '与父母同住', '租用及其他']
            },
            {
              name: '户口性质',
              value: '',
              formType: 'select',
              options: ['本市长住户口', '非本地户口但居住本地三年', '非本地户口但居住本地满三年以下']
            },
            {
              formType: 'address',
              name: '户口所在地',
              concat: ['户口所在地_省', '户口所在地_市', '户口所在地_县(区)'],
              split: ' ',
              value: []
            },
            {
              formType: 'address',
              name: '现居住址',
              concat: ['现居住址_省', '现居住址_市', '现居住址_县(区)'],
              split: ' ',
              value: []
            },
            {
              formType: 'input',
              name: '',
              concat: ['现居住址_街'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['现居住址_路'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['现居住址_巷'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['现居住址_栋'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['现居住址_房号'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['现居住址_小区名称'],
              value: ''
            },
            {
              formType: 'address',
              name: '通讯地址',
              concat: ['通讯地址_省', '通讯地址_市', '通讯地址_县(区)'],
              split: ' ',
              value: []
            },
            {
              formType: 'input',
              name: '',
              concat: ['通讯地址_街'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['通讯地址_路'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['通讯地址_巷'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['通讯地址_栋'],
              value: ''
            },
            {
              formType: 'input',
              name: '',
              concat: ['通讯地址_房号'],
              value: ''
            },

            {
              formType: 'input',
              name: '',
              concat: ['通讯地址_小区名称'],
              value: ''
            },
            {
              formType: 'input',
              name: '通讯地址邮编',
              value: ''
            }
          ],
          '职业信息': [
            {
              formType: 'input',
              name: '工作单位全称',
              value: ''
            },
            {
              name: '单位性质',
              value: '',
              formType: 'select',
              options: ['事业', '国有', '集体', '股份制', '合资', '独资', '私营', '个体', '其他']
            },
            {
              name: '行业',
              formType: 'select',
              options: ['服务业', '教育', '批发和零售业', '计算机服务', '制造业', '金融业', '建筑业', '交通运输业', '住宿和餐饮业', '其他'],
              value: ''
            },
            {
              name: '所在企业人数',
              value: '',
              formType: 'select',
              options: ['50人以内', '50-99人', '100-499人', '500人以上']
            },
            {
              name: '职业',
              value: '',
              formType: 'select',
              options: ['医生', '律师', '教师', '会计师', '经济师', '工程师', '公务员', '其他']
            },
            {
              name: '职务',
              value: '',
              formType: 'select',
              options: ['普通员工', '一般管理', '高级管理']
            },
            {
              name: '职称',
              value: '',
              formType: 'select',
              options: ['无', '初级职称', '中级职称', '高级职称', '国家认可的专业注册资格']
            }
          ]
        },
        listShow: {
          '贷款信息': 1,
          '个人资料': 1,
          '户籍资料': 1,
          '职业信息': 1,
        },
        // 控制编辑状态
        editStatus: {
          '贷款信息': true,
          '个人资料': true,
          '户籍资料': true,
          '职业信息': true,
        }
      }
    },
    computed: {
      ...mapGetters([
        'activeDatum',
        'activeRole',
        'roleFont',
        'roleNum'
      ]),
      ...mapState({
        'isUntreated': (state) => state.modify.isUntreated
      }),
      activeRoleMsg () {
        return this.activeDatum[`${this.roleFont}信息`][this.roleNum]
      },
      // 表单v-model数据项
      computedInformLis: {
        get () {
          // 根据接口的内容填充对象 为渲染模板提供数据
          let val, informs = extend(true, {}, this.informLis),
            // 当前角色的数据
            storge = this.activeRoleMsg
          // 根据接口返回的数据拼接到this.informs中渲染表单
          for (let attr in informs) {
            val = informs[attr]
            val.forEach((ele, ind) => {
              // 存在concat属性,仅限省市区的情况,将其转换为文字数组
              if (ele.concat) {
                // 根据concat添加值
                ele.concat.forEach((concatItem, innerIdx) =>
                  ele.formType == 'address' ?
                    informs[attr][ind].value.push(storge[concatItem]) :
                    (
                      informs[attr][ind].value +=
                        (innerIdx == 0 ? '' : ' ') + storge[concatItem]
                    )
                )
//                console.log(informs[attr][ind].value)
              }
              // select框不存在值时默认取的第一个值
              else informs[attr][ind].value = ele.formType == 'select' &&
              storge[ele.name] == null ?
                (informs[attr][ind].options[0]) :
                storge[ele.name]
            })
          }
          return informs
        }
      }
    },
    components: {
      applyTpl
    },
    methods: {
      changeEdit (key) {
        this.editStatus[key] = !this.editStatus[key]
        if (!this.editStatus[key]) return
        // 点保存时改变vuex
        let updateObj = {},
          updateActiveDatum = {}

        updateObj[this.roleFont + '信息'] = []
        updateObj[this.roleFont + '信息'][this.roleNum] = this.parseJSON()
        updateActiveDatum = {
          '按揭详细信息': extend(true, {}, this.activeDatum, updateObj)
        }
        console.log(updateActiveDatum)
//        arr[this.roleNum] = this.parseJSON()
        this.editStatus[key] && /*this.$store.commit('MODIFY_DATUM', {
          data: updateObj
        })*/
        this.$store.dispatch({
          type: 'fetchModifyOrder',
          vm: this,
          data: updateActiveDatum,
          item: updateObj
        })
      },
      // 将表单的数据还原回接口的json格式便于保存提交
      parseJSON () {
        let result = {}, msgItem, ths, split
        for (msgItem in this.computedInformLis) {
          ths = this.computedInformLis[msgItem]
          ths.forEach(ele => {
            split = ele.split
            if (ele.formType == 'address') {
              ele.concat.forEach((concatItem, concatIdx) =>
                result[concatItem] =
                  value2name(ele.value, ChinaAddressV3Data).split(' ')[concatIdx]
              )
            }
            else if (!split && ele.concat)
              result[ele.concat[0]] = ele.value
            else
              result[ele.name] = ele.value
          })
        }
        return {...this.activeRoleMsg, ...result}
      }
    }
//    created() {
//      fetchAPI(this,
//        'http://loan.lcfex.com/inf/product/getOrderList?accountName=alex&password=123456',
//        'GET')
//        .then(response => console.log(response))
//    }
  }

</script>