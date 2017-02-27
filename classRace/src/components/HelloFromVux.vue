<template>
  <div class="vux-demo" >
    <h1>{{ this.msg }}</h1>
  </div>
  <group title="cell demo">
    <cell title="Vux" value="Cool" is-link></cell>
  </group>
</template>

<script>
import Group from 'vux/src/components/group'
import Cell from 'vux/src/components/cell'

export default {
  components: {
    Group,
    Cell
  },
  data () {
    return {
      // note: changing this line won't causes changes
      // with hot-reload because the reloaded component
      // preserves its current state and we are modifying
      // its initial state.
      msg: 'Hello World!'
    }
  }
}
</script>

<style rel="stylesheet/scss">

.vux-demo {
  text-align: center;
}

.logo {
  width: 100px;
  height: 100px
}
</style>
