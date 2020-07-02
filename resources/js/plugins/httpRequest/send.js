import ConfigHttpRequest from '../../../configs/httpRequest';
import headers from "./header";

async function send(query, driver){
    // Отправка запроса и обработка ответа
    return await ConfigHttpRequest.drivers[driver || 'default'](query);
}

export default send;
