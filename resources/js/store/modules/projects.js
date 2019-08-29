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
    filters: JSON.parse(localStorage.getItem('projects_filters')) || {
        'keyword': '',
        'created_dates':{
            'start_date': '',
            'end_date': ''
        },
        'created_range':{id: '0', value: 'Any Time'},
        'due_dates':{
            'start_date': '',
            'end_date': ''
        },
        'due_date_range':{id: '0', value: 'Any Time'},
    },
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
    getFilters: (state) => { return state.filters },
    getProject: (state)=>(id) => { return state.projects.find(project => project.id == id); },
    getPagination: (state) => { return state.pagination },
    getPage: (state) => { return state.pagination.page },
}

// actions
const actions = {
    getProjects: (context )=>{
        let params = '';//getFilters();
        axios.get("/projects?page="+context.state.pagination.page + "&"+params)
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
    setFilters: (state, val) => { state.filters = val; localStorage.setItem('projects_filters', JSON.stringify(val)); },
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
