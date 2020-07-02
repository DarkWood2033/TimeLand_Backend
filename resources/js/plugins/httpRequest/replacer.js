
function replacer(url, segments){
    // Если требуется замена сегмента в url, меняем
    if(url.match(/{/)){
        // Обрабатываем, в зависимости что было передана в качестве сегмента
        if(Array.isArray(segments)){
            return replaceFlagArray(url, segments);
        }else if(typeof segments == 'object'){
            return replaceFlagObject(url, segments);
        }else{
            return replaceFlagDefault(url, segments);
        }
    }

    // Проверяем, после преобразования все сегменты получили значение
    if(url.match(/{/)){
        throw new Error('Не все сегменты получили значение');
    }

    // Иначе просто вернуть url
    return url;
}

function replaceFlagArray(url, segments){
    let counter = 0; // счётчик массива
    // Если есть что заменить, заменяем
    while(url.match(/{/)){
        // Проверяем на наличие сегмента в массиве
        if(!segments[counter]) {
            throw new Error('Не достаточно передан сегментов для url');
        }
        // Меняем
        url = url.replace(/{.*?}/, segments[counter]);
        counter++;
    }

    // Проверяем все ли сегмены поставлены
    if(segments.length !== counter){
        throw new Error('Сегментов больше передан, чем требуется');
    }

    return url;
}

function replaceFlagObject(url, segments){
    // Меняем сегменты в соотвествие ключ - значения
    for(let prop in segments){
        let oldUrl = url;
        url = url.replace(`{${prop}}`, segments[prop]);

        // Проверяем есть ли изменения, то есть не лишний ли ствойства
        if(oldUrl === url){
            throw new Error('Сегментов больше передан, чем требуется');
        }
    }

    return url;
}

function replaceFlagDefault(url, segment){
    return url.replace(/{.*?}/, segment);
}

export default replacer;
