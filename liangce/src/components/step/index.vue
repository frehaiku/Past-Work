<template>
	<div class="wrap tac">
		<!--标题
		<p>
			{{content}}
		</p>-->
		<slot></slot>
		<div class="step" v-if='stepOrder>=1' v-show="stepShow">
			<div class="line"></div>
			<div class="redLine" v-bind:style="{width:(stepOrder-1)*(2.11)+'rem'}"></div>
			<div class="stepNum " :class="[stepOrder>=1?'active':'']">1</div>
			<div class="stepNum" :class="[stepOrder>=2?'active':'']">2</div>
			<div class="stepNum" :class="[stepOrder>=3?'active':'']">3</div>
			<div class="stepNum" :class="[stepOrder>=4?'active':'']">4</div>
		</div>
		
	</div>
</template>

<script>
	export default{
		data(){
			return{
				
			}
		},
		props: {
			// 当前第几步
			stepOrder: {
				type: [Number, String],
				default: 1
			},
			// 步骤进度条是否显示
			stepShow: {
				type: Boolean,
				default: true
			}
		}
	}
</script>

<style scoped lang="less">
@import "~cssPath/custom.less";
.wrap{
	width: 6.34rem;
		margin: 0 auto;
		margin-bottom: 20px;
		background-color: #F4F4F4;
	p{
		font-size: 0.26rem;
		color: @fontGray;
		line-height: 1rem;
		
	}
	.step{
		position: relative;
		height: 0.6rem;
		.line,.redLine{
			height: 0.12rem;
			width: 100%;
			position: absolute;
			top: 0.28rem;
			background: @stepPink;
			
		}
		.redLine{
			background: @stepPinkActive;
		}
		.stepNum{
			position: absolute;
			width: 0.6rem;
			height: 0.6rem;
			background: @stepPink;
			line-height: 0.6rem;
			border-radius: 50%;
			color: #ffafa9;
			box-shadow: 0px 0px 10px @stepPink;
			&:nth-child(3){
				left: 0;
			}
			&:nth-child(4){
				left: 33%;
				transform: translateX(-50%);
			}
			&:nth-child(5){
				left: 66%;
				transform: translateX(-50%);	
			}
			&:nth-child(6){
				right: 0;
			}
		}
		.active{
			background: @stepPinkActive;
			color: white;
			box-shadow: 0px 0px 10px @fontDeepRed;
		}
	}
}

</style>