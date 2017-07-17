<template>
  <div class="">

    <step :stepShow="false">
      <p>选择贷款产品</p>
    </step>

    <div class="productList"
         v-for="(product, index) in products"
         @click="goProduct(product)">
      <img :src="backgrounds[index % backgrounds.length]"/>
      <p>{{product.ProductName}}</p>
    </div>
  </div>
</template>
<script>
  import step from '../step/index.vue'
  import {fetchAPI} from '../../libs/fetch'
  import {mapGetters} from 'vuex'

  import bg1 from 'imgPath/home1.png'
  import bg2 from 'imgPath/home2.png'
  import bg3 from 'imgPath/home3.png'

  export default {
    components: {
      step
    },
    data () {
      return {
        products: [],
        backgrounds: [bg1, bg2, bg3],
        topic: "线上贷款"
      }
    },
    methods: {
      goProduct (item) {
        this.$store.commit('NONE_MODIFY_ADD_ROLE')
        this.$router.push({
          name: 'fillInform', params: {
            step: 1,
            group: '按揭申请人信息',
            role: 'self',
            product: item.ProductId
          }
        })
      },
      getUserPhone() {
        /**
         * 调用APP内方法
         * 获取APP登录状态的手机号
         */
        const ua = navigator.userAgent
        let userType = ""
        if (!!ua.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
          // 测试chrome中是iphone6模式
          userType = window.islogin ?
                  window.islogin.getUserPhone() :
                  '13600136007';
          console.log(userType)
        } else if (ua.indexOf('Android') > -1 || ua.indexOf('Linux') > -1) {
          userType = window.islogin && window.islogin.getUserPhone()
        }
        return userType;
      }
    },
    created() {
      const phone = this.getUserPhone()
      this.$store.commit('SAVE_PHONE', {
        phone
      })

      this.$interfaces.productList(this)
              .then(response => {
                this.products = response.data
              })
    },
    computed: {
      ...mapGetters({
        roleGroup: 'roleGroup'
      })
    }
  }
</script>
<style scoped lang="less">
  .productList {
    width: 7rem;
    height: 2.5rem;
    text-align: center;
    background: url(~imgPath/cityBg.png) white no-repeat;
    background-position: bottom;
    margin: 0.25rem auto;
    background-size: 100% auto;
    border-radius: 10px;
    box-shadow: 1px 1px 10px gray;

  img {
    width: 2.03rem;
    margin-top: 0.2rem;
  }

  p {
    font-size: 0.28rem;
    color: #673344;
  }

  }
</style>