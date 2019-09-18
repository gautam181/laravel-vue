/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sortBy: localStorage.getItem('files_sort_by') || 'asc',
    files: [],
    projectFiles: [],
    ticketFiles: []
}

// getters
const getters = {
    getFiles: (state) => { return state.files }
}

// actions
const actions = {
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
                url: '/file/'+id
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
