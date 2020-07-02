const DEFAULT_TIME = null;

export default store => {
    return {
        notify(title, message, time = DEFAULT_TIME, type = 'primary'){
            store.dispatch('system/addNotification', {
                title: title,
                message: message,
                time: time,
                type: type
            })
        },
        primary(title, message, time = DEFAULT_TIME){
            this.notify(title, message, time, 'primary');
        },
        secondary(title, message, time = DEFAULT_TIME){
            this.notify(title, message, time, 'secondary');
        },
        success(title, message, time = DEFAULT_TIME){
            this.notify(title, message, time, 'success');
        },
        error(title, message, time = DEFAULT_TIME){
            this.notify(title, message, time, 'error');
        },
        warning(title, message, time = DEFAULT_TIME){
            this.notify(title, message, time, 'warning');
        },
        info(title, message, time = DEFAULT_TIME){
            this.notify(title, message, time, 'info');
        }
    }
};
