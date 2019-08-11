<template>
    <div>
        <vue-title :title="ticket.title"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Ticket Detail</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <Ticket
                            :ticket="ticket"
                            :desc="desc"
                        ></Ticket>
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
                    v-model="ticket"
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
    export default {
        name: "ticket-detail",
        data(){
            return {
                myRoute : {},
                ticket_id : this.$route.params.id,
                order_by: 'date',
                add_comment: {comment:'', id:''},
                desc: true
            }
        },
        computed:{
            ticket(){
                return this.$store.getters['tickets/getTicket'];
            },
            comments(){
                return this.$store.getters['tickets/getTicketComments'];
            },
            sort(){
                return this.$store.getters['tickets/getSortBy']
            }
        },
        components: {
            Comment, Ticket
        },
        mounted(){
            this.getTicket();
            this.getComments();
            this.$emit('handle-page-header', {label:''});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTicket: function () {
                this.$store.dispatch('tickets/getTicket', this.ticket_id)
            },
            changeCommentSort: function(val){
                console.log("data changed", val);
                this.$store.commit('tickets/setSortBy', val)
                this.getComments();
            },
            getComments: function () {
                this.$store.dispatch('tickets/getTicketComments', this.ticket_id)
            },
            togglePanel: function (id) {
                $(id).find(".showhide i").toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                $(id).find(".panel-body").slideToggle(300);
                $(id).find(".panel-footr").slideToggle(200);
            },
            commentUpdate: function (val) {
                this.getComments();
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
