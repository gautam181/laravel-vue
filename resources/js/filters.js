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
Vue.filter('min2hours', (mins)=>{
    let str = '';
    let minutes = mins%60;
    let hours = (mins-minutes)/60;
    if (hours)
        str += hours+' hour' + (hours > 1 ? 's ': ' ');
    if (minutes)
        str += minutes+' minute'+ (minutes > 1 ? 's ': ' ');

    return str;
});
Vue.filter('prettyBytes', function (num) {
    // jacked from: https://github.com/sindresorhus/pretty-bytes
    if (typeof num !== 'number' || isNaN(num)) {
        throw new TypeError('Expected a number');
    }

    let exponent;
    let unit;
    let neg = num < 0;
    let units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    if (neg) {
        num = -num;
    }

    if (num < 1) {
        return (neg ? '-' : '') + num + ' B';
    }

    exponent = Math.min(Math.floor(Math.log(num) / Math.log(1024)), units.length - 1);
    num = (num / Math.pow(1024, exponent)).toFixed(2) * 1;
    unit = units[exponent];

    return (neg ? '-' : '') + num + ' ' + unit;
});
