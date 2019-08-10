/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sortBy: localStorage.getItem('user_sort_by') || 'asc',
    usersList: []
}

// getters
const getters = {
    getUsersList: (state) => { return state.usersList }
}

// actions
const actions = {
    getUsersList: (context )=>{
        axios.get("/users/list")
            .then(response => {
                context.commit('setUsersList', response.data);
            });
    },
    saveUser: (context, data) => {
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
    }
}

// mutations
const mutations = {
    setUsersList: (state, users) => { state.usersList = users },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
