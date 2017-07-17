/**
 * Created by frehaiku on 2017/5/23.
 */
let formData = {
  step1: [
    {
      formType: 'input',
      label: '贷款人姓名',
      placeholder: '必填'
    },
    {
      formType: 'input',
      label: '贷款人手机号',
      placeholder: '必填'
    },
    {
      formType: 'address',
      label: '成交物业地址',
      placeholder: '省 / 市 / 县(区)',
      value: ['440000', '440100', '440106'],
      split: '/'
    },
    /*{
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '街 / 路 / 巷',
      split: 'wipe/'
    },*/
    {
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '街',
    },
    {
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '路',
    },
    {
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '巷',
    },
    {
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '栋'
    },
    {
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '房号'
    },
    {
      formType: 'input',
      label: '',
      remark: '成交物业地址',
      placeholder: '小区名称'
    },
    {
      formType: 'input',
      label: '成交价',
      placeholder: '必填',
      units: '万元'
    },
    {
      formType: 'input',
      label: '计划贷款金额',
      placeholder: '必填',
      units: '万元'
    },
    {
      formType: 'input',
      label: '计划贷款期限',
      placeholder: '必填',
      units: '月'
    },
    {
      formType: 'input',
      label: '房产证号',
      placeholder: '必填',
      units: ''
    },
    {
      formType: 'input',
      label: '房产证持有人数量',
      placeholder: '必填',
      units: '人'
    }
  ],
  step2: [
    {
      formType: 'select',
      label: '证件类型',
      placeholder: '必填',
      units: '',
      options: ['身份证', '护照', '军官证', '港澳台身份证', '其它']
    },
    {
      formType: 'input',
      label: '证件号码',
      placeholder: '必填'
    },
    {
      formType: 'radio',
      label: '性别',
      options: ['男', '女']
    },
    {
      formType: 'calendar',
      label: '出生年月',
      placeholder: '年 / 月 / 日',
      // split: '/'
    },
    {
      formType: 'select',
      label: '户口性质',
      placeholder: '请选择',
      options: ['本市长住户口', '非本地户口但居住本地三年', '非本地户口但居住本地满三年以下']
    },
    {
      formType: 'address',
      label: '户口所在地',
      placeholder: '省 / 市 / 县(区)',
      value: ['440000', '440100', '440106'],
      split: '/'
    },
    {
      formType: 'checker',
      label: '婚姻情况',
      options: [
        {name: '已婚有子女', isDisabled: false},
        {name: '已婚无子女', isDisabled: false},
        {name: '未婚', isDisabled: false},
        {name: '离异', isDisabled: false},
        {name: '丧偶', isDisabled: false},
      ]
    },
    {
      formType: 'checker',
      label: '文化程度',
      options: [
        {name: '大专', isDisabled: false},
        {name: '本科', isDisabled: false},
        {name: '研究生及以上', isDisabled: false}
      ]
    },
    {
      formType: 'checker',
      label: '月均收入',
      options: [
        {name: '40000元以上', isDisabled: false},
        {name: '20000-39999元', isDisabled: false},
        {name: '10000-19999元', isDisabled: false},
        {name: '5000-9999元', isDisabled: false},
        {name: '5000元以下', isDisabled: false}
      ]
    },
    {
      formType: 'checker',
      label: '月家庭综合收入',
      options: [
        {name: '80000元以上', isDisabled: false},
        {name: '50000-79999元', isDisabled: false},
        {name: '20000-49999元', isDisabled: false},
        {name: '20000元以下', isDisabled: false}
      ]
    }
  ],
  step3: [
    {
      formType: 'input',
      label: '工作单位全称',
      placeholder: '必填'
    },
    {
      formType: 'address',
      label: '工作单位地址',
      placeholder: '省 / 市 / 县(区)',
      value: ['440000', '440100', '440106'],
      split: '/'
    },
    /*{
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '街 / 路 / 巷',
      split: 'wipe/'
    },*/
    {
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '街',
    },
    {
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '路',
    },
    {
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '巷',
    },
    {
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '栋',
    },
    {
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '房号',
    },
    {
      formType: 'input',
      label: '',
      remark: '工作单位地址',
      placeholder: '小区名称'
    },
    {
      formType: 'select',
      label: '单位性质',
      placeholder: '请选择',
      options: ['事业', '国有', '集体', '股份制', '合资', '独资', '私营', '个体', '其他']
    },
    {
      formType: 'select',
      label: '行业',
      placeholder: '请选择',
      options: ['服务业', '教育', '批发和零售业', '计算机服务', '制造业', '金融业', '建筑业', '交通运输业', '住宿和餐饮业', '其他']
    },
    {
      formType: 'select',
      label: '职业',
      placeholder: '请选择',
      options: ['医生', '律师','教师', '会计师', '经济师', '工程师', '公务员', '其他']
    },
    {
      formType: 'checker',
      label: '所在企业人数',
      options: [
        {name: '50人以内', isDisabled: false},
        {name: '50-99人', isDisabled: false},
        {name: '100-499人', isDisabled: false},
        {name: '500人以上', isDisabled: false},
      ]
    },
    {
      formType: 'checker',
      label: '职务',
      options: [
        {name: '普通员工', isDisabled: false},
        {name: '一般管理', isDisabled: false},
        {name: '高级管理', isDisabled: false},
      ]
    },
    {
      formType: 'checker',
      label: '职称',
      options: [
        {name: '无', isDisabled: false},
        {name: '初级职称', isDisabled: false},
        {name: '中级职称', isDisabled: false},
        {name: '高级职称', isDisabled: false},
        {name: '国家认可的专业注册资格', isDisabled: false},
      ]
    }
  ],
  step4: [
    {
      formType: 'input',
      label: '电子邮箱',
      placeholder: '选填'
    },
    {
      formType: 'select',
      label: '现住房性质',
      placeholder: '请选择',
      options: ['自购房有抵押', '自购房无抵押', '与父母同住', '租用及其他']
    },
    {
      formType: 'address',
      label: '现居住址',
      placeholder: '省 / 市 / 县(区)',
      value: ['440000', '440100', '440106'],
      split: '/'
    },
    /*{
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '街 / 路 / 巷',
      split: 'wipe/'
    },*/
    {
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '街',
    },
    {
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '路',
    },
    {
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '巷',
    },
    {
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '栋',
    },
    {
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '房号',
    },
    {
      formType: 'input',
      label: '',
      remark: '现居住址',
      placeholder: '小区名称'
    },
    {
      formType: 'radio',
      label: '通讯地址',
      options: ['通讯地址与现居住地址相同', '通讯地址与工作单位地址相同'],
      unCheckedClass: 'x-radio-alignright-default',
      checkedClass: 'x-radio-alignright-checked',
      labelClass: 'label-alignright'
    },
    {
      formType: 'address',
      label: '',
      remark: '通讯地址',
      placeholder: '省 / 市 / 县(区)',
      value: ['440000', '440100', '440106'],
      split: '/'
    },
    /*{
      formType: 'input',
      label: '',
      placeholder: '街 / 路 / 巷',
      remark: '通讯地址',
      split: 'wipe/'
    },*/
    {
      formType: 'input',
      label: '',
      remark: '通讯地址',
      placeholder: '街',
    },
    {
      formType: 'input',
      label: '',
      remark: '通讯地址',
      placeholder: '路',
    },
    {
      formType: 'input',
      label: '',
      remark: '通讯地址',
      placeholder: '巷',
    },
    {
      formType: 'input',
      label: '',
      remark: '通讯地址',
      placeholder: '栋',
    },
    {
      formType: 'input',
      label: '',
      remark: '通讯地址',
      placeholder: '房号',
    },
    {
      formType: 'input',
      label: '',
      remark: '通讯地址',
      placeholder: '小区名称'
    },
    {
      formType: 'input',
      label: '通讯地址邮编',
      placeholder: '必填'
    },
  ]
}

import {extend} from '../../libs/extend'
const gatherOrigin = {
  '按揭申请人信息': {
    'self': []
  }
}

let state = {
  // 此选项会影响SAVE_UPLOAD的执行
  maxStep: 4,
  // 角色
  roleGroups: ['按揭申请人信息', '按揭共同申请人信息', '按揭担保人信息'],
  // 默认角色为self 夫妻,子女,父母,非直系亲属
  roles: ['self', '夫妻', '子女', '父母', '非直系亲属'],
  uploadList: [
    '身份证（夫妻二人）',
    '户口簿（夫妻二人）',
    '婚况',
    '收入证明（盖单位公章）',
    '银行流水',
    '外地人社保（社保证明/税单）',
    '业主房产证（全部页）',
    '房产交易资料（三方约/两方约）',
    '征信授权书',
    '初评报告',
    '网签资料',
    '其他补充资料'],
  // 暂时存储
  gather: extend(true, {}, gatherOrigin),
  // queryField接口的数据接口结果缓存
  queryField: {},
  formData,
  tempRouter: {},
  // 请求接口时的参数
  userPhone: ''
}

// 处理roles与formData的层级关系
for (let value in formData) {
  if (/step/.test(value)) {
    formData[value].map((ele, ind) => {
      let vary;
      if (ele.formType == 'select') vary = ele.options[0]
      else vary = ('value' in ele ? ele.value : '')

      formData[value][ind] = Object.assign({}, ele, {value: vary})
    })
  }

}
/*
 state.roles.forEach(role => cp[role] = formData)
 state.roleGroups.forEach(group => state.gather[group] = cp)*/

let getters = {
  appliantMsg (state) {
    return state.gather
  },
  maxStep (state) {
    return state.maxStep
  },
  roles (state) {
    return state.roles
  },
  roleGroups ({roleGroups}) {
    return roleGroups
  },
  formData (state) {
    return state.formData
  },
  uploadList (state) {
    return state.uploadList
  },
  tempRouter (state) {
    return state.tempRouter
  }
}

let mutations = {
  SAVE_TEMP_ROUTER (state, {data}) {
    state.tempRouter = data
  },
  SAVE_UPLOAD (state, {data, previews, group, role, item}) {
    const gather = state.gather,
      maxStep = state.maxStep

    let nonce = gather[group][role][maxStep],
      gatherCopy = JSON.parse(JSON.stringify(gather)),
      repeatInd = -1

    // 未上传过照片
    if (!nonce) {
      gatherCopy[group][role][maxStep] = []
      console.log(gather)
      state.gather = Object.assign({}, gather, gatherCopy)
      // gather改变了，重新取nonce
      nonce = state.gather[group][role][maxStep]
    }
    // 查找上传过的index
    nonce.some((ele, ind) => {
      if (ele.label == item) {
        repeatInd = ind
        return true
      }
    })

    nonce.splice(
      (repeatInd == -1 ? nonce.length : repeatInd),
      (repeatInd == -1 ? 0 : 1),
      {type: 'uploadPic', label: item, value: data, previews: previews})
  },
  // 子女1 子女2 子女3
  SAVE_FORM ({gather}, {data, group, role, step}) {
    const nonceStep = 'step' + step

    // 存在group
    if (gather.hasOwnProperty(group)) {
      if (!gather[group].hasOwnProperty(role)) {
        gather[group][role] = []
      }
      gather[group][role].splice(step - 1, 1, data)
    } else {
      gather[group] = {}
      gather[group][role] = []
      gather[group][role].splice(step - 1, 1, data)
    }
  },
  // 根据路由参数改变role
  REVISION_ROLE (state, {role}) {
    state.nonceRole = role
  },
  SAVE_QUERY_FIELD (state, {field}) {
    state.queryField = field
  },
  SAVE_TPL (state, {tpl}) {
    state.formTpl = tpl
  },
  // 添加成功时，还原到初始状态。避免修改时影响增加共同申请人的操作
  GATHER_EMPTY (state) {
    state.gather = extend(true, {}, gatherOrigin)
  },
  SAVE_PHONE (state, {phone}) {
    state.userPhone = phone
  }
}

export default {
  state,
  mutations,
  getters
}
