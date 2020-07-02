import Vue from 'vue';
import _ from 'lodash';

export default (localization) => {
    window.$t = function (key, args) {
        let value = _.get(localization, key);

        if (typeof value === 'undefined') {
            console.warn(`Localization key '${key}' not found.`);

            return key;
        }

        _.eachRight(args, (paramVal, paramKey) => {
            value = _.replace(value, `:${paramKey}`, paramVal);
        });
        return value;
    };

    return window.$t;
}

Vue.prototype.$t = window.$t;
