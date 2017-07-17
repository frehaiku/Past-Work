<template>
  <div>
    <div class="bgWhite">
      <ul>
        <!--遍历state中的upload项-->
        <li
          @click="goItem(uploadItem)"
          v-for="(uploadItem, index) in uploadList"
          :key="uploadItem">{{uploadItem}}
          <i></i>
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
  import {mapState} from 'vuex'
  export default {
    computed: {
      ...mapState({
        productId: state => state.modify.modifyOrderParams.productId,
        activeRole: state => state.modify.activeRole,
        activeDatum: state => state.modify.activeDatum,
        uploadList: state => state.applicant.uploadList
      })
    },
    methods: {
      // 拼接uploadImg页面需要的参数
      goItem (item) {
        let group = this.activeRole.replace(/(\d+)/g, '') + '信息',
          role = this.activeDatum[group][RegExp.$1]['与贷款人的关系'] || 'self'
        this.$router.push({
          name: 'uploadImg',
          params: {
            item,
            product: this.productId,
            role,
            group
          },
          query: {
            operation: 'modify'
          }
        })
      }
    },
    data() {
      return {}
    }
  }
</script>

<style scoped lang="less">
  @import "~cssPath/custom";

  #wrap {
    padding-bottom: 1rem;
  }

  .bgWhite {
    padding: 0 0.2rem;

  ul {
    margin-top: 1.3rem;

  li {
    list-style: decimal inside;
    padding: 0.3rem;
    font-size: 0.26rem;
    color: @fontBlack;
    border-bottom: 1px solid #f4f4f4;

  i {
    float: right;
    width: 0.14rem;
    height: 0.26rem;
    background: url(~imgPath/rightArrow.png);
    background-size: 100% 100%;
  }

  }
  .active {
    color: @fontYellow;
  }

  }
  }

  .tips {
    color: @fontBlue;
    line-height: 0.7rem;
  }

  .check {
    color: @fontDeepRed;
    margin: .2rem 0;

  i {
    display: inline-block;
    width: 0.28rem;
    height: 0.28rem;
    border: 1px solid @fontDeepRed;
    border-radius: 0.05rem;
    vertical-align: middle;
    position: relative;
    top: -2px;
  }

  .active {
    background: url(~imgPath/pick.png);
    background-size: 100% 100%;
  }

  }

  .btnContent {
    margin: 0.2rem;

  input {
    background: @fontYellow;
    border: none;
    outline: none;
    height: 0.66rem;
    width: 3.4rem;
    color: white;
    border-radius: 0.1rem;
  }

  }

  .pop {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .5);
    left: 0;
    top: 0;

  .content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 1px solid @fontBlack;
    width: 5.34rem;
    background: white;
    text-align: center;
    padding: 0.5rem 0;
    line-height: 0.56rem;
    border-radius: 0.2rem;

  .nextStep {
    width: 2.4rem;
  }

  }
  .close {
    position: absolute;
    right: -0.7rem;
    top: -0.7rem;
    width: 0.58rem;
    height: 0.58rem;
  }

  }
</style>