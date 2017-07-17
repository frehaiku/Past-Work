<template>
	<div class="bgWhite" style="margin-top: 1.3rem;padding:0.2rem">

		<div class="siWrap"
				 v-for="imgItem in imgArr"
				 :style="`background: url(${$config.httpPrefix}${imgItem}) no-repeat center;background-size: contain;`">
			</div>
		<p v-show="errorShow" style="text-align: center;">没上传图片资料</p>
	</div>
	
</template>

<script>
	import {mapGetters} from 'vuex'

	export default {
		computed: {
			...mapGetters([
				'activeDatum',
				'activeRole'
			]),
			imgArr () {
				let item = this.$route.params.item,
					key = item.split('（')[0]
				try {
					return this.activeDatum[this.activeRole + item][key].split(',') || []
				} catch (e) {
					this.errorShow = 1
				}
			}
		},
		data() {
			return {
				errorShow: 0
			}
		},
		methods: {}
	}
</script>

<style lang="less" scoped>
	.siWrap{		
		height: 3rem;
		margin-bottom: 0.2rem;
	    border-radius: 0.1rem;
		border: 1px dashed #0081ff;
		text-align: center;
		img{
			width: 80%;
		}
	}
</style>