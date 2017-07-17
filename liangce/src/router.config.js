const home = resolve => require(['./components/page/home.vue'], resolve)
const fillInform = resolve => require(['./components/page/fillInform.vue'], resolve)
const uploadList = resolve => require(['./components/page/uploadList.vue'], resolve)
const upload = resolve => require(['./components/page/upload.vue'], resolve)
const uploadImg = resolve => require(['./components/page/uploadImg.vue'], resolve)
const evaluation = resolve => require(['./components/page/evaluation.vue'], resolve)
const result = resolve => require(['./components/page/result.vue'], resolve)
const initialReport = resolve => require(['./components/page/initialReport.vue'], resolve)
const applyList = resolve => require(['./components/page/applyList.vue'], resolve)
const commonApply = resolve => require(['./components/page/commonApply.vue'], resolve)

const applyDisplay = resolve => require(['./components/page/applyDisplay.vue'], resolve)
const applyInform = resolve => require(['./components/page/applyInform.vue'], resolve)
const applyInformItem = resolve => require(['./components/page/applyInformItem.vue'], resolve)
const photoInform = resolve => require(['./components/page/photoInform.vue'], resolve)
const addUpload = resolve => require(['./components/page/addUpload.vue'], resolve)
const submitSuccess = resolve => require(['./components/page/submitSuccess.vue'], resolve)
const showImgList = resolve => require(['./components/page/showImgList.vue'], resolve)

export const routes = [

    {
        path: '/home',
        component: home
    },
    // 填资料
    {
        path: '/fillInform/productId/:product/step/:step/groupId/:group/roleId/:role',
        name: 'fillInform',
        component: fillInform
    },
    //上传照片资料
    {
        path: '/uploadList/productId/:product/groupId/:group/roleId/:role',
        name: 'uploadList',
        component: uploadList
    },
    {
        path: '/upload',
        component: upload
    },
    {
        path: '/uploadImg/productId/:product/groupId/:group/roleId/:role/item/:item',
        component: uploadImg,
        name: 'uploadImg'
    },
    {
        path: '/evaluation',
        component: evaluation
    },
    // 3.1客户订单（银行审通过，待补资料）
    {
        path: '/applyDisplay/order/:orderId/product/:productId',
        name:"applyDisplay",
        component: applyDisplay
    },
    // 3.2申请人资料 （不可修改） 拷贝
    {
        path: '/applyInform/order/:orderId/product/:productId',
        name:"applyInform",
        component: applyInform
    },
    // 3.3申请人资料
    {
        path: '/applyInformItem',
        component: applyInformItem
    },
    // 3.4图片资料（其他资料待上传）
    {
        path: '/photoInform',
        component: photoInform
    },
    // 3.5上传资料（上传其他资料）
    {
        path: '/addUpload',
        component: addUpload
    },
    // 4.9.6提交成功
    {
        path: '/submitSuccess',
        component: submitSuccess
    },
    {
        path: '/result',
        component: result
    },
    {
        path: '/initialReport',
        component: initialReport
    },
    {
        path: '/applyList',
        component: applyList
    },
    {
        path: '/showImgList',
        component: showImgList
    },
    {
        path: '/commonApply/groupId/:group/productId/:product',
        name: 'commonApply',
        component: commonApply
    },
    {
        path: '*',
        redirect: '/home'
    }
]
