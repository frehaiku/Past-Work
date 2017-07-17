<style lang="less" rel="stylesheet/less" scoped="">
  @import "~cssPath/custom";

  .orderTit {
    font-size: .32rem;
    color: @fontDeepGray;
    margin-top: .56rem;
  }

  .remark {
    font-size: .26rem;
    margin-bottom: .2rem;
    color: @fontDeepGray;
  }

  .remark:last-of-type {
    padding-bottom: .4rem;
  }

  .top-wrapper {
    margin-bottom: .2rem;
  }

  .orderStatus {
    font-size: .28rem;
    color: @fontDeepRed;
    margin-top: .6rem;
    margin-bottom: .54rem;
  }

  .more {
    padding: .4rem 0;
    color: @fontPink;
  }

  .remarkactive {
    color: @fontDeepRed;
  }

  .dataContent {

    margin-top: 20px;
    background: white;
  }

  .list {
    border-bottom: 1px solid #F4F4F4;
    padding: 0.28rem;
    overflow: hidden;
  }
</style>
<!--3.0客户订单（银行审核中）-->
<template>
  <div class="apply-wrapper">
    <div class="top-wrapper of bgWhite">
      <p class="marginGap orderTit">订单编号：{{orderId}}</p>

      <!--初审中-->
      <p class="marginGap orderStatus">{{orderDetail["业务状态"]}}</p>
      <!--银行初审通过，待补充资料，待补充资料-->
      <!--<p class="marginGap orderStatus">银行初审通过，待补充资料</p>
      <p class="marginGap remark">备注</p>
      <p class="marginGap remark">1、需要补充什么资料，</p>
      <p class="marginGap remark">2、需要补充什么资料</p>-->
      <!--待补充资料-->
      <!--<p class="marginGap orderStatus">待补充资料</p>
      <p class="marginGap remark">备注</p>
      <p class="marginGap remark">1、需要补充什么资料</p>
      <p class="marginGap remark">2、需要补充什么资料</p>-->
      <!--审核通过-->
      <!--<p class="marginGap remark remarkactive">审核结果：</p>
      <p class="marginGap remark">1、需要补充什么资料</p>
      <p class="marginGap remark">2、需要补充什么资料</p>-->
    </div>
    <div class="dataContent">
      <div class="list"
      v-for="listItem in listTpl">
        {{listItem.ceil}}
        <span class="fr" v-text="listItem.value"></span>
      </div>
    </div>
    <p class="more tac bgWhite" @click="lookMore">查看更多信息</p>
  </div>
</template>

<script>
  import xCeil from '../x-ceil'
  import {fetchAPI} from '../../libs/fetch'
  export default {
    components: {xCeil},
    computed: {
      listTpl () {
        if (!Object.keys(this.orderDetail).length)
          return []
        else {
          let detailMsg = this.orderDetail["按揭详细信息"],
                  applyMsg = detailMsg["按揭申请人信息"]
          return [
            {
              ceil: '主贷款人姓名',
              value: applyMsg["贷款人姓名"]
            },
            {
              ceil: '成交物业地址',
              value: applyMsg["成交物业地址_省"] +
              applyMsg["成交物业地址_市"] +
              applyMsg["成交物业地址_县(区)"]
            },
            {
              ceil: '',
              value: applyMsg["成交物业地址_街"] +
              applyMsg["成交物业地址_路"] +
              applyMsg["成交物业地址_巷"] +
              applyMsg["成交物业地址_小区名称"] +
              applyMsg["成交物业地址_栋"] + "栋" +
              applyMsg["成交物业地址_房号"] + "号"
            },
            {
              ceil: '成交价',
              value: applyMsg["成交价"] + '万元'
            },
            {
              ceil: '计划贷款金额',
              value: applyMsg["计划贷款金额"] + '万元'
            },
            {
              ceil: '计划贷款年限',
              value: applyMsg["计划贷款期限"] + '月'
            }]
        }
      }
    },
    data () {
      return {
        orderId: "",
        orderDetail: {}
      }
    },
    created () {
      console.log(this.$route.params)
      const params = this.$route.params;
      this.orderId = params.orderId;
      const self = this;
      this.$interfaces.getOrderDetails(this, {
        "sn": params.orderId,
        "productId": params.productId
      }).then(response => {
        console.log(response)
        this.orderDetail = response.data;
      })

      // 返回时立即重置
      // 防止applyInform页面点返回时被认为是增加共同申请人后的返回行为
      // 增加共同申请人后的返回是go(-7)
      this.$store.commit('NONE_MODIFY_ADD_ROLE')
    },
    methods: {
      lookMore () {
        this.$router.push({
          name: 'applyInform',
          params: {
            orderId: this.$route.params.orderId,
            productId: this.$route.params.productId
          }
        })
      }
    }
  }
</script>