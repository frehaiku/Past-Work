/**
 * Created by frehaiku on 2017/5/31.
 */
export const fetchAPI = function (vm, url, method, body) {
  vm.$store.commit('SHOW_LOADING')
  let bodys = {
    phone: vm.$store.state.applicant.userPhone || '13600136007',
    ...body
  }
  return fetch(url, {body: JSON.stringify(bodys), ...{method}})
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