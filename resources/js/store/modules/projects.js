/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sortBy: JSON.parse(localStorage.getItem('ticket_sort_by')) || 'asc',
    comments: []
}

// getters
const getters = {
    //getUser(state){return state.user}
}

// actions
const actions = {
    updateProfile(context, data){
        return new Promise((resolve, reject) => {
            axios.post('/update-profile', data)
                .then(response => {
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
        })
    }
}

// mutations
const mutations = {
    setOauth(state, oauth) {
        state.oauth = oauth
    },
    setUser(state, user) {
        Object.assign(state.user = user)
    },
    setName(state, name){
        state.user.name= name;
    },
    destroyToken(state) {
        state.oauth = null;
        state.user = {};
    }

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
