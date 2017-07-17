<style scoped="" lang="less">
  @import "~cssPath/custom";

  label.x-input-label {
    background-color: #ffffff !important;
    position: relative;
    display: block;
    margin-left: .28rem;
    margin-right: .32rem;
    font-size: .26rem;
    color: @fontDeepGray;
    padding: .32rem 0;}

  input.x-input {
    outline: none;
    border: none;
    text-align: right;
  }
  .x-input-right {
    float: right;
  }

  em.u {
    font-style: normal;
    color: @fontDeepRed;
    font-size: .26rem;
    margin-left: .1rem;
  }

  em.t {
    position: absolute;
    right: 0;
    bottom: 3px;
    color: @fontBlue;
    font-size: .2rem;
  }
</style>

<template>
        <span class="x-input-right"
              :class="{w100: !label}">
            <input type="text" class="x-input "
                   v-model="value"
                   :placeholder="placeholder"
                   :class="{w100: !label, w90: label}"
                   :readonly="readonly">
            <em class="u" v-show="units">{{units}}</em>
            <em class="t" v-show="tips">{{tips}}</em>
        </span>
  <!--<label class="x-input-label">
      <slot></slot>
      <span class="x-input-right">
          <input type="text" class="x-input" :placeholder="placeholder">
          <em class="u" v-show="units">{{units}}</em>
          <em class="t" v-show="tips">{{tips}}</em>
      </span>

  </label>-->
</template>

<script>
  export default {
    data: function () {
      return {
        value: this.currentValue
      }
    },
    watch: {
      value (nVal) {
        this.$emit('input', nVal)
        this.$emit('onChange', nVal)
      },
      currentValue (val) {
        this.value = val
      }
    },
    props: {
      placeholder: String,
      units: String,
      tips: String,
      currentValue: String,
      label: String,
      readonly: {
        type: Boolean,
        default: false
      }
    }
  }
</script>