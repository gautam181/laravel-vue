/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:49
 */
import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import users from './modules/users'
import comments from './modules/comments'
import projects from './modules/projects'
import tickets from './modules/tickets'
import config  from '../config/Settings'

Vue.use(Vuex);

axios.defaults.baseURL = config.baseURL+config.APIVersion;
axios.defaults.withCredentials = false;
axios.defaults.crossdomain = false;
axios.defaults.responseType = 'json';
axios.defaults.headers.post['Accept'] = 'application/json';
axios.defaults.headers.get['Accept'] = 'application/json';

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        comments,
        projects,
        tickets,
        users
    },
    strict: debug
})
