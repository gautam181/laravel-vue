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
    getProject: (state)=>(id) => { return state.projects.find(project => project.id == id); },
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
    getProject: (context, id) => {
        return new Promise((resolve, reject) => {
            axios.get("/project/" + id)
                .then(response => {
                    context.commit('setProject', response.data);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    saveProject: (context, data )=>{
        let id = data.id;
        return new Promise((resolve, reject) => {
            axios({
                method: id ? 'put' : 'post',
                url: '/project'+(id ? '/'+id : ''),
                data: data.body
            }).
            then(function (response) {
                resolve(response);
            })
                .catch(error => {
                    reject(error);
                });
        });
    },
}

// mutations
const mutations = {
    setProjects: (state, projects) => { state.projects = projects },
    setPagination: (state, val) => { state.pagination = {...val} },
    setPage: (state, val) => { state.pagination.page = val },
    setProject: (state, val) => {
        let id = val.id;
        const project= state.projects.find(ticket => ticket.id === id);
        if (project){
            project.name =  val.name;
            project.description =  val.description;
            project.start_date =  val.start_date;
            project.end_date =  val.end_date;
            project.owner = val.owner;
        } else {
            state.projects.push(val);
        }

    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
