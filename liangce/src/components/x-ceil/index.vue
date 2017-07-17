<style scoped="" lang="less">
  @import "~cssPath/custom";

  .x-input-wrapper {
    background-color: #ffffff;
    overflow: hidden;
  }

  label.x-input-label {
    /*overflow: hidden;*/
    position: relative;
    display: block;
    margin-left: .28rem;
    margin-right: .32rem;
    font-size: .26rem;
    color: @fontDeepGray;
    padding: .32rem 0;

  &
  :after {
    content: '';
    width: 130%;
    height: 1px;
    background-color: #eee;
    position: absolute;
    bottom: 0;
    left: 0;
  }

  }
  /*address组件不能单独提取ceil出来，故需做address样式重置*/
  .label-has-ceil {
    width: 100%;
    padding: 0 !important;
    margin-right: 0!important;
    .fr:after {
    content: '';
       /*取消伪类边框线*/
       background-color: transparent!important;
     }
  }

</style>

<template>
  <div class="x-input-wrapper clearfix">
    <label class="x-input-label" :class="{fr: !label, w65: !label, 'label-has-ceil': noneCeil}">
      {{label}}
      <slot name="right"></slot>
      <span class="fr">{{value}}</span>

      <div class="clearfix"></div>
    </label>
  </div>

</template>

<script>
  export default {
    data: function () {
      return {}
    },
    props: {
      placeholder: String,
      units: String,
      tips: String,
      label: String,
      value: String,
      noneCeil: {
        type: Boolean,
        default: false
      }
    }
  }
</script>