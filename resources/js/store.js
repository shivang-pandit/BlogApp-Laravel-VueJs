import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        deleteModalObj : {
            showDeleteModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false,
        },
        user: false,
        permission: false,
        perPage:2,
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteModalObj
        },
        getPermission(state) {
            return state.permission
        },
        getPerPage(state) {
            return state.perPage
        },
    },
    mutations: {
        setDeleteModal(state,data) {            
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl: '',
                data: null,
                deletingIndex: state.deleteModalObj.deletingIndex,
                isDeleted: data,
            }
            state.deleteModalObj = deleteModalObj
        },
        setDeleteModalProperty(state, data) {            
            state.deleteModalObj = data
        },
        closeModal(state) {            
            state.deleteModalObj.showDeleteModal = false
        },
        setUser(state, user) {
            state.user = user
        },
        setPermission(state, permission) {
            state.permission = permission
        }
    },
    actions: {

    }
})