<template>
    <div>

        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Ticket Detail</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3" v-if="ticket">
                        <vue-title :title="ticket.title"></vue-title>

                        <Ticket
                            :ticket="ticket"
                            :desc="desc"
                        ></Ticket>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Files</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3">
                        <p>file list</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Time Log</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3">
                        <p>No time have been logged against this ticket - <a href="javascript:void(0);" @click="addTime">Log time</a></p>
                        <time-form :id="ticket.id" v-if="time_form" :ticket="ticket"></time-form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Comments</h2>
                    <div class="btn-options text-right">
                        <b-dropdown variant="default" >
                            <template slot="button-content">
                                <strong>Sort By: </strong> Date <span v-show="sort == 'desc'">Descending</span> <span v-show="sort == 'asc'">Ascending</span>
                            </template>
                            <b-dropdown-item-button  v-on:click="changeCommentSort('asc')" :active="sort === 'asc'">Date Ascending</b-dropdown-item-button>
                            <b-dropdown-item-button v-on:click="changeCommentSort('desc')" :active="sort === 'desc'">Date Descending</b-dropdown-item-button>
                        </b-dropdown>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <Comment v-on:commentUpdate="commentUpdate"
                    :author="this.$user"
                    :comment="add_comment"
                    :ticket="ticket"
                    :edit="true"
                ></Comment>
            </div>
            <div class="col-md-12">
                <div class="hpanel forum-box" v-if="comments.length > 0">
                    <template v-for="row in comments">
                        <Comment
                            :author="row.created_by"
                            :comment="row"
                            :ticket="ticket"
                            :edit="false"
                        ></Comment>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Comment from "../../components/util/Comment";
    import Ticket from "../../components/util/Ticket";
    import {mapGetters} from 'vuex';
    import TimeForm from "./forms/TimeForm";
    export default {
        name: "ticket-detail",
        data(){
            return {
                myRoute : {},
                ticket_id : this.$route.params.ticket_id,
                order_by: 'date',
                add_comment: {comment:'', id:''},
                desc: true,
                time_form: false
            }
        },
        created(){
            //this.$eventBus.$emit('header-update', {label:'ticket detail ...'});
            //this.$eventBus.$emit('project-info', this.project_id);
        },
        computed:{
            ...mapGetters({
                sort: 'tickets/getSortBy'
            }),
            comments(){
                return this.$store.getters['tickets/getTicketComments'](this.ticket_id);
            },
            ticket(){
                return this.$store.getters['tickets/getTicket'](this.ticket_id);
            },
        },
        components: {
            Comment, Ticket,  TimeForm
        },
        mounted(){
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'time-form')
                    this.time_form = false;
            })
        },
        methods:{
            addTime: function(){
                this.time_form = true;
            },
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTicket: function (val) {
                this.$store.dispatch('tickets/getTicket', val)
                    .then(res => {
                        this.$eventBus.$emit('project-info', res.project_id);
                    })
            },
            changeCommentSort: function(val){
                this.$store.commit('tickets/setSortBy', val)
                this.getComments(this.ticket_id);
            },
            getComments: function (val) {
                this.$store.dispatch('tickets/getTicketComments', val)
            },
            togglePanel: function (id) {
                $(id).find(".showhide i").toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                $(id).find(".panel-body").slideToggle(300);
                $(id).find(".panel-footr").slideToggle(200);
            },
            commentUpdate: function (val) {
                this.getComments(this.ticket_id);
            }
        },
        beforeRouteUpdate (to, from, next) {
            this.ticket_id = to.params.id;
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            next();
        }
    }
</script>

<style scoped>

</style>
