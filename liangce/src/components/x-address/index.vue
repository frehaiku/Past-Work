<template>
  <div>
    <popup-picker
      :fixed-columns="hideDistrict ? 2 : 0"
      :columns="3"
      :data="list"
      :title="title"
      v-model="currentValue"
      show-name
      :inline-desc="inlineDesc"
      :placeholder="placeholder"
      @on-hide="emitHide"
      @on-show="$emit('on-show')"
      :value-text-align="valueTextAlign"
      :confirm-text="confirmText"
      :cancel-text="cancelText"
      :display-format="displayFormat"
      :noneCeil="noneCeil"
      :disabled="disabled"
    ></popup-picker>
  </div>
</template>

<script>
import name2value from '../../filters/name2value'
import value2name from '../../filters/value2name'
import ChinaAddressV3Data from '../../datas/china_address_v3.json'
import PopupPicker from '../popup-picker'

export default {
  components: {
    PopupPicker
  },
  props: {
    title: {
      type: String,
      default: ''
    },
    value: {
      type: Array,
      default () {
        return []
      }
    },
    rawValue: Boolean,
    list: {
      type: Array,
//      required: true,
      default () {
        return ChinaAddressV3Data
      }
    },
    inlineDesc: String,
    placeholder: String,
    hideDistrict: Boolean,
    valueTextAlign: String,
    confirmText: String,
    cancelText: String,
    displayFormat: {
      type: Function,
      default: (val, names) => names
    },
    noneCeil: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  created () {
    if (this.currentValue.length && this.rawValue) {
      const parsedVal = name2value(this.currentValue, this.list)
      if (/__/.test(parsedVal)) {
        console.error('Vux: Wrong address value', this.currentValue)
        this.currentValue = []
      } else {
        this.currentValue = parsedVal.split(' ')
      }
    }
  },
  methods: {
    emitHide (val) {
      this.$emit('on-hide', val)
    },
    getAddressName () {
      return value2name(this.value, this.list)
    }
  },
  data () {
    return {
      currentValue: this.value
    }
  },
  computed: {
    nameValue () {
      return value2name(this.currentValue, this.list)
    }
  },
  watch: {
    currentValue (val) {
      this.$emit('input', val)
      this.$emit('onChange', val)
    },
    value (val) {
      // 修复value为name时，currentValue没有更新
      if (val.length && !/\d+/.test(val[0])) {
        const id = name2value(val, this.list).split(' ')
        if (id[0] !== '__' && id[1] !== '__') {
          this.currentValue = id
          return
        }
      }
      this.currentValue = val
    }
  }
}
</script>
