<template>
  <span style="color: #666;"
    v-if="!(!day && !hour && !min && !second) || !isEnd">
      {{day}}&nbsp;天&nbsp;{{hour}}&nbsp;时&nbsp;{{min}}&nbsp;分&nbsp;{{second}}&nbsp;秒
  </span>
  <span v-if="!day && !hour && !min && !second || isEnd">已结束</span>
</template>
<script>
  export default {
    data () {
      return {
        day: 0,
        hour: 0,
        min: 0,
        second: 0,
        timer: null,
        isEnd: false
      }
    },
    ready () {
      this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=clsInitData')
        .then((response) => {
        const data = response.body.data
        this.setEnd(data.time)
        this.$dispatch('send-init', data)
      })
    },
    methods: {
      calculateEnd (current) {
        const cha = +new Date(1480262400000) - +new Date(current)
        if (cha < 0) {
          this.isEnd = true
          return false;
        }
        const dateCha = new Date(cha)
        return {
          leaveDay: dateCha.getDate(),
          leaveHour: dateCha.getHours(),
          leaveMin: dateCha.getMinutes() + 1,
          leaveSec: dateCha.getSeconds() + 1
        }
      },
      setEnd (timestamp) {
        const end = this.calculateEnd(timestamp)
        if (!end) { // 非结束时间时
          this.day = end.leaveDay
          this.hour = end.leaveHour
          this.min = end.leaveMin
          this.second = end.leaveSec
          this.timer = setTimeout(this.callTimeout, 1000)
        }
      },
      callTimeout () {
        if (this.day == 0 && this.hour == 0 && this.min == 0 && this.second == 0) {
          return false
        } else if (this.hour == 0 && this.min == 0 && this.second == 0) {
          --this.day
          this.hour = 23
          this.min = 60
          this.second = 60
        } else if (this.min == 0 && this.second == 0) {
          --this.hour
          this.min = 60
          this.second = 60
        } else if (this.second == 0) {
          --this.min
          this.second = 60
        }
        --this.second
        this.timer = setTimeout(this.callTimeout, 1000)
      }
    }
  }
</script>
