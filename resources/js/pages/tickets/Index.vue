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
                        <!--<Ticket></Ticket>-->
                        <div v-if="$route.name == 'tickets'" class="tickets-list">

                            <template v-for="row in tickets">
                                <Ticket
                                    :ticket="row"
                                    :list=ticketList
                                ></Ticket>
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
    import Ticket from '../../components/util/Ticket';
    import { mapGetters } from 'vuex';
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
            ...mapGetters({
                tickets: 'tickets/getTickets',
                page: 'tickets/getPage',
                perPage: 'tickets/getPerPage',
                totalPages: 'tickets/getTotalPages',
                totalRows: 'tickets/getTotalRows',
            })
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
