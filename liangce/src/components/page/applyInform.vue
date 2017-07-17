<style scoped="" rel="stylesheet/less" lang="less">
  @import "~cssPath/_applyInformList";
  #addRole {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;
    background-color: #F4F4F4;
    .nextStep {
      margin-bottom: 1.2rem;
    }
  }
  ul.of {
    padding-bottom: 2.46rem;
  }
</style>

<!--3.2申请人资料 （不可修改） 拷贝-->
<template>
  <div class="inform-wrapper">
    <ul class="of">
      <template
        v-for="(roleArr, roleKey) in activeDatum"
      >
        <li class="parent-l parent-l-hasBefore"
            v-for="(roleItem, roleIdx) in roleArr"
            @click="goDetail(roleItem, `${wipeMsg(roleKey)}${roleIdx}`)"
            :key="`${roleKey}${roleIdx}`"
            :class="{dn: !roleItem['行业']}"
        >
          {{wipeMsgSame(roleKey)}}：{{ roleItem['贷款人姓名'] }}
          <i class="arrow"></i>
        </li>
      </template>

    </ul>

    <div id="addRole" v-if="isUntreated">
      <input type="button" class="nextStep" name="" value="添加共同申请人"
             @click="modifyAddRole"
      />
    </div>
  </div>
</template>

<script>
  import {mapState, mapGetters} from 'vuex'
  import {fetchAPI} from '../../libs/fetch'

  export default {
    data () {
      return {
        informs: {},
        mainPerson: [],
        commonPerson: [],
        danbao: []
      }
    },
    computed: {
      ...mapGetters(
        [
          'roleGroups',
          'activeDatum'
        ]
      ),
      ...mapState({
        'isUntreated': (state) => state.modify.isUntreated
      }),
      jointParam () {
        return {
          name: 'commonApply',
          params: {
            role: 'self',
            group: '按揭共同申请人信息',
            product: this.nonceRouter.productId
          }
        }
      },
      nonceRouter () {
        return this.$route.params
      },
    },
    methods: {
      wipeMsg (roleGroup) {
        return roleGroup.replace(/信息/, '')
      },
      wipeMsgSame (roleGroup) {
        return roleGroup.replace(/[按揭信息]*/g, '')
      },
      goDetail (item, role) {
//        this.$store.commit('MODIFY_DATUM', {data: item})
        this.$store.commit('MODIFY_ROLE', {data: role})
        this.$router.push({
          path: '/applyInformItem',
          params: this.nonceRouter
        })
      },
      modifyAddRole () {
        // 将增加角色的modify状态打开（uploadList要做判断）
        this.$store.commit('IS_MODIFY_ADD_ROLE')
        // 写入history初始长度
        this.$store.commit('UPDATE_HISTORY_LENGTH', window.history)
        this.$router.push(this.jointParam)
      }
    },
    created() {
      /*fetchAPI(this,
       this.$config.interfaceV1 + 'getOrderList?accountName=alex&password=123456',
       'GET')
       .then(response => console.log(response))*/
      this.$interfaces.getOrderDetails(this, {
        productId: this.$route.params.productId,
        sn: this.$route.params.orderId
      })
        .then(response => {
          let informs = response.data['按揭详细信息'] || []

          if (!informs.length) {
            this.roleGroups.some((ele, ind) => {
              // 不存在共同申请人和担保人时，不显示key
              if (!Object.keys(informs[ele]).length) return false
              this.informs[ele] =
                (informs[ele] instanceof Array ? informs[ele] : [informs[ele]])
            })
//            console.log(this.informs)
          }
            return this.informs
        })
      .then(informs => {
        this.$store.commit('EMPTY_DATUM')
        this.$store.commit('MODIFY_DATUM', {data: informs})
        // 存入修改订单接口参数
        this.$store.commit('UPDATE_MODIFY_ORDER_PARAMS', {
          data: {
            productId: this.$route.params.productId,
            sn: this.$route.params.orderId,
          }
        })
      })
    }
  }
</script>