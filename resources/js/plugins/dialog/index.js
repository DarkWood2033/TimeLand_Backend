export default (store) => {
    return {
        alert: ({ title, message }, { type, btnText = '' } = false) => {
            store.dispatch('system/addDialog', {
                method: 'alert',
                title: title,
                message: message,
                design: { type, btnText }
            });
        },
        confirm: ({ title, message, accept }, { type, btnText = '', btnTextCancel = '' }  = false) => {
            if(typeof accept !== 'function') console.error('У диалогово окна свойство "accept" не является функцией');
            store.dispatch('system/addDialog', {
                method: 'confirm',
                title: title,
                message: message,
                accept: accept,
                design: { type, btnText, btnTextCancel }
            });
        },
        prompt: ({ title, message, accept,  cancel, form, data }, { type, btnText = '' }  = false) => {
            if(typeof accept !== "function") console.error('У диалогово окна свойство "accept" не является функцией');
            if(typeof cancel !== "function") console.error('У диалогово окна свойство "cancel" не является функцией');
            store.dispatch('system/addDialog', {
                method: 'prompt',
                title: title,
                message: message,
                accept: accept,
                cancel: cancel,
                form: form,
                data: data,
                design: { type, btnText }
            });
        }
    };
}
