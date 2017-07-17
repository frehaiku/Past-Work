<template>
	<div class="caWrap bgWhite">
		<p class="top">共同申请人与贷款人关系</p>
		<div class="addContent" @touchend="changePerson(0)">
			<img class="leftIcon" src="~imgPath/couple.png"/>
			夫妻
			<img class="fr rightIcon" v-show='checkPerson==0' src="~imgPath/checked.png"/>
		</div>
		<div class="addContent" @touchend="changePerson(1)">
			<img class="leftIcon" src="~imgPath/couple.png"/>
			子女
			<img class="fr rightIcon" v-show='checkPerson==1' src="~imgPath/checked.png"/>
		</div>
		<div class="addContent" @touchend="changePerson(2)">
			<img class="leftIcon" src="~imgPath/couple.png"/>
			父母
			<img class="fr rightIcon" v-show='checkPerson==2' src="~imgPath/checked.png"/>
		</div>
		<div class="addContent" @touchend="changePerson(3)">
			<img class="leftIcon" src="~imgPath/couple.png"/>
			非直系亲属
			<img class="fr rightIcon" v-show='checkPerson==3' src="~imgPath/checked.png"/>
		</div>
	</div>
</template>

<script>
	import {mapGetters} from 'vuex'
	export default{
		data(){
			return{
				checkPerson:0
			}
		},
		computed: {
			...mapGetters([
					'roles',
					'appliantMsg'
			])
		},
		methods:{
			// e为index
			changePerson(e){
				this.checkPerson=e;
				let params = Object.assign({}, this.$router.params,
						{step: 1, role: this.roleKey(this.roles[e+1])}
				)
				this.$router.push({name: 'fillInform', params})
			},
			/*为key加索引，因为同个角色有可能选择多次子女*/
			roleKey (role) {
				const router = this.$route.params,
						group = router.group

				if (this.appliantMsg[group]) {
					return role + Object.keys(this.appliantMsg[group])
									.filter(ele => new RegExp(role).test(ele)).length
				} else {
					return role + '0'
				}
			}
		}
	}
</script>

<style scoped lang="less">
.caWrap{
	padding: 0.2rem;
	margin-top: 0.2rem;
	padding-bottom: 2rem;
	.top{
		line-height: 1.2rem;
		font-size: 0.3rem;
	}
	.addContent{
		padding: 0.35rem;
		height: 0.7rem;
		line-height: 0.7rem;
		box-shadow: 0 0 10px #fff2f2;
		margin-top: 0.2rem;
		position: relative;
		.leftIcon{
			height: 0.7rem;
			vertical-align: middle;
			margin-right: 0.4rem;
		}
		.rightIcon{
			width: 0.46rem;
			position: absolute;
			right: 0.4rem;
			top: 50%;
			transform: translateY(-50%);
		}
		font-size:0.3rem;
	}
}
</style>