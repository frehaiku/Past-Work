<template>
	<div id="">
		<p class="tac top">1、身份证正反面（夫妻二人）</p>
		<div class="bgWhite example tac">
			<img src="~imgPath/example.jpg"/>
		</div>
		<div class="secondPart bgWhite">
			<div class="addList listBg3">
				<div class="upLayer bgBlue">
					
				</div>
				<div class="chooseLayer">
					<div class="cross"></div>
					<p>上传主贷款人身份证正面照</p>
				</div>
			</div>
			<div class="addList listBg4">
				<div class="upLayer bgBlue">
					
				</div>
				<div class="chooseLayer">
					<div class="cross"></div>
					<p>上传主贷款人身份证正面照</p>
				</div>
			</div>
			<div class="addList listBg1">
				<div class="upLayer ">
					
				</div>
				<div class="chooseLayer">
					<div class="cross"></div>
					<p>上传主贷款人身份证正面照</p>
				</div>
			</div>
			<div class="addList listBg2">
				<div class="upLayer">
					
				</div>
				<div class="chooseLayer">
					<div class="cross"></div>
					<p>上传主贷款人身份证正面照</p>
				</div>
			</div>
			<ImgInput></ImgInput>
			<ImgInput></ImgInput>
		</div>
		<input @click="nextUpload" type="button" name="" id="" value="下一步：上传户口簿" class="nextStep" />
	</div>
	
</template>

<script>
	import ImgInput from "../ImgInput/index.vue"
    export default {
    	components:{
    		ImgInput
    	},
        methods: {
            nextUpload () {
                this.$router.push({path: 'evaluation'})
            }
        }
    }
</script>

<style lang="less" scoped>
	@import "~cssPath/custom";
	@import "~cssPath/_uploadList.less";
	.top{
		line-height: 1.1rem;
		color: @fontGray;
	}
	.example{
		padding: 0.2rem 0;
		img{
			width:6.74rem;
		}
	}
	.listBg3{
		background: url(~imgPath/sfz.png) center no-repeat;
		background-size:43% auto;
	}
	.listBg4{
		background: url(~imgPath/sfzBack.png) center no-repeat;
		background-size:43% auto;
	}
	.listBg1{
		background: url(~imgPath/humer1.png) center no-repeat;
		background-size:43% auto;
	}
	.listBg2{
		background: url(~imgPath/humer2.png) center no-repeat;
		background-size:43% auto;
	}
	.nextStep{
		margin-bottom: 1rem;
	}
</style>
