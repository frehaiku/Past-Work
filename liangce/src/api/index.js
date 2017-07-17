/**
 * 写好各种接口的声明
 */
import {fetchAPI} from '../libs/fetch'

const requests = {
  productList: (vm, params) => fetchAPI(vm, `${vm.$config.interfaceV1}list`, 'POST', params), // 获取产品列表

  upload: (vm, params) => fetchAPI(vm, `${vm.$config.interfaceV1}upload`, 'POST', params),  // 上传照片

  apply: (vm, params) => fetchAPI(vm, `${vm.$config.interfaceV1}apply`, 'POST', params),  // 提交申请

  getOrderList: (vm, params) => fetchAPI(vm, `${vm.$config.interfaceV1}getOrderList`, 'POST', params),  // 获取订单状态

  getOrderDetails: (vm, params) => fetchAPI(vm, `${vm.$config.interfaceV1}getOrderDetails`, 'POST', params), // 获取订单状态

  modifyOrder: (vm, params) => fetchAPI(vm, `${vm.$config.interfaceV1}modifyOrder`, 'POST', params) // 修改订单状态(处理中时)
}
// 全局注入，通过this.$interfaces访问接口
export const interfaces = vue => vue.prototype.$interfaces = requests