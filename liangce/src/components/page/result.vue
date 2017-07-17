<template>
	<div class=" ">
		<div class=" wrap bgWhite">
			<div class="subTitle">
				<span class="ft28 fw borderLeft"> 初评结果</span>
				<router-link tag="span" class="fr ft26 blue" to="initialReport">查看初评报告</router-link>
				<!--<span class="fr ft26 blue">查看初评报告</span>-->
			</div>
			<div class="tac  sbContent">
				<p>
					<span class=" ft26">评估单价</span>:
					<span class="deepRed">36500</span>
					<span class="ft24">元/方</span></p>
				<p class="ft24">（总价约和：365万）</p>
			</div>
		</div>
		<div class=" wrap bgWhite">
			<div class="subTitle">
				<span class="ft28 fw borderLeft"> 口价结果</span>
			</div>
			<div class="tac  sbContent">
				<p>
					<span class=" ft26">评估单价</span>:
					<span class="deepRed">36500</span>
					<span class="ft24">元/方</span></p>
				<p class="ft24">（总价约和：365万）</p>
			</div>
		</div>
		<div class=" wrap bgWhite">
			<div class="subTitle">
				<span class="ft28 fw borderLeft"> 物业信息</span>
			</div>
			<div class="romInf">
				<p>
					<span class="gray">省/市/区</span>
					<span class="fr">广东省 广州市 天河区</span>
				</p>
				<p>
					<span class="gray">楼盘名称</span>
					<span class="fr">羊城创意园</span>
				</p>
				<p>
					<span class="gray"> 楼盘地址</span>
					<span class="fr">黄埔大道中309号自编号3-22</span>
				</p>
				<p>
					<span class="gray">楼栋</span>
					<span class="fr">3-22 栋</span>
				</p>
				<p>
					<span class="gray">屋/室</span>
					<span class="fr">201</span>
				</p>
				<p>
					<span class="gray">面积</span>
					<span class="fr">150 m2</span>
				</p>
			</div>
			<div class="open">
				展开
				<img src="~imgPath/down.png"/>
			</div>
		</div>
	</div>
</template>

<script>
	import search from '../search/index.vue'
	export default {
		data() {
			return {

			}
		},
		components: {

		},
		methods: {

		}
	}
</script>

<style scoped lang="less" rel="stylesheet/less">
	@import "~cssPath/custom.less";
	.wrap {
		padding: 0.2rem;
		margin-top: 0.2rem;
		position:relative;
		.subTitle {
			padding: 0.3rem 0;
			border-bottom: 1px solid #F4F4F4;
		}
		.sbContent {
			line-height: 0.6rem;
			padding: 0.3rem;
			.deepRed {
				font-size: 0.46rem;
			}
		}
		.romInf{
			line-height: 0.55rem;
			padding: 0.2rem;
		}
	}
	.open{
		position: absolute;
		bottom: 0.2rem;
		left: 50%;
		transform: translateX(-50%);
		color:@fontYellow ;
		img {
			width: .22rem;
		}
	}
</style>