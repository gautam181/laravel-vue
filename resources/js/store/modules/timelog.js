/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sortBy: localStorage.getItem('time_sort_by') || 'asc',
    timeLog: []
}

// getters
const getters = {
    getTime: (state) => { return state.timeLog }
}

// actions
const actions = {
    getTime: (context, id) => {
        let comment = {};
        axios.get("/comment/"+id)
            .then(response => {
                comment = response.data;
            });

        return comment;
    },
    getTicketTime: (context, data)=>{
        let id = data.id;
        return new Promise((resolve, reject) => {
            axios({
                method: id ? 'put' : 'post',
                url: '/comment'+(id ? '/'+id : ''),
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
                url: '/comment/'+id
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
    setTime: (state, data) => { state.timeLog = data },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
