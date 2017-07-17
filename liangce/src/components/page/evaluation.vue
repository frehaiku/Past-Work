<template>
    <div id="">
        <search :keyWord="searchContent" @changeValue="changeValue"></search>
        <ul>
            <router-link tag="li" to="result">
                <div class="left ">
                    <p><span class="location">华南碧桂园</span> <span class="num">编t号：2016092905</span></p>
                    <p class="dizhi">广州天河区迎宾路559-567号</p>
                </div>
                <div class="right">
                    2016-09-17
                    <img src="~imgPath/rightArrow.png"/>
                </div>
            </router-link>
            <li>
                <div class="left ">
                    <p><span class="location">华南碧桂园</span> <span class="num">编t号：2016092905</span></p>
                    <p class="dizhi">广州天河区迎宾路559-567号</p>
                </div>
                <div class="right">
                    2016-09-17
                    <img src="~imgPath/rightArrow.png"/>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import search from '../search/index.vue'
    export default{
        data(){
            return {
                searchContent: ""
            }
        },
        components: {
            search
        },
        methods: {
            changeValue(value){
                console.log(value)
                this.searchContent = value;
            }
        }
    }

</script>

<style scoped lang="less">
    @import "~cssPath/custom.less";

    ul {

        margin-top: 20px;

    li {
        margin-bottom: 1px;
        background: white;
        padding: 0.2rem;
        position: relative;

    p:nth-child(1) {
        margin-bottom: 0.1rem;
    }

    .left {
        width: 70%;

    .location {
        font-size: 0.26rem;
        font-weight: bold;
        margin-right: 10px;
    }

    .num {
        font-size: 0.24rem;
        color: @fontGray;
    }

    .dizhi {
        font-size: 0.24rem;
    }

    }
    .right {
        position: absolute;
        right: 0.2rem;
        top: 50%;
        transform: translateY(-50%);
        width: 30%;
        font-size: 0.22rem;
        text-align: right;
        color: @fontGray;

    img {
        width: 0.14rem;
        margin-left: 10px;
    }

    }
    }
    }
</style> 