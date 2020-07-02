import Vue from 'vue';

export default {
    state: {
        dialogs: []
    },
    mutations: {
        ADD_DIALOG(state, data){
            Vue.set(state.dialogs, state.dialogs.length, data);
        },
        DELETE_DIALOG(state, id){
            state.dialogs.splice(id, 1);
        }
    },
    actions: {
        addDialog({commit}, data) {
            commit('ADD_DIALOG', data);
        },
        deleteDialog({commit}){
            commit('DELETE_DIALOG', 0);
        }
    },
    getters: {
        dialog: (state) => state.dialogs[0] || null
    },
}
