<style scoped="" rel="stylesheet/less" lang="less">
    @import "~cssPath/custom";
    img.smSuccess {
        height: 2.8rem;
    }
    .success-font {
        text-align: center;
        margin-top: .3rem;font-size: .34rem;
        color: @fontDeepGray;font-weight: bold;}
    p.success-desc{
        margin-top: .3rem;
        text-align: center;font-size: .24rem;
        color: @fontDeepGray;}
    p.p-pink {
        margin-top: .27rem;font-size: .3rem;
        text-align: center;
        color: @fontPink;}
    #btn-wrap {
        /*margin-left: .95rem;*/
        padding-top: .9rem;
        padding-bottom: .9rem;
        text-align: center;
        button {
            outline: none;
            border-radius: .15rem;
            font-size: .24rem;
            text-align: center;
            width: 2.4rem;
            height: .7rem;
        }
        button:nth-of-type(1) {
            border: 1px solid @fontShallowGray;
            background: #ffffff;
            color: @fontBlack;

        }
        button:nth-of-type(2) {
            margin-left: .8rem;
            background: @fontPink;
            color: #ffffff;
            border:1px solid @fontPink;
        }

    }
</style>

<template>
    <div class="wrapper bgWhite">
        <img src="~imgPath/submitSuccess.png" alt="" class="smSuccess">
        <p class="success-font">提交成功</p>
        <p class="success-desc">小良已收到您的房屋按揭贷款申请</p>
        <p class="success-desc">我们将有专人与您联系，请耐心等待！</p>
        <p class="success-desc p-pink">关注良策金融微信号：gdliangce</p>
        <p class="success-desc">可及时收到最新进度提醒</p>

        <div id="btn-wrap">
            <router-link to="/home">
                <button class="to-index">返回首页</button>
            </router-link>

            <router-link to="/applyList">
                <button class="look-my-apply">查看我的申请</button>
            </router-link>
        </div>
    </div>
</template>