<style scoped="" lang="less">
  @import "~cssPath/custom";

  .x-select-wrapper {
    float: right;
  }

  .x-select-p:after {
    content: '';
    display: inline-block;
    width: .14rem;
    height: .09rem;
    background: url("~imgPath/arrow.png");
    background-size: cover;
    margin-left: .2rem;
    vertical-align: middle;
  }

  .x-select {
    -webkit-appearance: none;
    outline: none;
    border: none;
    /*min-width: 60%;*/
    background-color: transparent;
    color: @fontBlack;
    text-align: right;
    /*select框右对齐，fixed默认箭头为左*/
    text-align-last: right;

  option {
    direction: ltr;
  }

  }

  em.u {
    font-style: normal;
    color: @fontDeepRed;
    font-size: .26rem;
    margin-left: .2rem;
  }
</style>

<template>
  <div class="x-select-wrapper">
            <span class="x-select-p">
                <select class="x-select"
                        v-model="currentSelect"
                        :disabled="readonly"
                >
                    <option v-for="optItem in data" :value="optItem">{{optItem}}</option>
                </select>
            </span>
    <em class="u" v-show="units">{{units}}</em>
  </div>
</template>

<script>
  import xCeil from '../x-ceil'

  export default {
    components: {xCeil},
    props: {
      data: Array,
      units: String,
      value: {
        type: [String, Array, Object],
        required: true
      },
      readonly: {
        type: Boolean,
        default: false
      }
    },
    data () {
      return {
        currentSelect: this.value
      }
    },
    watch: {
      value (newVal) {
        this.currentSelect = newVal
      },
      currentSelect (newVal) {
        this.$emit('input', newVal)
      }
    },
    methods: {
      updateSelect (value) {
        this.$emit('input', value)
      }
    }
  }
</script>