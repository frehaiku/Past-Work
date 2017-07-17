/**
 * Created by frehaiku on 2017/5/31.
 */
const state = {
    loadStatus: 0,
    navTitle: '按揭系统'
}
const getters = {
    loadStatus (state) {
        return state.loadStatus
    }
}
const mutations = {
    SHOW_LOADING (state) {
        state.loadStatus = 1
    },
    HIDE_LOADING (state) {
        state.loadStatus = 0
    }
}

export default {
    state,
    getters,
    mutations
}