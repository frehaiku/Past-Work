import Vue from 'vue'
import Vuex from 'vuex'

import * as actions from './actions'
import * as getters from './getters'
Vue.use(Vuex)

import applicant from './modules/applicant'
import global from './modules/global'
import modify from './modules/modify'
export default new Vuex.Store({
    actions,
    // getters,
    modules: {
        global,
        applicant,
        modify
    }
})
