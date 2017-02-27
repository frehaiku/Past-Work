<template>
  <x-header class="fixed-box" :left-options=" {showBack: true, backText: '返回', preventGoBack: false} ">班级详情页
    <div slot="right" @click="shareEvent">说明</div>
  </x-header>
  <group>
    <ceil title="班级编号" :value="$route.params.clsId"></ceil>
  </group>
  <group>
    <ceil title="支持数" :value.sync="classDetail.vote"></ceil>
  </group>
  <!--是申请人-->
  <div v-if="userStatus.isMaster">
    <group>
      <ceil title="加入情况" :value.sync="joinPrecent"></ceil>
    </group>
    <group>
      <ceil title="你的姓名" :value.sync="classDetail.name"></ceil>
    </group>
    <group>
      <ceil title="你的手机号" :value.sync="classDetail.tel"></ceil>
    </group>
    <group>
      <ceil title="微信号" :value.sync="classDetail.wechat"></ceil>
    </group>
    <group>
      <ceil title="班级职务" :value.sync="classDetail.duties"></ceil>
    </group>
    <group>
      <ceil title="你的学校" :value.sync="classDetail.school"></ceil>
    </group>
    <group>
      <ceil title="你的年级" :value.sync="classDetail.grade"></ceil>
    </group>
    <group>
      <ceil title="你的班级" :value.sync="classDetail.class"></ceil>
    </group>
    <group>
      <ceil title="班级人数" :value.sync="classDetail.clssize"></ceil>
    </group>
    <group>
      <ceil title="班主任姓名" :value.sync="classDetail.headmaster"></ceil>
    </group>
    <group>
      <ceil title="目前已加入的同学"></ceil>
      <div class="avatar-total">
        <span v-for="photoItem in avatar" class="avatar-item">
             <img :src="photoItem" alt="">
        </span>
      </div>
    </group>
    <group title="班级口号">
      <ceil>
        <x-textarea :max="50" :value.sync="classDetail.slogan"></x-textarea>
      </ceil>
    </group>
    <group title="班歌名称">
      <ceil>
        <x-textarea :max="20" :rows="1" :value.sync="classDetail.clssong"></x-textarea>
      </ceil>
    </group>
    <group title="班级简介">
      <ceil>
        <x-textarea :max="500" :value.sync="classDetail.clsintrod"></x-textarea>
      </ceil>
    </group>
    <group title="班级照片(图片经压缩后展示略模糊)">
      <ul class="photolist">
        <li
          v-for="classPhotoItem in classDetail.classphoto"
          track-by="$index"
          :style="'background-image:url(' + classPhotoItem + ')'"
          @click="previewImage(classPhotoItem)"
        >
          <span class="w-mask" v-show="isRemoveImg">
            <icon type="cancel" class="cha" @click="doConfirmShow($index)"></icon>
          </span>
        </li>
        <li class="addBtn operate"
            v-if="classDetail.classphoto.length < 5"
            @click="chooseImage"></li>
        <li class="dislodgeBtn operate" v-show="classDetail.classphoto != ''"
            @click="showRemoveStatus"
        ></li>
      </ul>
      <confirm confirm-text="确定" cancel-text="我再想想" title="操作提示"
               @on-confirm="removeImageItem(delImgIndex)"
               :show.sync="confirmShow">你确定删除该张班级照片吗？
      </confirm>
    </group>
    <div class="btn-wrapper">
      <x-button type="primary" @click="saveStep3">保存班级介绍资料</x-button>
    </div>
    <!--<alert title="创建班级成功" button-text="好的" :show.sync="alertShow" @click="closeAlert">
      你是申请人（{{classDetail.name}}）已创建（{{classDetail.school}}-{{classDetail.grade}}-{{classDetail.class}}）成功，请点击右上方，将本页面分享给你的同班同学，并告知其填写姓名加入本班。当你的班级超过10人加入，即可激活参赛资格
    </alert>-->
  </div>
  <!--不是申请人时-->
  <div v-if="!userStatus.isMaster">
    <!--没加入时，显示班级照片-->
    <div v-if="classDetail.classphoto.length != 0">
      <group title="班级照片(图片经压缩后展示略模糊)" v-if="!userStatus.isJoin">
        <img v-for="classPhotoItem in classDetail.classphoto"
             track-by="$index"
             :src="classPhotoItem" alt="" class="noJoinPic">
      </group>
    </div>
    <group v-else>
      <ceil title="班级照片">暂无上传照片</ceil>
    </group>

    <!--人数>10时，show班级人数-->
    <group v-if="classDetail.clsjoinNum >= 10">
      <ceil title="加入情况" :value.sync="joinPrecent"></ceil>
    </group>
    <group>
      <ceil title="学校" :value.sync="classDetail.school"></ceil>
    </group>
    <group>
      <ceil title="年级" :value.sync="classDetail.grade"></ceil>
    </group>
    <group>
      <ceil title="班级" :value.sync="classDetail.class"></ceil>
    </group>
    <group>
      <ceil title="目前已加入的同学"></ceil>
      <div class="avatar-total">
        <span v-for="photoItem in avatar" class="avatar-item">
             <img :src="photoItem" alt="">
        </span>
      </div>
    </group>

    <group title="班级口号">
      <ceil :value.sync="classDetail.slogan"></ceil>
    </group>
    <group title="班歌名称">
      <ceil :value.sync="classDetail.clssong"></ceil>
    </group>
    <!--加入后显示班级照片-->
    <div v-if="userStatus.isJoin">
      <group title="班级照片(图片经压缩后展示略模糊)">
        <ul class="photolist">
          <li
            v-for="classPhotoItem in classDetail.classphoto"
            track-by="$index"
            :style="'background-image:url(' + classPhotoItem + ')'"
            @click="previewImage(classPhotoItem)"
          >
          </li>
        </ul>
      </group>
    </div>
    <group title="班级简介">
      <ceil :value.sync="classDetail.clsintrod"></ceil>
    </group>
    <!--弹出输入验证层-->
    <popup :show.sync="supportPopup">
      <divider>请填写信息验证你是本班学生（必填）</divider>
      <!--人数<=10时，需要验证班级人数-->
      <div v-if="classDetail.clsjoinNum < 10">
        <group>
          <x-input title="你的姓名" :value.sync="supportPopupData.fullname" is-type="china-name" type="text"></x-input>
        </group>
        <group>
          <x-input title="班级人数" :value.sync="supportPopupData.clssize" keyboard="number" type="text"></x-input>
        </group>
        <group>
          <x-input title="班主任姓名" :value.sync="supportPopupData.headmaster" is-type="china-name" type="text"></x-input>
        </group>
      </div>
      <!--人数>11，需要填写申请人姓名-->
      <div v-if="classDetail.clsjoinNum >= 10">
        <group>
          <x-input title="你的姓名" :value.sync="supportPopupData.fullname" is-type="china-name" type="text"></x-input>
        </group>
        <group>
          <x-input title="申请人姓名" :value.sync="supportPopupData.applicanter" type="text"></x-input>
        </group>
        <group>
          <x-input title="班主任姓名" :value.sync="supportPopupData.headmaster" is-type="china-name" type="text"></x-input>
        </group>
      </div>
      <div class="btn-wrapper">
        <x-button type="primary" @click="joinCls">提交</x-button>
      </div>
    </popup>

    <div class="btn-wrapper">
      <x-button v-if="!userStatus.isJoin && !hiddenJoin" type="primary" @click="supportPopup=true">加入班级</x-button>
      <x-button v-if="userStatus.isJoin" :disabled="true" type="primary">已加入</x-button>
    </div>
  </div>

  <div class="btn-wrapper">
    <x-button v-if="!userStatus.isVote" type="primary" @click="supportCls">支持班级</x-button>
    <x-button v-if="userStatus.isVote" :disabled="true" type="primary" @click="supportCls">已支持</x-button>
  </div>

  <div class="share-cover" @click="shareEvent" v-if="shareTrigger"></div>
  <foot></foot>
</template>
<script>
  import XHeader from 'vux/src/components/x-header'
  import Group from 'vux/src/components/group'
  import Ceil from 'vux/src/components/cell'
  import XTextarea from 'vux/src/components/x-textarea'
  import Divider from 'vux/src/components/divider'
  import Alert from 'vux/src/components/alert'
  import XButton from 'vux/src/components/x-button'
  import Popup from 'vux/src/components/popup'
  import XInput from 'vux/src/components/x-input'
  import Foot from '../common/Foot.vue'
  import Icon from 'vux/src/components/icon'
  import Confirm from 'vux/src/components/confirm'

  import store from '../../vuex/store'
  const commit = store.commit || store.dispatch

  export default {
    components: {XHeader, Group, Ceil, XTextarea, Divider, Alert, XButton, Popup, XInput, Foot, Icon, Confirm},
    computed: {
      'joinPrecent' () {
        return this.classDetail.clsjoinNum + ' / ' + this.classDetail.clssizeNum
      }
    },
    data () {
      return {
        delImgIndex: 0,
        confirmShow: false,
        isRemoveImg: false,
        supportPopup: false,
        shareTrigger: false,
        userStatus: {isMaster: false, isJoin: false, isVote: false},
        alertShow: false,
        avatar: [],
        classDetail: {
          name: '',
          tel: '',
          wechat: '',
          duties: '',
          school: '',
          grade: '',
          class: '',
          clssize: '',
          clssizeNum: '',
          headmaster: '',
          slogan: '',
          clssong: '',
          clsintrod: '',
          clsjoinNum: '',
          classphoto: [],
          vote: 0
        },
        supportPopupData: {
          fullname: '',
          clssize: '',
          headmaster: '',
          clsid: this.$route.params.clsId,
          applicanter: ''
        },
        hiddenJoin: window.sessionStorage.getItem('isVote') || 0
      }
    },
    ready () {
      this.judIsMaster()
    },
    methods: {
      doConfirmShow ($index) {
        this.confirmShow = true
        this.delImgIndex = $index
      },
      removeImageItem (ind) {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=deleteWxImage&index=' + ind + '&class=' + this.$route.params.clsId)
          .then((response) => {
            const responseBody = response.body
            if (responseBody.state == 'success') {
              //remove item
              let del = this.classDetail.classphoto[ind]
              this.classDetail.classphoto.$remove(del)
              this.$root.msg('success', responseBody.info)
            } else {
              this.$root.msg('warn', responseBody.info)
            }
          })

      },
      showRemoveStatus () {
        this.isRemoveImg = !this.isRemoveImg
      },
      previewImage (item) {
        if (this.isRemoveImg) return;
        var _ths = this
        wx.previewImage({
          current: item, // 当前显示图片的http链接
          urls: _ths.classDetail.classphoto // 需要预览的图片http链接列表
        });
      },
      chooseImage () {
        if (this.$root.isWeixin() === false) {
          this.$root.msg('warn', '请使用微信打开')
        } else {
          var _ths = this
          wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
              let localIds = res.localIds[0].toString() // localId可以作为img标签的src属性显示图片
              _ths.wxuploadImg(localIds)
            }
          })
        }
      },
      wxuploadImg: function (imgID) {
        commit('UPDATE_LOADING', true)
        var _ths = this
        setTimeout(() => {
          wx.uploadImage({
            localId: imgID, // 需要上传的图片的本地ID，由chooseImage接口获得
            isShowProgressTips: 1, // 默认为1，显示进度提示
            success: function (res) {
              var serverId = res.serverId // 返回图片的服务器端ID
              // down local
              _ths.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=downloadWxImage&serverId=' + serverId)
                .then(response => {
                  commit('UPDATE_LOADING', false)
                  _ths.$root.msg('success', response.body.info)
                  //update classPhoto
                  _ths.classDetail.classphoto.push(response.body.data)
                })
            }
          })
        }, 100)

      },
      shareEvent () {
        this.shareTrigger = !this.shareTrigger
      },
      _numToGrade (v) {
        var ret
        switch (parseInt(v)) {
          case 1:
            ret = '高一'
            break
          case 2:
            ret = '高二'
            break
          case 3:
            ret = '高三'
            break
        }
        return ret
      },
      _formatCls (value) {
        return value + '班'
      },
      _formatCount (value) {
        return value + '人'
      },
      supportCls () {
        if (this.$root.isWeixin() === false) {
          this.$root.msg('warn', '请往公众号“惠州学生汇”发送“投票”后进入本页面')
        } else {
          this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=vote&classid=' + this.$route.params.clsId)
            .then(response => {
              var responseJson = response.body
              if (responseJson.state === 'fail') {
                this.$root.msg('warn', responseJson.info)
              } else {
                this.$root.msg('success', responseJson.info)
                this.userStatus.isVote = true
              }
            })
        }

      },
      _verifySupport (obj) {
        var chinaNameReg = /^[\u4e00-\u9fa5]{2,5}$/
        var accountReg = /^(\d){1,3}$/
        var clsidReg = /^(\d){4,}$/
        if (!clsidReg.test(obj.clsid)) {
          this.$root.msg('warn', '非法classid')
          return false
        }
        if (!chinaNameReg.test(obj.fullname)) {
          this.$root.msg('warn', '请填写正确的姓名')
          return false
        }
        if (this.classDetail.clsjoinNum < 10) {
          if (!accountReg.test(obj.clssize)) {
            this.$root.msg('warn', '请填写正确的班级人数')
            return false
          }
        } else {
          if (!chinaNameReg.test(obj.applicanter)) {
            this.$root.msg('warn', '请填写正确的申请人姓名')
            return false
          }
        }

        if (!chinaNameReg.test(obj.headmaster)) {
          this.$root.msg('warn', '请填写正确的班主任姓名')
          return false
        }
      },
      closeAlert () {
        this.alertShow = false
      },
      joinCls () {
        if (this._verifySupport(this.supportPopupData) === false) {
          return
        }
        this.$http.post('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=entrants',
          this.supportPopupData)
          .then(response => {
            var responseJson = response.body
            if (responseJson.state === 'fail') {
              this.$root.msg('warn', responseJson.info)
              if (responseJson.url !== '') {   // 跳转到授权页面
                setTimeout(() => {
                  window.location.href = responseJson.url
                }, 300)
              }
            } else {
              this.$root.msg('success', responseJson.info)
              setTimeout(() => window.location.reload())
            }
          })
      },
      judIsMaster () {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=isMaster&classId=' + this.$route.params.clsId)
          .then(response => {
            var dt = response.body.data
            if (dt === undefined || dt === null) {
              this.$root.msg('warn', response.body.info)
            }
            this.userStatus.isMaster = dt.isMaster
            this.userStatus.isJoin = dt.isJoin
            this.userStatus.isVote = dt.isVote
            this.getDetail()
          })
      },
      getDetail () {
        this.$http.get('http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=classSpecifics&category=' + this.$route.params.clsId)
          .then((response) => {
            let responseBody = response.body
            let resData = responseBody.data
            if (resData !== null) {
              this.classDetail.name = resData.fullname
              this.classDetail.tel = resData.tel
              this.classDetail.wechat = resData.wechat
              this.classDetail.duties = resData.duties
              this.classDetail.school = resData.school
              this.classDetail.grade = this._numToGrade(resData.grade)
              this.classDetail.class = this._formatCls(resData.class)
              this.classDetail.clssize = this._formatCount(resData.clssize)
              this.classDetail.clsjoinNum = resData.clsjoin
              this.classDetail.clssizeNum = resData.clssize
              this.classDetail.headmaster = resData.headmaster
              this.classDetail.slogan = resData.slogan
              this.classDetail.clssong = resData.clssong
              this.classDetail.vote = resData.vote
              this.classDetail.clsintrod = resData.clsintrod
//http://img.huizhou.us/best-class/classList/
              if (resData.classphoto.length != 0) {
                resData.classphoto.forEach(ele => {
                  this.classDetail.classphoto.push('http://img.huizhou.us/best-class/classList/' + ele)
                })
              }
              // 显示alert提示信息
              this.alertShow = true
              this.avatar = resData.photoList
            } else {
              this.$root.msg('warn', '该班级没有创建')
            }
          })
      },
      saveStep3 () {
        this.$http.post(
          'http://huizhou.us/holehole/index.php?g=unitecls&m=applicant&a=step3',
          {
            slogan: this.classDetail.slogan,
            clssong: this.classDetail.clssong,
            clsintrod: this.classDetail.clsintrod
          })
          .then((response) => {
            var responseData = response.body
            if (responseData.state === 'fail') {
              this.$parent.msg('warn', responseData.info)
            } else {
              this.$parent.msg('success', responseData.info)
            }
          }, (e) => {
            this.$parent.msg('cancel', '服务器错误')
          })
      }
    }
  }
</script>
<style lang="less">
  @import "../../less/classSpecifics";
</style>
