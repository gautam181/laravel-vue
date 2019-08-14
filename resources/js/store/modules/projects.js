/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sortBy: localStorage.getItem('project_sort_by') || 'asc',
    projects: [],
    pagination: {
        page: 1,
        totalPages: 0,
        totalRows: 0,
        perPage: 0
    }
}

// getters
const getters = {
    getProjects: (state) => { return state.projects },
    getPagination: (state) => { return state.pagination },
    getPage: (state) => { return state.pagination.page },
}

// actions
const actions = {
    getProjects: (context )=>{
        axios.get("/projects?page="+context.state.pagination.page)
            .then(response => {
                let res = response.data;
                context.commit('setProjects', res.data);
                context.commit('setPagination', {totalPages: res.last_page, totalRows: res.total, page: res.current_page, perPage: res.per_page});
            });
    },
}

// mutations
const mutations = {
    setProjects: (state, projects) => { state.projects = projects },
    setPagination: (state, val) => { state.pagination = {...val} },
    setPage: (state, val) => { state.pagination.page = val },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
