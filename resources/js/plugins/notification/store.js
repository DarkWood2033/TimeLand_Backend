import Vue from 'vue';

export default {
    state: {
        notifications: []
    },
    mutations: {
        ADD_NOTIFICATION(state, notification){
            notification.id = +new Date() + Math.random();
            Vue.set(state.notifications, state.notifications.length, notification);
        },
        DELETE_NOTIFICATION(state, id){
            let e_id = state.notifications.findIndex(item => {
                if(item.id === id){
                    return true;
                }
            });

            if(e_id !== -1){
                Vue.delete(state.notifications, e_id);
            }
        }
    },
    actions: {
        addNotification({ state, commit }, notification){
            commit('ADD_NOTIFICATION', notification);
        },
        deleteNotification({ state, commit }, id){
            commit('DELETE_NOTIFICATION', id);
        }
    },
    getters: {
        notifications: state => state.notifications
    }
};
