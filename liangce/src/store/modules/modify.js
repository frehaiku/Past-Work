/**
 * Created by frehaiku on 2017/6/8.
 */
let state = {
  // applyInformItem页面当前点击的数据
  activeDatum: {},
  activeRole: '按揭申请人信息0',
  // 修改信息请求接口部分参数
  modifyOrderParams: {productId: 0, sn: 0},
  isUntreated: false,
  // 是否修改时增加共同申请人
  isModifyRole: false,
  // 进入增加角色前的history的length属性
  // applyInform提交成功返回，history.go(currentLength - initLength)
  addRoleInitHistoryLen: 0
}

let getters = {
  activeDatum (state) {
    return state.activeDatum
  },
  activeRole (state) {
    return state.activeRole
  },
  roleFont ({activeRole}) {
    return activeRole.replace(/(\d+)/g, '')
  },
  roleNum ({activeRole}) {
    return +activeRole.match(/(\d+)$/)[1]
  }
}

let mutations = {
  EMPTY_DATUM (state) {
    state.activeDatum = {}
  },
  MODIFY_DATUM (state, {data}) {
    state.activeDatum = {...state['activeDatum'], ...data}
  },

  MODIFY_ROLE (state, {data}) {
    state.activeRole = data
  },
  UPDATE_PRODUCTID (state, {data}) {
    state.productId = data
  },
  UPDATE_MODIFY_ORDER_PARAMS (state, {data}) {
    state.modifyOrderParams = {...state.modifyOrderParams, ...data}
  },
  UPDATE_UNTREATED (state, status) {
    state.isUntreated = status
  },
  IS_MODIFY_ADD_ROLE (state) {
    state.isModifyRole = true
  },
  NONE_MODIFY_ADD_ROLE (state) {
    state.isModifyRole = false
  },
  UPDATE_HISTORY_LENGTH (state, {length}) {
    state.addRoleInitHistoryLen = length
  }
}

let actions = {
  // 调用修改接口后，修改Vuex的状态
  fetchModifyOrder ({commit, state}, {vm, ...args}) {
    vm.$interfaces.modifyOrder(vm,{
      ...args,
      ...state.modifyOrderParams
    })
      .then(r => commit('MODIFY_DATUM', {data: args.item}))
  }
}
export default {
  state,
  getters,
  mutations,
  actions
}