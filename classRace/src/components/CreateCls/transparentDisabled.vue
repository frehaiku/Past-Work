<style>
  .white-mask{
    width: 100%;
    height: 100%;
    position: fixed;
    top: 168px;
    left: 0;
    background: transparent;
    z-index: 999;
  }
</style>
<template>
  <div class="white-mask" v-if="maskStat" @click="noModify"></div>
</template>
<script>
export default {
  props: {
    maskStat: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    noModify () {
      this.$root.msg('warn', '不能修改第一步和第二步填写过的内容')
    }
  }
}
</script>
