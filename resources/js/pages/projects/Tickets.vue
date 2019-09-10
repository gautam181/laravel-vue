<template>
    <div>
        <div >
            <div class="row">
                <div class="col-md-12">
                    <div class="list-options">
                        <h2 class="">Tickets</h2>
                        <div class="btn-options text-right">
                            <button class="btn btn-md btn-success" @click="addTicket" ><i class="fa fa-plus-circle"></i> Add Ticket</button>
                        </div>

                    </div>
                </div>
                <div class="col-md-12" >
                    <filter-alert :total="pagination.totalRows" :show="!showFilters" id="project-tickets-list"></filter-alert>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel forum-box">
                        <div class="panel-body">
                            <loading-spinner label="Loading tickets" :show="loading"></loading-spinner>
                            <Ticket v-if="showAddTicket"
                                    :ticket="blankTicket" :view="!showAddTicket" v-on:cancel="cancelTicket"
                            ></Ticket>
                            <div class="tickets-list" v-if="loaded">
                                <template v-if="tickets.length > 0">
                                    <template v-for="row in tickets">
                                        <Ticket
                                            :ticket="row"
                                            :list=ticketList
                                        ></Ticket>
                                    </template>
                                </template>
                                <template v-else-if="!showFilters">
                                    <blank-slate name="project-tickets-list"></blank-slate>
                                </template>
                                <template v-else>
                                    <blank-slate name="project-tickets" v-if="!showAddTicket">
                                        <template slot="body">
                                            <h3>No Tickets</h3>
                                            <p>Hey {{ this.$user.name }}, you don't have any ticket on this project. Click the button below to create a ticket.</p>
                                            <button class="btn btn-lg btn-primary" @click="addTicket"> <i class="fa fa-plus-circle"></i> Create a new ticket</button>
                                        </template>
                                    </blank-slate>
                                </template>
                            </div>
                            <load-more :pagination="pagination" v-on:load-more="loadMore"></load-more>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Ticket from '../../components/util/Ticket';
    import LoadMore from "../../components/ui/LoadMore";
    import FilterAlert from "../../components/ui/FilterAlert";
    import BlankSlate from "../../components/ui/BlankSlate";

    export default {
        name: "project-tickets",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project: {},
                loaded: false,
                loading: false,
                ticketList: true,
                showAddTicket: false,
                blankTicket: {
                    project: {id:this.$route.params.id},
                    title: '', description: '',
                    assigned_to: {id:'', name: ''}
                }
            }
        },
        computed:{
            tickets: function () {
                return this.$store.getters['tickets/getTickets'];
            },
            showFilters: function () {
                return _.isEqual(this.$filters.project_tickets, this.filters);
            },
            pagination: function () {
              return {
                  page: this.currentPage,
                  totalPages: this.totalPages,
                  totalRows: this.totalTickets,
                  perPage: this.perPage
              };
            },
            ...mapGetters({
                filters: 'tickets/getFilters',
                totalTickets: 'tickets/getTotalRows',
                totalPages: 'tickets/getTotalPages',
                currentPage: 'tickets/getPage',
                perPage: 'tickets/getPerPage',
            })
        },
        watch: {

        },
        components: {
            Ticket, LoadMore, FilterAlert, BlankSlate
        },
        created(){
            this.$eventBus.$emit('project-info', this.project_id);
            this.$store.commit('tickets/setProjectId', this.project_id);
            this.$eventBus.$on('project-tickets-loading', val => {
                this.loading = val;
            });
        },
        mounted(){
            this.getTickets();
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            addTicket: function(){
              this.showAddTicket = true;
            },
            cancelTicket:function(){
                this.showAddTicket = false;
            },
            loadMore: function(){
                this.$store.commit('tickets/setPage', this.currentPage+1);
                this.getTickets(true);
            },
            getTickets: function (val) {
                this.$store.commit('projects/setPage', 1);
                let mode = val != undefined ? val : false;
                this.$eventBus.$emit('project-tickets-loading', true);
                this.$store.dispatch('tickets/getTickets', mode)
                    .then(res => {
                        this.loaded = true;
                        this.loading = false;
                    })
                    .catch(e => {
                        this.loading = false;
                    });
            },
        },
        beforeRouteUpdate (to, from, next) {
            this.project_id = to.params.id;
            this.getProject(this.project_id);
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
