<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Time Log</h2>
                    <div class="btn-options text-right">
                        <button class="btn btn-md btn-outline-success" ><i class="fa fa-plus-circle"></i> Add Time</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="alert alert-filter">
                    <i class="fa fa-bolt"></i> Showing xxx filtered results <button  class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Clear Filter</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <div>xxx results</div>
                    <div class="btn-options text-right">
                        <b-dropdown variant="default" size="sm">
                            <template slot="button-content">
                                <strong>Sort By: </strong> Project Name
                            </template>

                        </b-dropdown>
                        <button class="btn btn-default btn-sm"><i class="fa fa-arrow-down"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket';

    export default {
        name: "project-time",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project: {},
                tickets: [],
                ticketList: true,
                showAddTicket: false,
                blankTicket: {
                    project: {id:this.$route.params.id},
                    title: '', description: '',
                    assigned_to: {id:'', name: ''}
                }
            }
        },
        created(){
            this.$eventBus.$emit('project-info', this.project_id);
        },
        watch: {

        },
        components: {
            Ticket
        },
        mounted(){

        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
        },
        beforeRouteUpdate (to, from, next) {
            /*this.project_id = to.params.id;
            this.getProject(this.project_id);
            this.getTickets(this.project_id);*/
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
