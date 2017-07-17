<template>
  <div class="wrap">
    <template v-for="(formItem, key) in datas">
      <template v-if="formItem.formType == 'input'">
        <x-ceil :label="formItem.label">
          <x-input slot="right"
                   :placeholder="formItem.placeholder"
                   :tips="formItem.tips"
                   :units="formItem.units"
                   :currentValue="formItem.value"
                   v-model="formItem.value"
                   :label="formItem.label"
                   @onChange="keyDownSync"
          ></x-input>
        </x-ceil>
      </template>

      <template v-if="formItem.formType == 'select'">
        <x-ceil :label="formItem.label">
          <x-select
            slot="right"
            :placeholder="formItem.placeholder"
            :data="formItem.options"
            v-model="formItem.value"
            :units="formItem.units"
          ></x-select>
        </x-ceil>
      </template>

      <template v-if="formItem.formType == 'calendar'">
        <x-ceil :label="formItem.label">
          <datetime
            slot="right"
            :placeholder="formItem.placeholder"
            :value="formItem.value"
            v-model="formItem.value"
            :min-year="1950"
            :title="formItem.label"></datetime>
        </x-ceil>

        <!--<calendar :placeholder="formItem.placeholder"
                  :value="formItem.value"
                  v-model="formItem.value"
                  :title="formItem.label"
        ></calendar>-->
      </template>

      <template v-if="formItem.formType == 'address'">
        <x-address
          :value="formItem.value"
          v-model="formItem.value"
          :title="formItem.label"
          @onChange="onAddressChange"
        ></x-address>
      </template>

      <template v-if="formItem.formType == 'radio'">
        <x-ceil :label="formItem.label">
          <x-radio
            slot="right"
            :data="formItem.options"
            v-model="formItem.value"
            :value="formItem.value"
            :unCheckedClass="formItem.unCheckedClass"
            :checkedClass="formItem.checkedClass"
            :labelClass="formItem.labelClass"
            @onChange="spreadParent"
          ></x-radio>
        </x-ceil>

      </template>

      <template v-if="formItem.formType == 'checker'">

        <x-ceil :label="formItem.label">
          <checker slot="right"
                   v-model="formItem.value"
                   :value="formItem.value">
            <template v-for="(opt, index) in formItem.options">
              <checker-item
                :key="opt.name"
                :value="opt.name"
                v-if="!opt.isDisabled"
              >{{opt.name}}
              </checker-item>
              <!--disabled状态-->
              <checker-item
                :key="opt.name"
                :value="opt.name"
                v-else
                :disabled="true"
              >{{opt.name}}
              </checker-item>

            </template>

          </checker>

        </x-ceil>

      </template>
    </template>

  </div>

</template>

<script>
  import xCeil from '../x-ceil'
  import xInput from '../x-input'
  import {checker, checkerItem} from '../checker'
  import xSelect from '../x-select'
  import xRadio from '../x-radio'
  import datetime from '../datetime'
  import calendar from '../calendar'

  import xAddress from '../x-address'
  import {mapGetters} from 'vuex'
  export default {
    components: {
      xInput,
      xSelect,
      checker,
      checkerItem,
      xRadio,
      xCeil,
      calendar,
      xAddress,
      datetime
    },
    props: {
      datas: Array
    },
    computed: {
      ...mapGetters([
        'maxStep'
      ])
    },
    methods: {
      _selfEqual(val) {
        return this.$route.params.step == this.maxStep
          && (
            val == '通讯地址与现居住地址相同' ||
            val == '通讯地址与工作单位地址相同'
          )
      },
      _filterEqual() {
        return this.$route.params.step == this.maxStep
          && this.datas
            .filter(ele =>
            ele.value == '通讯地址与现居住地址相同' ||
            ele.value == '通讯地址与工作单位地址相同')
            .length
      },
      spreadParent (curr) {
        // 最后一步时
        if (this._selfEqual(curr)) {
          // 将单选框现在的值传进去
          this.radioValue = curr
          this.$emit('onRadioChange', curr)
        }
      },
      // Input框改变时
      keyDownSync (curr) {
        // 最后一步时且radio的值为...
        if (this._filterEqual()) {
          this.$emit('onInputChange', curr, this.radioValue)
        }
      },
      // 地址框改变时
      onAddressChange (curr) {
        if (this._filterEqual()) {
          this.$emit('onPaAddressChange', curr, this.radioValue)
        }
      }
    },
    data () {
      return {
        radioValue: ''
      }
    }
  }
</script>