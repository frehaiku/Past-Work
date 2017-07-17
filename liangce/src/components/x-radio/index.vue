<style scoped="" lang="less">
    @import "~cssPath/custom";

    .x-radio-wrapper {
        text-align: right;
        float: right;
        color: @fontBlack;
    }

    .x-radio-icon {
        background-size: contain;
        -webkit-background-size: contain;
        display: inline-block;
        width: .32rem;
        height: .32rem;
        vertical-align: sub;
    }

    .x-radio-wrapper label:last-of-type {
        margin-bottom: 0 !important;
    }

    .x-radio-wrapper label:last-of-type i {
        margin-right: 0 !important;
    }

    /*radio默认样式*/
    .x-radio-default {
        background-image: url("~imgPath/defaultCheck.png");
        background-position: center center;
    }

    .x-radio-checked {
        background-image: url("~imgPath/checked.png");
        background-position: center center;
    }

    /*radio 1.8图样式*/
    .x-radio-alignright-default {
        background-image: url("~imgPath/defaultCheck1.8.png");
        background-position: center center;
        margin-right: 0 !important;
    }

    .x-radio-alignright-checked {
        background-image: url("~imgPath/checked1.8.png");
        background-position: center center;
        margin-right: 0 !important;
    }

    .label-default {
        display: inline-block;
    }

    .label-alignright {
        display: block;
        margin-bottom: .3rem;
    }

    input[type=radio] {
        display: none;
    }
</style>

<template>
        <div class="x-radio-wrapper">
            <label v-for="radioItem in data" :class="labelClass">
                <template v-if="isPrepend">
                    <i v-show="currentValue != radioItem" :style="iStyle" :class="unCheckedClass" class="x-radio-icon"
                       alt="未选中"></i>
                    <i v-show="currentValue == radioItem" :style="iStyle" :class="checkedClass" class="x-radio-icon"
                       alt="选中"></i>
                </template>

                <input type="radio"
                       v-model="currentValue"
                       :value="radioItem">{{radioItem}}

                <template v-if="!isPrepend">
                    <i v-show="currentValue != radioItem" :style="iStyle" :class="unCheckedClass" class="x-radio-icon"
                       alt="未选中"></i>
                    <i v-show="currentValue == radioItem" :style="iStyle" :class="checkedClass" class="x-radio-icon"
                       alt="选中"></i>
                </template>
            </label>
        </div>
</template>

<script>
    import xCeil from '../x-ceil'
    export default {
        components: {xCeil},
        props: {
            value: {
                type: String,
                required: true
            },
            // 渲染的数据
            data: {
                type: Array,
                required: true
            },
            // 选择图案是否放在radio前面
            isPrepend: {
                type: Boolean,
                default: true
            },
            // 未选中时的class
            unCheckedClass: {
                type: String,
                default: 'x-radio-default'
            },
            // 选中时的class
            checkedClass: {
                type: String,
                default: 'x-radio-checked'
            },
            labelClass: {
                type: String,
                default: 'label-default'
            }
        },
        computed: {
            iStyle () {
                return this.isPrepend ? {
                    'marginRight': '.13rem',
                    'marginLeft': '.9rem'
                } : {
                    'marginRight': '.9rem',
                    'marginLeft': '.13rem'
                }
            }
        },
        data () {
            return {
                currentValue: this.value
            }
        },
        watch: {
            value (newVal) {
                this.currentValue = newVal
            },
            currentValue (newVal) {
                this.$emit('input', newVal)
                this.$emit('onChange', newVal)
            }
        }
    }
</script>