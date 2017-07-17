<style scoped="" lang="less">
    @import "~cssPath/custom";

    .check-wrapper {
        float: right;
        width: 80%;
    }

    .check-box {
        text-align: right;
    }
</style>

<template>
    <div class="check-wrapper" slot="right">
        <div class="check-box">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    //    import xCeil from '../x-ceil'

    export default {
//        components: {xCeil},
        props: {
            'defaultItemClass': {
                type: String,
                default: 'checker-default-item-class'
            },
            'selectedItemClass': {
                type: String,
                default: 'checker-selected-item-class'
            },
            'disabledItemClass': {
                type: String,
                default: 'checker-disabled-item-class'
            },
            'type': {
                type: String,
                default: 'radio'
            },
            'value': {
                type: [String, Object, Array]
            },
            'max': {
                type: Number,
                default: 1
            }
        },
        data () {
            return {
                currentValue: this.value
            }
        },
        watch: {
            value (val) {
                this.currentValue = val
            },
            currentValue (val) {
                // 回调
                this.$emit('on-change', val)
                this.$emit('input', val)
            }
        }
    }
</script>

