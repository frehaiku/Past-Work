<style scoped="" lang="less">

</style>

<template>
    <div :class="className"
    @click="select">
        <slot></slot>
    </div>

</template>

<script>
    export default {
        props: {
            value: {
                type: [String, Number, Object],
                required: true
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            className () {
                const isSimpleValue = typeof this.value === 'string' || typeof this.value === 'number'
                const names = {
                    'checker': !this.disabled
                }

                if (this.$parent.defaultItemClass) {
                    names[this.$parent.defaultItemClass] = true
                }

                if (this.$parent.selectedItemClass) {
                    let selected = false
                    if (this.$parent.type === 'radio') {
                        if (isSimpleValue && this.$parent.currentValue === this.value) {
                            selected = true
                        } /*else if (typeof this.value === 'object' && isEqual(this.$parent.currentValue, this.value)) {
                            selected = true
                        }*/
                    } else {
                        if (typeof this.value === 'string') {
                            if (this.$parent.currentValue.indexOf(this.value) > -1) {
                                selected = true
                            }
                        }/* else if (this.$parent.currentValue && this.$parent.currentValue.length) {
                            const match = this.$parent.currentValue.filter(one => {
                                return isEqual(one, this.value)
                            })
                            selected = match.length > 0
                        }*/
                    }
                    names[this.$parent.selectedItemClass] = selected
                }

                if (this.$parent.disabledItemClass) {
                    names[this.$parent.disabledItemClass] = this.disabled
                }

                return names
            }
        },
        methods: {
            select () {
                const parent = this.$parent,
                pVal = parent.value,
                nonceVal = this.value

                let index

                if (this.disabled) return;

                if (parent.type === 'radio') {
                    parent.currentValue = nonceVal
                }
                // 复选框
                else if (parent.type === 'checkbox'){
                    index = parent.currentValue.indexOf(nonceVal);
                    if (index !== -1) {
                        parent.currentValue.splice(index, 1)
                    } else {
                        // 超过了最大选择数
                        if (parent.max === pVal.length) {
                            parent.currentValue.pop()
                        }
                        parent.currentValue.push(nonceVal)
                    }
                }
                // 点击item回调
                this.$emit('on-item-click', this.value, this.disabled)
            }
        }
    }
</script>

