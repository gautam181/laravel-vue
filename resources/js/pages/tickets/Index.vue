<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Ticket List</h2>
                    <b-pagination v-on:change="paginate"
                                  :page="page"
                                  :total-rows="totalRows"
                                  :per-page="perPage"
                                  align="right"
                    ></b-pagination>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <div v-if="$route.name == 'tickets'" class="tickets-list">
                            <template v-for="row in tickets" >
                                <Ticket
                                    :ticket="row"
                                    :list=ticketList
                                ></Ticket>
                                <!--<div class="col-md-12" :id="'ticket_'+row.id">
                                    <div class="hpanel hgreen">
                                        <div class="panel-body">
                                            <div class="row" v-if="!row.edit">
                                                <div class="col-sm-8 col-md-10">
                                                    <h5>
                                                        <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': row.id }}" active-class="" class="">
                                                            {{ row.title }}
                                                        </router-link>
                                                    </h5>
                                                    <p>
                                                        {{ row.description}}
                                                    </p>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="project-label">DEADLINE</div>
                                                            <small>{{ row.end_date }}</small>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="project-label">Assigned To</div>
                                                            <small v-if="row.assigned_to">{{ row.assigned_to.name }}</small>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="project-label">Created By</div>
                                                            <small v-if="row.created_by">{{ row.created_by.name }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-md-2 project-info">
                                                    <div class="project-action m-t-md">
                                                        <div class="btn-group">
                                                            <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': row.id }}" active-class="" class="btn btn-xs btn-default">
                                                                View
                                                            </router-link>
                                                            <button class="btn btn-xs btn-default" v-on:click="editTicket(row.id)"> Edit</button>
                                                            <button class="btn btn-xs btn-default" v-on:click="deleteTicket(row.id)"> Delete</button>
                                                        </div>
                                                    </div>
                                                    <div class="project-value">
                                                        <h2 class="text-success">
                                                            TotalHours
                                                        </h2>
                                                    </div>
                                                    <div class="project-people">
                                                        &lt;!&ndash;<img alt="logo" class="img-circle" src="images/a1.jpg">&ndash;&gt;
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" v-if="row.edit">

                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                            </template>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <b-pagination v-on:change="paginate"
            :page="page"
            :total-rows="totalRows"
            :per-page="perPage"
            align="right"
        ></b-pagination>
    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket'
    export default {
        name: "ticket-index",
        data(){
            return {
                myRoute : {},
                formTitle: 'Edit Project',
                showForm: false,
                showDelete: false,
                ticketList: true
            }
        },
        components: {
            Ticket
        },
        computed:{
            tickets(){
                return this.$store.getters['tickets/getTickets'];
            },
            page(){
                return this.$store.getters['tickets/getPage'];
            },
            perPage(){
                return this.$store.getters['tickets/getPerPage'];
            },
            totalPages(){
                return this.$store.getters['tickets/getTotalPages'];
            },
            totalRows(){
                return this.$store.getters['tickets/getTotalRows'];
            }
        },
        mounted(){
            this.$emit('handle-page-header', {label:''});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            if(this.$route.name == 'tickets')
                this.projects = this.getTickets();
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTickets: function () {
                this.$store.dispatch('tickets/getTickets');
            },
            editTicket: function(id){
                this.formTitle = 'Edit Project';
                this.showForm = true;
            },
            deleteTicket: function(id){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete ticket?', {
                    title: 'Please Confirm',
                    size: 'md',
                    buttonSize: 'sm',
                    titleTag: 'h4',
                    modalClass: 'hmodal-danger',
                    okVariant: 'danger',
                    cancelVariantVariant: 'default',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if (value){
                            this.$store.dispatch('tickets/deleteTicket', id)
                                .then(res =>{
                                    $("#ticket_"+id).hide();
                                })
                                .catch(error => {
                                    console.log(error)
                                });
                        }

                    })
                    .catch(err => {
                        // An error occurred
                    })
            },
            paginate: function (val) {
                this.$store.commit('tickets/setPage', val);
                this.getTickets();
            }

        }
    }
</script>

<style scoped>

</style>
