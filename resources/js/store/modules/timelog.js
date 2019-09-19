/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';
import filters from "../../config/Filters";

// initial state
const state = {
    sortBy: localStorage.getItem('time_sort_by') || 'id',
    orderBy: localStorage.getItem('time_order_by') || 'asc',
    filters: JSON.parse(localStorage.getItem('time_filters')) || filters.project_time,
    timeLog: [],
    timeLogs: [],
    append: false,
    project_id: 0,
    pagination: {
        page: 1,
        totalPages: 0,
        totalRows: 0,
        perPage: 0
    }
}

// getters
const getters = {
    getTime: (state) => { return state.timeLog },
    getTimeLog: (state) => { return state.timeLogs },
    getOrderBy: (state) => { return state.orderBy },
    getFilters: (state) => { return state.filters },
    getSortBy: (state) => { return state.sortBy },
    getPagination: (state) => { return state.pagination },
    getPage: (state) => { return state.pagination.page },
}

// actions
const actions = {
    getTimeLog: (context, mode )=>{
        let params = Object.keys(context.state.filters).map( key => {
            let val = context.state.filters[key];
            if (Array.isArray(val)){
                let owners = Object.keys(val).map(i => {
                    if (i > 0)
                        return val[i].id;
                    return val[i].id;
                } );
                key += '='+owners;
            }
            else if (typeof(val) === 'object')
                key  += '='+ val.id;
            else if (typeof(val) === 'array'){

            }
            else
                key  += '='+ val;
            return key;
        }).join('&');
        let url = '/time-log';
        if(context.state.project_id)
            url = '/project/'+context.state.project_id+"/time";
        return new Promise(
            (resolve, reject)=> {
                axios.get(url+"?page=" + context.state.pagination.page + "&orderby=" + context.state.orderBy + "&sortby=" + context.state.sortBy + "&" + params)
                    .then(response => {
                        let res = response.data;
                        context.commit('setAppend', mode);
                        context.commit('setTimeLog', res.data);
                        context.commit('setPagination', {
                            totalPages: res.last_page,
                            totalRows: res.total,
                            page: res.current_page,
                            perPage: res.per_page
                        });
                        resolve(true);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
    },
    getTime: (context, id) => {
        let comment = {};
        axios.get("/time-log/"+id)
            .then(response => {
                comment = response.data;
            });

        return comment;
    },

    saveTime: (context, data) => {
        let id = data.id;
        return new Promise((resolve, reject) => {
            axios({
                method: id ? 'put' : 'post',
                url: '/time-log'+(id ? '/'+id : ''),
                data: data.body
            }).
                then(function (response) {
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        });
    },
    deleteTime: (context, id) => {
        return new Promise((resolve, reject) => {
            axios({
                method: 'delete',
                url: '/time-log/'+id
            }).
            then(function (response) {
                resolve(response);
            })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        });
    },
}

// mutations
const mutations = {
    setTimeLog: (state, rows) => {
        if (state.append == true){
            rows.map((val) => {
                state.timeLogs.push(val);
            });
        }
        else
            state.timeLogs = rows
    },
    setTime: (state, data) => { state.timeLog = data },
    setAppend: (state, val) => { state.append = val },
    setProjectId: (state, id) => { state.project_id = id },
    setPagination: (state, val) => { state.pagination = {...val} },
    setSortBy: (state, val) => { state.sortBy = val; localStorage.setItem('time_sort_by', val); },
    setOrderBy: (state, val) => { state.orderBy = val;localStorage.setItem('time_order_by', val); },
    setFilters: (state, val) => { state.filters = {...val}; localStorage.setItem('time_filters', JSON.stringify(val)); },
    setPage: (state, val) => { state.pagination.page = val;},
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
