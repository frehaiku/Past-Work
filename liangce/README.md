# 实习项目：贷款审批系统

> 主贷款人选择贷款产品后，需要填写贷款信息，便于放款方对其信任度进行核查。填写完，在客服未处理前可以修改信息  
 除了主申请人外，还可以添加多个（夫妻、子女、父母、非直系亲属）角色的共同申请人和担保人（也就是根据资料的详细程度和真实性来衡量申请人的贷款金额）  
 <a href="http://lc.hkuboss.cn/#/home" target="_blank">作品浏览地址<a>

## 目录结构

```
├─src
│  │  App.vue
│  │  main.js
│  │  router.config.js / 路由配置
│  ├─api / 后台接口定义
│  ├─assets
│  │  ├─css            
│  │  └─images 
│  ├─components
│  │  ├─checker / 自定义选择框
│  │  ├─datePicker / 引入的datePicker
│  │  ├─ImgInput / 上传图片组件
│  │  ├─page / 路由页面组件
│  │  │      applyDisplay.vue / 订单状态展示
│  │  │      applyInform.vue / 查看已填写的申请人列表
│  │  │      applyInformItem.vue / 查看订单详细信息(处理中状态时可修改)
│  │  │      applyList.vue / 订单列表
│  │  │      commonApply.vue / 增加共同申请人或担保人（两种角色）
│  │  │      fillInform.vue / 填各角色申请资料
│  │  │      home.vue / 首页（展示产品列表）
│  │  │      showImgList.vue / 修改时的图片资料列表展示
│  │  │      submitSuccess.vue / 申请信息提交成功跳转页
│  │  │      upload.vue / 原本上传图片页（改需求后没用了）
│  │  │      uploadImg.vue / uploadList和showImgList点进来上传图片页面
│  │  │      uploadList.vue / 填写时的图片资料列表展示
│  │  ├─picker / 引入的picker
│  │  ├─popup / 引入的popup
│  │  ├─popup-picker / 引入的popup-picker
│  │  ├─search / 原订单列表的搜索框(需求改成不需要这个框)
│  │  ├─step / 填写表单步骤的step
│  │  ├─toast / 自定义toast组件
│  │  ├─topic / 自定义标题栏组件
│  │  ├─x-address / 引入的address
│  │  ├─x-ceil / 自定义ceil组件
│  │  ├─x-form
│  │  │      abstractTpl.vue / 填写申请信息时的formTpl
│  │  │      applyInformTpl.vue / 修改信息时的formTpl
│  │  ├─x-input / 自定义input组件
│  │  ├─x-radio / 自定义radio组件
│  │  └─x-select / 自定义select组件
│  ├─datas / JSON数据
│  ├─filters / 过滤器
│  ├─libs
│  │      base.js
│  │      config.js / 全局配置，注入vue实例，用this.$config即可取值
│  │      extend.js / 对象深复制
│  │      fetch.js / fetch请求的封装
│  │      mixin_uuid.js
│  │      navMap.js / 导航标题config
│  │      plugin_helper.js
│  │      rem.js / rem适配
│  ├─mixins
│  │      scrollTop.js
│  ├─plugins /全局插件
│  └─store / Vuex相关
│      │  actions.js
│      │  getters.js
│      │  index.js
│      └─modules
│              applicant.js
│              global.js
│              modify.js
│─webpack.config.js /webpack构建配置
├.babelrc /babel配置项               
│─package.json /lib包依赖             
    
```

## 技术栈

- WebPack + ES6 + Vue2.x + Vue-Router + Vuex + Vue-Loader

## TODO

一些代码写的不够优雅，目前在不断地重构中!
