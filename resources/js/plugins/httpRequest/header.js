import ConfigHttpRequest from '../../../configs/httpRequest';

function headers(){
    authSignIn();
}

/**
 * Установливает авторизованность пользователя
 */
function authSignIn(){
    let token = localStorage.getItem(
        ConfigHttpRequest.tokens.auth
    );

    ConfigHttpRequest.drivers.defaults = {headers: {common: {}}};
    if(token){
        ConfigHttpRequest.drivers.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    }else{
        ConfigHttpRequest.drivers.defaults.headers.common['Authorization'] = null;
    }
}

export default headers;
