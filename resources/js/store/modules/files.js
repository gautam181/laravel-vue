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
    sortBy: localStorage.getItem('files_sort_by') || 'id',
    orderBy: localStorage.getItem('files_order_by') || 'asc',
    filters: JSON.parse(localStorage.getItem('files_filters')) || filters.project_files,
    files: [],
    file: [],
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
    getFiles: (state) => { return state.files },
    getTime: (state) => { return state.timeLog },
    getOrderBy: (state) => { return state.orderBy },
    getFilters: (state) => { return state.filters },
    getSortBy: (state) => { return state.sortBy },
    getPagination: (state) => { return state.pagination },
    getPage: (state) => { return state.pagination.page },
}

// actions
const actions = {
    getFiles: (context, mode )=>{
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
        let url = '/files';
        if(context.state.project_id)
            url = '/project/'+context.state.project_id+"/files";
        return new Promise(
            (resolve, reject)=> {
                axios.get(url+"?page=" + context.state.pagination.page + "&orderby=" + context.state.orderBy + "&sortby=" + context.state.sortBy + "&" + params)
                    .then(response => {
                        let res = response.data;
                        context.commit('setAppend', mode);
                        context.commit('setFiles', res.data);
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
    getFile: (context, id) => {
        let file = {};
        axios.get("/file/"+id)
            .then(response => {
                file = response.data;
            });

        return file;
    },
    saveFileDetails: (context, data) => {
        let id = data.id;
        return new Promise((resolve, reject) => {
            axios({
                method: 'put',
                url: '/file/'+id+'/details',
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
    deleteFile: (context, id) => {
        return new Promise((resolve, reject) => {
            axios({
                method: 'delete',
                url: '/files/'+id
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
    setFiles: (state, data) => {
        if (state.append == true){
            data.map((val) => {
                state.files.push(val);
            });
        }
        else
            state.files = data
    },
    setFile: (state, data) => { state.file = data },
    setAppend: (state, val) => { state.append = val },
    setProjectId: (state, id) => { state.project_id = id },
    setPagination: (state, val) => { state.pagination = {...val} },
    setSortBy: (state, val) => { state.sortBy = val; localStorage.setItem('files_sort_by', val); },
    setOrderBy: (state, val) => { state.orderBy = val;localStorage.setItem('files_order_by', val); },
    setFilters: (state, val) => { state.filters = {...val}; localStorage.setItem('files_filters', JSON.stringify(val)); },
    setPage: (state, val) => { state.pagination.page = val;},
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
