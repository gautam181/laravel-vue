import Vue from 'vue';
import {isNull} from "bootstrap-vue/esm/utils/inspect";
import moment from "moment";
import settings from "./config/Settings";
//filters
Vue.filter('fulldate', (val)=> {
    if (isNull(val))
        return '';

    return val? moment(val).format(settings.FULLDATEFROMAT): '';
});

Vue.filter('date', (val)=> {
    if (isNull(val))
        return '';

    return val? moment(val).format(settings.DATEFROMAT): '';
});

Vue.filter('time', (val)=> {
    if (isNull(val))
        return '';

    return val? moment(val, 'HH:mm:ss').format(settings.TIMEFROMAT): '';
});

Vue.filter('formDate', (val)=> {
    if (isNull(val))
        return '';
    return val? moment(val, 'YYYY-MM-DD').format(settings.FORMDATEFROMAT): '';
});
Vue.filter('sqlDate', (val)=> {
    if (isNull(val))
        return '';
    return val? moment(val, settings.FORMDATEFROMAT).format('YYYY-MM-DD'): '';
});
