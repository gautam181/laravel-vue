/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sortBy: localStorage.getItem('comment_sort_by') || 'asc',
    comments: []
}

// getters
const getters = {
    getComments: (state) => { return state.comments }
}

// actions
const actions = {
    getComment: (context, id) => {
        let comment = {};
        axios.get("/comment/"+id)
            .then(response => {
                comment = response.data;
            });

        return comment;
    },
    saveComment: (context, data) => {
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
    deleteComment: (context, id) => {
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
    setTickets: (state, tickets) => { state.tickets = tickets },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
