import Vue from 'vue'
import VueResource from 'vue-resource'
Vue.use(VueResource)
Vue.http.options.emulateJSON = true

let hashReduce = window.location.href.split('#')

var shareClass = function (setting) {
  var uri = hashReduce[0] + '?#' + hashReduce[1]
  Vue.http.get('http://huizhou.us/so/index.php?m=Index&a=jsticket&url=' + encodeURIComponent("http://huizhou.us/best-class/index.html"))
    .then(response => {
      var data = response.body
      wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: data.appId, // 必填，公众号的唯一标识
        timestamp: data.timestamp, // 必填，生成签名的时间戳
        nonceStr: data.nonceStr, // 必填，生成签名的随机串
        signature: data.signature, // 必填，签名，见附录1
        jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
      })
      wx.ready(function () {
        wx.onMenuShareTimeline({
          title: setting.title, // 分享标题
          desc: setting.desc, // 分享描述
          link: setting.link, // 分享链接
          imgUrl: setting.imgUrl, // 分享图标
          success: function () {
            // 用户确认分享后执行的回调函数
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
          }
        })
        wx.onMenuShareAppMessage({
          title: setting.title, // 分享标题
          desc: setting.desc, // 分享描述
          link: setting.link, // 分享链接
          imgUrl: setting.imgUrl, // 分享图标
          type: '', // 分享类型,music、video或link，不填默认为link
          dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
          success: function () {
            // 用户确认分享后执行的回调函数
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
          }
        })
        wx.onMenuShareQQ({
          title: setting.title, // 分享标题
          desc: setting.desc, // 分享描述
          link: setting.link, // 分享链接
          imgUrl: setting.imgUrl, // 分享图标
          success: function () {
            // 用户确认分享后执行的回调函数
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
          }
        })
        wx.onMenuShareWeibo({
          title: setting.title, // 分享标题
          desc: setting.desc, // 分享描述
          link: setting.link, // 分享链接
          imgUrl: setting.imgUrl, // 分享图标
          success: function () {
            // 用户确认分享后执行的回调函数
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
          }
        })
        wx.onMenuShareQZone({
          title: setting.title, // 分享标题
          desc: setting.desc, // 分享描述
          link: setting.link, // 分享链接
          imgUrl: setting.imgUrl, // 分享图标
          success: function () {
            // 用户确认分享后执行的回调函数
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
          }
        })
      })
    })
}
export default shareClass
