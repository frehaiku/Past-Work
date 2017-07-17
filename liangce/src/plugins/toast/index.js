import toastComponents from '../../components/toast'

let $vm
const plugins = {
  install (vue, options) {
    let Toast = vue.extend(toastComponents)

    if (!$vm) {
      $vm = new Toast({
        el: document.createElement('div'),
        propsData: options
      })

      document.body.appendChild($vm.$el)
    }

    const toast = {
      show (message) {
        $vm.show(message)
      }
    }

    if (!vue.$plugins) {
      vue.$plugins.toast = {toast}
    } else {
      vue.$plugins.toast = toast
    }

    vue.mixins({
      created () {
        this.$plugins = vue.$plugins;
      }
    })
  }
}

// export default plugins
export const toast = plugins