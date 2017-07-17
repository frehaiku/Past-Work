<template lang="html">
  <div>
    <div class="addList">
      <div class="upLayer" :style="{backgroundImage: `url( ${preview || dataUrl} )`}">

      </div>
      <div class="chooseLayer" v-show='!(preview || dataUrl)'>
        <label class="cross" :for="inputId"></label>
        <input class="ImgPicker"
               type="file"
               @change="handleFileChange"
               name="" :id="inputId"
               value=""/>
        <p>选择图片上传</p>
      </div>
      <label class="reload" :for="inputId" v-show='!readonly && preview || dataUrl'>修改</label>
    </div>
  </div>
</template>

<script>
  import {fetchAPI} from '../../libs/fetch'
  export default {
    props: {
      indexOf: Number,
      preview: String,
      readonly: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        inputId: "",
        dataUrl: ""
      }
    },
    methods: {

      gengerateID() {
        let nonstr = Math.random().toString(36).substring(3, 8);
        if (!document.getElementById(nonstr)) {
          return nonstr
        } else {
          return this.gengerateID()
        }
      },
      handleFileChange(e) {
        // 在获取到文件对象进行预览
        this.imgPreview(e.target.files[0]);
      },
      imgPreview(file) {
        let self = this;
        if (!file || !window.FileReader) return

        if (/^image/.test(file.type)) {

          let reader = new FileReader();
          reader.readAsDataURL(file);

          reader.onloadend = function () {
            self.dataUrl = this.result;

            let img = new Image();
            img.src = this.result;

            img.onload = function () {
              let data = self.compressImg(this)
              self.dataUrl = data; //压缩后的图片 data

              //处理图片，上传后台
              data = data.split(',')[1];
              data = window.atob(data);
              var ia = new Uint8Array(data.length);
              for (var i = 0; i < data.length; i++) {
                ia[i] = data.charCodeAt(i);
              }
              //canvas.toDataURL 返回的默认格式就是 image/png
              const blob = new Blob([ia], {
                type: "image/jpeg"
              });
              let fd = new FormData();
              fd.append("uploadFile", blob);
              fd.append('accountName', 'alex')
              fd.append('password', '123456')

              // 上传图片
              self.$interfaces.upload(self, fd)
                      .then(response => {
                        self.$emit('on-upload', {
                          path: response.url,
                          index: self.indexOf,
                          previews: self.dataUrl
                        })
                      })
            }
          }

        } else {
          alert("请选择图片文件")
        }
      },
      compressImg(img) { //压缩图片data
        var initSize = img.src.length;
        var width = img.width;
        var height = img.height;

        //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
        var ratio;
        if ((ratio = width * height / 4000000) > 1) {
          ratio = Math.sqrt(ratio);
          width /= ratio;
          height /= ratio;
        } else {
          ratio = 1;
        }
        var canvas = document.createElement('canvas');
        var tCanvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var tctx = tCanvas.getContext('2d');
        canvas.width = width;
        canvas.height = height;

        //        铺底色
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        //如果图片像素大于100万则使用瓦片绘制
        var count;
        if ((count = width * height / 1000000) > 1) {
          count = ~~(Math.sqrt(count) + 1); //计算要分成多少块瓦片

          // 计算每块瓦片的宽和高
          var nw = ~~(width / count);
          var nh = ~~(height / count);

          tCanvas.width = nw;
          tCanvas.height = nh;

          for (var i = 0; i < count; i++) {
            for (var j = 0; j < count; j++) {
              tctx.drawImage(img, i * nw * ratio, j * nh * ratio, nw * ratio, nh * ratio, 0, 0, nw, nh);

              ctx.drawImage(tCanvas, i * nw, j * nh, nw, nh);
            }
          }
        } else {
          ctx.drawImage(img, 0, 0, width, height);
        }

        //进行最小压缩
        var ndata = canvas.toDataURL('image/jpeg', 0.6);
//        console.log(ndata)
//        console.log('压缩前：' + initSize);
//        console.log('压缩后：' + ndata.length);
//        console.log('压缩率：' + ~~(100 * (initSize - ndata.length) / initSize) + "%");
        return ndata;
      }
    },
    mounted() {
      this.inputId = this.gengerateID();
    }
  }
</script>

<style lang="less" scoped>
  @import "~cssPath/_uploadList.less";

  .addList {
    position: relative;

  .reload {
    position: absolute;
    right: 10px;
    bottom: 10px;
    color: #0081ff;
  }

  }

  .upLayer {
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center center;
  }

  .chooseLayer {

  p {
    color: #0081ff;
  }

  }

  .ImgPicker {
    position: absolute;
    left: -9999px;
  }
</style>