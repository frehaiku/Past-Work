<template>

  <div>
    <div class="topTitle tac bgWhite">
			<span v-for="(item,index) in opManue"
            @click="changeList(index)"
            :class="{fl:index==0,fr:index==1,active:item.active}">
				{{item.text}}({{item.left}})
			</span>
      <!--<span  class="fl active">待处理 (3)</span>
      <span  class="fr">已完成（1）</span>
      <span >处理中 (2）</span>-->
    </div>
    <!--<search
            :keyWord="searchContent"
            @changeValue="changeValue"></search>-->
    <ul>
      <li v-for="(item, index) in showList"
          :key="index"
          @click="goNext(item)">
        <p>
          <span>订单编号：{{item.SN||item.AutoNo}}</span>
          <span class="gray fr">{{ item.BeginTime | formatDate('YYYY-MM-DD') }} </span>
        </p>
        <p class="ft24">
          <span class="circle"></span>
          <span class="deepRed"> {{item.BizStatus}}</span>
          <span class="fr">贷款人：{{item.applyName}}</span>
        </p>
        <img src="~imgPath/rightArrow.png"/>
      </li>

    </ul>
  </div>
</template>

<script>
  import search from '../search/index.vue'
  import {fetchAPI} from '../../libs/fetch'
  import formatDate from 'date-fns/format'

  export default {
    data() {
      return {
        searchContent: "",
        applyList: {
          untreated: [],
          completed: [],
          processing: [],
        },
        opManue: [{
          text: "待处理",
          left: 0,
          active: true
        }, {
          text: "已完成",
          left: 0,
          active: false
        }, {
          text: "处理中",
          left: 0,
          active: false
        }],
        showList: []
      }
    },
    components: {
      search
    },
    filters: {
      'formatDate': (val, ...args) => formatDate(val, ...args)
    },
    methods: {
      changeValue(value) {
        console.log(value)
        this.searchContent = value;
      },
      changeList(index){
        this.opManue.forEach(function (item) {
          item.active = false;
        })
        this.opManue[index].active = true;
        // 当点击未处理栏时，将可修改字段设置为1
        this.$store.commit('UPDATE_UNTREATED', index == 0)
        switch (index) {
          case 0:
            this.showList = this.applyList.untreated;
            break
          case 1:
            this.showList = this.applyList.completed;
            break
          case 2:
            this.showList = this.applyList.processing;
            break
        }
      },
      goNext(item){
        const id = item.SN || item.AutoNo;
        const params = {
          orderId: id,
          productId: item.productId
        }
        console.log(params)
        this.$router.push({name: 'applyDisplay', params: params})
      }
    },
    beforeCreate() {
      // 默认为处理中状态
      this.$store.commit('UPDATE_UNTREATED', 1)

//			fetchAPI(this, 'http://192.168.20.114:8081/Loan/inf/product/getOrderList', 'POST',
      this.$interfaces.getOrderList(this)
              .then(response => {
                console.log(response)
                response.data.forEach(prod => {
                  ['untreated', 'processing', 'completed'].forEach(prodStatus => {
                    this.applyList[prodStatus] =
                            this.applyList[prodStatus].concat(prod[prodStatus])
                  })
//          this.applyList = this.applyList.concat(prod)
                  this.showList = this.showList.concat(prod.untreated)
                  this.opManue[0].left = this.opManue[0].left + prod.untreated.length
                  this.opManue[1].left = this.opManue[1].left + prod.completed.length
                  this.opManue[2].left = this.opManue[2].left + prod.processing.length
                })
                console.log(this.applyList)

              })

    }
  }
</script>

<style scoped lang="less">
  @import "~cssPath/custom.less";

  .topTitle {
    height: 0.8rem;
    line-height: 0.8rem;
    margin-bottom: 0.2rem;

  span {
    width: 33%;

  &
  :nth-child(3) {
    display: block;
    width: 34%;
    margin: 0 auto;
  }

  }
  .active {
    color: @fontYellow;
    font-size: 0.28rem;
  }

  }

  ul {
    margin-top: 1px;

  li {
    background: white;
    padding: .2rem .5rem .2rem .2rem;
    line-height: 0.44rem;
    margin-bottom: 1px;
    position: relative;

  img {
    position: absolute;
    right: 0.2rem;
    top: 50%;
    width: 0.14rem;
    transform: translateY(-50%);
  }

  .circle {
    display: inline-block;
    width: 0.14rem;
    height: 0.14rem;
    border-radius: 50%;
    background: @fontPink;
  }

  }
  }
</style>