<template>
  <span class="of dib">
    <x-input
      v-if="datas.formType == 'input'"
      v-model="datas.value"
      label="init"
      :currentValue="datas.value == null ? '' : datas.value"
      :readonly="readonly"
    >
    </x-input>

    <x-select
      v-if="datas.formType == 'select'"
      :data="datas.options"
      v-model="datas.value"
      :value="datas.value"
      :readonly="readonly"
    >
    </x-select>

    <datetime
      v-if="datas.formType == 'datetime'"
      v-model="datas.value"
      :min-year="1950"
      title="出生年月"
      :value="datas.value"
      :readonly="readonly"
    >
    </datetime>

    <x-address
      v-if="datas.formType == 'address'"
      v-model="datas.value"
      :value="datas.value"
      :disabled="readonly"
      noneCeil
      raw-value
    >
    </x-address>

  </span>
</template>

<script>
  import XInput from '../x-input'
  import XSelect from '../x-select'
  import datetime from '../datetime'
  import XAddress from '../x-address'
  export default {
    props: {
      datas: [Array, Object],
      readonly: {
        type: Boolean,
        default: false
      }
    },
    components: {XInput, XSelect, datetime, XAddress}
  }
</script>