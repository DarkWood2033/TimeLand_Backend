import replacer from './replacer';

/**
 * @param routes
 * @param name
 * @param segmentsFlag
 * @returns {{method: *, url: *}}
 */
function routing(routes, name, segmentsFlag = null){
    let segments = name.split('.');
    let current = routes;
    let count = segments.length;

    for(let i = 0; i < count; i++){
        current = current[segments[i]];
    }

    return {
        url: replacer(current.url, segmentsFlag),
        method: current.method
    };
}

export default routing;
