<template>
    <div class="wrap bgWhite">
        <div class="inner ">
            <i></i>
            <input type="text" name="" id="" :value="keyWord" v-on:input="updateValue($event.target.value)"
                   placeholder="请输入关键字搜索"/>
        </div>

    </div>
</template>

<script>
    export default{
        data(){
            return {
//				keyWord:'3434'
            }
        },
        props: ['keyWord'],
        methods: {
            updateValue(value){
                var myValue = value; //将输入的文本框内容传来
                this.$emit('changeValue', myValue); //自定义事件，并传参
            }
        }
    }
</script>

<style scoped lang="less">
    @import "~cssPath/custom.less";

    .wrap {
        padding: 0.15rem;

    .inner {
        padding: 0.2rem;
        border-radius: 5px;
        overflow: hidden;
        background: #ffefe5;

    input {
        float: right;
        height: 0.4rem;
        border: none;
        outline: none;
        text-align: center;
        width: 5.5rem;
        border-right: 1px solid #ceaba6;
        background: #ffefe5;

    }

    i {
        float: right;
        width: 0.3rem;
        height: 0.3rem;
        background: url(~imgPath/search.png) no-repeat;
        background-size: 100% 100%;
        margin: 0 0.2rem;
        margin-top: 0.05rem;
        margin-left: 0.4rem;
    }

    }
    }
</style>