<template>
  <div id="">

    <div class="secondPart bgWhite">

      <ImgInput @on-upload="onUpload"
                v-for="(d, index) in finalPic.uploadData"
                :key="`${nonceRouter.item}${index}`"
                :indexOf="index"
                :preview="finalPic.previews[index]"
                :readonly="!isUntreated"
      ></ImgInput>
    </div>
    <input v-show="nextVal" @click="nextUpload" type="button" :value="'下一步：'+nextVal" class="nextStep"/>
    <input v-show="!nextVal" @click="goList" type="button" value="已补全资料，返回核对" class="nextStep"/>
  </div>

</template>

<script>
  import ImgInput from "../ImgInput/index.vue"
  import {extend} from '../../libs/extend'
  import {mapGetters, mapState} from 'vuex'
  export default {
    components: {
      ImgInput
    },
    methods: {
      _commitVuex() {
        // 修改图片
        if (this.isModify) {
          let cp = {}, outer = {}
          // 深复制，因为不能直接改变state，应通过commit
          extend(true, cp, this.activeDatum)
          console.log(cp)

          cp[`${this.roleFont}信息`]
            [this.roleNum]
            [this.roleFont + this.nonceRouter.item]
            [this.picKey]
            = this.finalPic.uploadData
            .filter(ele => ele != "")
            .join(',')
          outer['按揭详细信息'] = cp
          this.$store.dispatch({
            type: 'fetchModifyOrder',
            vm: this,
            data: outer,
            item: cp
          })
          /*this.$store.commit('MODIFY_DATUM', {
            data: cp
          })*/
        } else {
          // 增加图片时
          this.$store.commit(
            'SAVE_UPLOAD',
            {
              ...(this.$route.params),
              data: this.finalPic.uploadData.slice(),
              previews: this.finalPic.previews.slice()
            }
          )
        }

      },
      // 保存数据
      nextUpload () {
//        this._commitVuex()
        this.$router.replace(this.nextRouter)
      },
      // on-upload回调
      onUpload ({path: filePath, index, previews}) {
        if (index + 1 == this.finalPic.uploadData.length) {
          this.finalPic.uploadData.pop()
          this.finalPic.uploadData.push(filePath, '')
          // 处理预览图
          this.finalPic.previews.pop()
          this.finalPic.previews.push(previews, '')
        } else {
          // 点击修改按钮
          this.finalPic.uploadData.splice(index, 1, filePath)
          this.finalPic.previews.splice(index, 1, previews)
        }
        // 上传完毕直接修改vuex
        this._commitVuex()
      },
      goList () {
        this._commitVuex()
        this.$router.push({name: 'uploadList', params: this.$route.params})
      }
    },
    computed: {
      ...mapGetters([
        'uploadList',
        'maxStep',
        'appliantMsg',
        'roleNum',
        'roleFont',
        'activeRole'
      ]),
      ...mapState({
        'activeDatum': state => state.modify.activeDatum,
        'productId': state => state.modify.productId,
        'isUntreated': state => state.modify.isUntreated
      }),
      finalPic () {
        return this.isModify ?
        {
          uploadData: this.modifyPic.datas,
          previews: this.modifyPic.previews
        } :
          // 处理状态下不可更改图片
        {
          uploadData: this.itemData.value || this.isUntreated && [''],
          previews: this.itemData.previews || this.isUntreated && ['']
        }
      },
      // 下一上传项的item
      nextVal () {
        const upl = this.uploadList
        return upl[upl.indexOf(this.nonceRouter.item) + 1]
      },
      // 下一上传项的router
      nextRouter () {
        return {
          name: 'uploadImg', params: {item: this.nextVal}
        }
      },
      nonceRouter () {
        return this.$route.params
      },
      // 是否是修改图片操作
      isModify () {
        return this.$route.query.operation === 'modify'
      },
      picKey () {
        return this.nonceRouter.item.split('（')[0]
      },
      noncePic () {
        let item = this.nonceRouter.item

        return this.activeDatum
          [this.nonceRouter.group]
          [this.roleNum]
          [this.roleFont + item]
          [this.picKey]
      },
      modifyPic () {
        let nonce =
          (this.noncePic) ?
            this.noncePic.split(',') : [],
          previews = this.isUntreated ?
            nonce.map(ele => this.$config.httpPrefix + ele).concat('') :
            nonce.map(ele => this.$config.httpPrefix + ele)
        // 增加一个空元素代表上传按钮（订单非处理中时不添加）
        return {
          previews,
          datas: this.isUntreated ? nonce.concat('') : nonce
        }
      },
      // 每个上传项的vuex数据
      itemData () {
        if (this.isModify) {
          return this.modifyPic
        } else {
          let itemArr,
            item = this.appliantMsg[this.nonceRouter.group]
              [this.nonceRouter.role][this.maxStep]
          console.log(item)
          return item ?
            (
              (
                itemArr = item.filter(ele => ele.label == this.nonceRouter.item)
              ).length ? itemArr[0] : ''
            ) :
            ''
        }

      }
    },
    data () {
      return {}
    }
  }
</script>

<style lang="less" scoped>
  @import "~cssPath/custom";
  @import "~cssPath/_uploadList.less";

  .top {
    line-height: 1.1rem;
    color: @fontGray;
  }

  .example {
    padding: 0.2rem 0;

	  img {
	    width: 6.74rem;
	  }

  }
  .listBg3 {
    background: url(~imgPath/sfz.png) center no-repeat;
    background-size: 43% auto;
  }

  .listBg4 {
    background: url(~imgPath/sfzBack.png) center no-repeat;
    background-size: 43% auto;
  }

  .listBg1 {
    background: url(~imgPath/humer1.png) center no-repeat;
    background-size: 43% auto;
  }

  .listBg2 {
    background: url(~imgPath/humer2.png) center no-repeat;
    background-size: 43% auto;
  }

  .nextStep {
    margin-bottom: 1rem;
  }
</style>
