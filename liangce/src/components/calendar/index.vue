<template>
  <div>
    <x-ceil :label="title" primary="content" :value="currentValue" @click.native="onClick" is-link>
      <popup v-model="show" slot="right">
        <inline-calendar
          v-model="currentValue"
          @on-change="onSelect"
          :render-month="renderMonth"
          :start-date="startDate"
          :end-date="endDate"
          :show-last-month="showLastMonth"
          :show-next-month="showNextMonth"
          :highlight-weekend="highlightWeekend"
          :return-six-rows="returnSixRows"
          :hide-header="hideHeader"
          :hide-week-list="hideWeekList"
          :replace-text-list="replaceTextList"
          :weeks-list="weeksList"
          :render-function="renderFunction"
          :render-on-value-change="renderOnValueChange"
          :disable-past="disablePast"
          :disable-future="disableFuture"
        ></inline-calendar>
      </popup>
    </x-ceil>

  </div>
</template>

<script>
import InlineCalendar from '../inline-calendar'
import Popup from '../popup'
import xCeil from '../x-ceil'
import props from '../inline-calendar/props'

const Props = props()
Props.title = {
  type: String,
  required: true
}

export default {
  components: {
    InlineCalendar,
    Popup,
    xCeil
  },
  created () {
    this.currentValue = this.value
  },
  props: Props,
  methods: {
    onClick () {
      this.show = true
    },
    onSelect (val) {
      this.show = false
      this.currentValue = val
    }
  },
  
  watch: {
    value (val) {
      this.currentValue = val
    },
    currentValue (val) {
      this.$emit('input', val)
      this.$emit('on-change', val)
    }
  },
  data () {
    return {
      show: false,
      currentValue: ''
    }
  }
}
</script>