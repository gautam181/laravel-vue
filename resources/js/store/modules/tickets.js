/**
 * Created by PhpStorm.
 * User: Abdul
 * Date: 05/08/2019
 * Time: 22:51
 */

import axios from 'axios';

// initial state
const state = {
    sort_by: localStorage.getItem('ticket_comment_sort_by') || 'asc',
    tickets: [],
    ticket_comments: [],
    page: 1,
    totalPages : 0,
    totalRows : 0,
    perPage: 0
};

// getters
const getters = {
    getTickets: (state) => { return state.tickets },
    getTicket: (state, id) => { return state.tickets.find(ticket => ticket.id === id); },
    getSortBy: (state) => { return state.sort_by },
    getPage: (state) => { return state.page },
    getTotalPages: (state) => { return state.totalPages },
    getPerPage: (state) => { return state.perPage },
    getTotalRows: (state) => { return state.totalRows },
    getTicketComments: (state) => { return state.ticket_comments }
};

// actions
const actions = {
    getTickets: (context )=>{
        axios.get("/tickets?page="+context.state.page)
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
    setTicket: (state, val) => {
        let id = val.id;
        const ticket= state.tickets.find(ticket => ticket.id === id);
        //state.tickets[tindex] = {...state.tickets[tindex], ...val};
        ticket.title =  val.title;
        ticket.description =  val.description;
        ticket.start_date =  val.start_date;
        ticket.end_date =  val.end_date;
    },
    setPerPage: (state, val) => { state.perPage = val },
    setTotalPages: (state, val) => { state.totalPages = val },
    setTotalRows: (state, val) => { state.totalRows = val },
    setPage: (state, val) => { state.page = val },
    setTicketComments: (state, val) => {
        state.ticket_comments[val.id] = val.comments
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
