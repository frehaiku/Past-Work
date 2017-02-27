<template @transfer-to-child="updateDom">
  <group >
    <popup-picker title="学校" :data="schoolBind" placeholder="请选择学校" :columns="5" :fixed-columns="2"
                  :value.sync="oInfo.schoolInfo"
                  :show-name="true"></popup-picker>
  </group>
  <group title="年级">
    <radio :options="gradeBind" :value.sync="oInfo.gradeInfo"></radio>
  </group>
  <group>
    <popup-picker title="班级" :data="clsBind" placeholder="请选择班级" :columns="7" :fixed-columns="1"
                  :value.sync="oInfo.classInfo"
                  :show-name="true"></popup-picker>
  </group>
</template>
<script>
  import SchoolJSON from '../CreateCls/school.json'
  import PopupPicker from 'vux/src/components/popup-picker'
  import Group from 'vux/src/components/group'
  import Radio from 'vux/src/components/radio'

  export default {
    components: {PopupPicker, Group, Radio},
    data () {
      return {
        oInfo: {
          schoolInfo: [],
          gradeInfo: '',
          classInfo: []
        },
        schoolBind: SchoolJSON,
        gradeBind: [{key: 1, value: '高一'}, {key: 2, value: '高二'}, {key: 3, value: '高三'}]
      }
    },
    methods: {
      updateDom (obj) {
        console.log(obj)
        this.oInfo.schoolInfo = [obj.school]
        this.oInfo.gradeInfo = obj.grade
        this.oInfo.classInfo = [obj.class]
      }
    },
    computed: {
      clsBind () {
        var res = []
        for (var i = 1; i <= 36; i++) {
          var curr = {
            name: i + '班',
            value: String(i),
            parent: 0
          }
          res.push(curr)
        }
        return res
      }
    },
    watch: {
      'oInfo': {
        handler: function (newVal) {
          console.log(newVal)
          this.$dispatch('dispatch-basic-msg', newVal)
        },
        deep: true
      }
    }
  }
</script>
