/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';
import Vue from 'Vue';

// initial state
const state = {
    sort_by: localStorage.getItem('ticket_comment_sort_by') || 'asc',
    tickets: [],
    ticket_comments: [],
    filters: JSON.parse(localStorage.getItem('tickets_filters')) || {
        'keyword': '',
        'start_date': '',
        'end_date': '',
        'created_range':{id: '0', value: 'Any Time'},
        'due_start_date': '',
        'due_end_date': '',
        'due_date_range':{id: '0', value: 'Any Time'},
        'assigned_to':[],
    },
    project_id: 0,
    page: 1,
    totalPages : 0,
    totalRows : 0,
    perPage: 0
};

// getters
const getters = {
    getTickets: (state) => { return state.tickets },
    getProjectId: (state) => { return state.project_id },
    getTicket: (state)=>(id) => { return state.tickets.find(ticket => ticket.id == id); },
    getFilters: (state) => { return state.filters },
    getSortBy: (state) => { return state.sort_by },
    getPage: (state) => { return state.page },
    getTotalPages: (state) => { return state.totalPages },
    getPerPage: (state) => { return state.perPage },
    getTotalRows: (state) => { return state.totalRows },
    getTicketComments: (state) =>(id) => { const comments = state.ticket_comments.find(comment => comment.id == id); return comments ? comments.comments : []; }
};

// actions
const actions = {
    getTickets: (context )=>{
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
        let url = '/tickets';
        if(context.state.project_id)
            url = '/project/tickets/'+context.state.project_id;

        axios.get(url+"?page="+context.state.page+ "&"+params)
            .then(response => {
                let res = response.data;
                context.commit('setTickets', res.data);
                context.commit('setTotalPages', res.last_page);
                context.commit('setTotalRows', res.total);
                context.commit('setPage', res.current_page);
                context.commit('setPerPage', res.per_page);
            });
    },
    getTicket: (context, id) => {
        axios.get("/ticket/"+id)
            .then(response => {
                context.commit('setTicket', response.data);
            });
    },
    saveTicket: (context, data) => {
        let id = data.id;
        return new Promise((resolve, reject) => {
            axios({
                method: id ? 'put' : 'post',
                url: '/ticket'+(id ? '/'+id : ''),
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
    updateDates: (context, data) => {
        let id = data.id;
        return new Promise((resolve, reject) => {
            axios({
                method: 'put',
                url: '/ticket/'+id+'/dates',
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

    deleteTicket: (context, id) => {
        return new Promise((resolve, reject) => {
            axios({
                method: 'delete',
                url: '/ticket/'+id
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
    getTicketComments: (context, id) => {
        axios.get("/ticket/"+id+'/comments?sort='+context.state.sort_by)
            .then(response => {
                context.commit('setTicketComments', {'id': id,  'comments':response.data.data});
            });
    }
};

// mutations
const mutations = {
    setTickets: (state, tickets) => { state.tickets = tickets },
    setProjectId: (state, id) => { state.project_id = id },
    setTicket: (state, val) => {
        let id = val.id;
        const ticket= state.tickets.find(ticket => ticket.id === id);
        if (ticket){
            ticket.title =  val.title;
            ticket.description =  val.description;
            ticket.start_date =  val.start_date;
            ticket.end_date =  val.end_date;
            ticket.assigned_to = val.assigned_to;
        } else {
            state.tickets.push(val);
        }

    },
    setFilters: (state, val) => { state.filters = {...val}; localStorage.setItem('tickets_filters', JSON.stringify(val)); },
    setPerPage: (state, val) => { state.perPage = val },
    setTotalPages: (state, val) => { state.totalPages = val },
    setTotalRows: (state, val) => { state.totalRows = val },
    setPage: (state, val) => { state.page = val },
    setTicketComments: (state, val) => {
        let id = val.id;
        const cmts= state.ticket_comments.find(comments => comments.id == id);
        if(cmts){
            //cmts.comments = {...cmts, ...val};
            Vue.set(cmts, 'comments', [...val.comments]);
        } else
            state.ticket_comments.push(val)
    },
    setDates: (state, val ) =>{
        let id = val.id;
        const ticket = state.tickets.find(ticket => ticket.id === id);
        ticket.start_date = val.start_date;
        ticket.end_date = val.end_date
    },
    setSortBy: (state, sortby) => {
        state.sort_by = sortby;
        localStorage.setItem('ticket_comment_sort_by', sortby);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
