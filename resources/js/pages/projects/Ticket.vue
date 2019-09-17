<template>
    <div>
        <vue-title v-if="ticket" :title="ticket.title+ ' - '+ ticket.project.name"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Ticket Detail</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3" v-if="ticket">
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
                        <file-list></file-list>
                        <div>
                            <br>
                            <a href="javascript:void(0);" class="text-green"> Manage Attachments</a>
                        </div>
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
                        <div v-if="time_entries.length > 0">
                            <div class="total-filter">
                                <div class="section">
                                    <strong>Time Totals: </strong>
                                </div>
                                <div class="section">
                                    <span class="text-muted">Logged:</span>
                                    <span>{{ getTotalHours() }}</span>
                                </div>
                                <div class="section">
                                    <span class="text-muted">Estimated:</span>
                                    <span>10 hours (10.00)</span>
                                </div>
                                <div class="action-btns">
                                    <button name="add-time" class="btn btn-sm btn-success" @click="addTime"> <i class="fa fa-plus"></i> Add More Time</button>
                                </div>
                            </div>
                            <time-list :time_entries="time_entries"></time-list>
                            <a href="javascript:void(0);" class="text-green" @click="addTime">Add more time</a>
                        </div>
                        <p v-else>No time have been logged against this ticket - <a href="javascript:void(0);" @click="addTime">Log time</a></p>
                        <time-form :id="ticket.id" v-if="time_form" :project_id="ticket.project.id" :ticket="ticket"></time-form>
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
    import FileList from "../../components/ui/FileList";
    import TimeList from "../../components/ui/TimeList";


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
            time_entries(){
                return this.$store.getters['tickets/getTicketTimes'](this.ticket_id);
            },
            ticket(){
                return this.$store.getters['tickets/getTicket'](this.ticket_id);
            },
        },
        components: {
            Comment, Ticket,  TimeForm, FileList, TimeList
        },
        mounted(){
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            this.getTimes(this.ticket_id);
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            this.$eventBus.$on('timeUpdate', (data)=> {
                console.log(data);
                this.getTimes(this.ticket_id);
            });
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
            getTimes: function (val) {
                this.$store.dispatch('tickets/getTicketTimes', val)
            },

            getHours: function(h, m){
                return ((h*60 + m)/60).toFixed(2);
            },
            getTotalHours: function(){
                let sum = this.time_entries.reduce((s, f) => {
                    return s + (f.hours*60) + f.minutes;
                }, 0);
                let hrs = (sum/60).toFixed(2);
                let m = (sum%60);
                let h = ((sum-m)/60).toFixed(0);
                let ts = '';
                if (h > 0)
                    ts += h + ' hours ';
                if (m > 0)
                    ts += m + ' minutes ';

                ts += ' ('+hrs+')';
                return ts;//{'hours': hrs, 'time': { 'hours': h, 'minutes': m}};
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
