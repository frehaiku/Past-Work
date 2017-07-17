/**
 * Created by frehaiku on 2017/5/25.
 */

export default {
  methods: {
    scrollTop() {
      let start = null
      console.log('scrollTop binging')
      return (function fn() {
        let initScroll = document.body.scrollTop
          , revision

        if (start == null) {
          start = initScroll
        }
        revision = (initScroll - 20 < 0) ? 0 : initScroll - 20
        if (revision) {
          document.body.scrollTop = revision
          requestAnimationFrame(fn)
        }
      })()

    }
  }
}