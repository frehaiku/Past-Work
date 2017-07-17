/**
 * Created by frehaiku on 2017/5/31.
 */
const isObject = function (params) {
  return params && ({}).toString.call(params) === '[object Object]'
}
export const fetchAPI = function (vm, url, method, body) {
  vm.$store.commit('SHOW_LOADING')
  // debugger
  // 不传参数时当Object处理
  let bodys =
    !body || isObject(body) ?
      JSON.stringify({
        phone: vm.$store.state.applicant.userPhone || '13600136007',
        ...body
      })
      : body
  return fetch(url, {body: bodys, ...{method}})
    .then(response => {
      vm.$store.commit('HIDE_LOADING')
      return response.json()
    })
    .then(response => {
      if (response.code == 50000) return response
      else alert(response.msg)
    })
    .catch(e => console.error(e) && $store.commit('HIDE_LOADING'))
}